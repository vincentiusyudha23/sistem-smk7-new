<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\OrangTua;
use App\Models\KelasSiswa;
use App\Models\TokenQrCode;
use Illuminate\Support\Str;
use App\Imports\KelasImport;
use App\Imports\SiswaImport;
use App\Models\KelasJurusan;
use Illuminate\Http\Request;
use App\Models\PresensiMasuk;
use App\Models\PresensiPulang;
use App\Exports\PresensiExport;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login()
    {   
        return view('admin.page.login');
    }
    public function index()
    {   
        $siswa = Siswa::count() ?? 0;
        $presensiMasuk = PresensiMasuk::whereDate('created_at',Carbon::today())->count() ?? 0; 
        $presensiPulang = PresensiPulang::whereDate('created_at',Carbon::today())->count() ?? 0;
        
        if($presensiMasuk > 0){
            $persen_hadir = $presensiMasuk/$siswa * 100;
        } else {
            $persen_hadir = 0;
        }

        // Ambil data dari Senin hingga Jumat pada minggu ini
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();
        
        $presensi = PresensiMasuk::whereBetween('created_at', [$startDate, $endDate])
                            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                            ->groupBy('date')
                            ->get();
        
        // Isi data kosong untuk hari yang tidak ada presensinya
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $weeklyData = [];

        foreach ($days as $day) {
            $weeklyData[$day] = 0; // Set default value to 0
        }

        foreach ($presensi as $item) {
            $dayName = Carbon::parse($item->date)->isoFormat('dddd');
            if (in_array($dayName, $days)) {
                $weeklyData[$dayName] = $item->count;
            }
        }
        
        return view('admin.page.dashboard.dashboard', compact('siswa','presensiMasuk','presensiPulang','persen_hadir','weeklyData'));
    }

    public function register()
    {
        return view('admin.page.register');
    }

    public function akun_siswa()
    {
        $kelas = KelasJurusan::orderBy('nama_kelas', 'asc')->get();

        $siswas = Siswa::orderBy('created_at', 'desc')->with('orangTua')->get();
        
        $siswas = $siswas->map(function($item){
            $all_kelas = KelasJurusan::pluck('nama_kelas','id_kelas')->toArray();
            
            return [
                'id_siswa' => $item->id_siswa,
                'nama' => $item->nama,
                'nis' => $item->nis,
                'username' => $item->users->username,
                'password' => $item->password,
                'kelas' => $item->getKelas()?->nama_kelas ?? '',
                'all_kelas' => $all_kelas,
                'id_kelas' => $item->kelas?->id_kelas ?? '',
                'tanggal_lahir' => $item->tanggal_lahir->format('Y-m-d'),
                'orang_tua' => $item->orangTua->nama,
                'nomor_telp' => $item->orangTua->nomor_telepon
            ];
        });

        return view('admin.page.siswa.kelola_siswa', compact('kelas','siswas'));
    }

    public function akun_mapel()
    {
        $mapels = Mapel::orderBy('created_at', 'desc')->get();
        return view('admin.page.mapel.kelola_mapel', compact('mapels'));
    }

    public function presensi()
    {
        $dataPresensiPerHari = [];

        for ($i = 0; $i < 7; $i++) {
            // Mengambil tanggal yang sesuai
            $tanggal = Carbon::today()->subDays($i);
            
            // Mengambil data presensi untuk tanggal tersebut
            $presensiMasuk = PresensiMasuk::whereDate('created_at', $tanggal)->count();
            $presensiPulang = PresensiPulang::whereDate('created_at', $tanggal)->latest();
            
            $dataPresensiPerHari[$tanggal->isoFormat('dddd, DD/MM/YYYY')] = $presensiMasuk;
        }

        $siswas = Siswa::orderBy('nama', 'asc')->pluck('nama', 'id_siswa')->toArray();
        
        $kelas = KelasJurusan::orderBy('created_at', 'desc')->pluck('nama_kelas', 'id_kelas')->toArray();

        $jurusans = KelasJurusan::select('jurusan')->distinct()->pluck('jurusan')->toArray();

        return view('admin.page.presensi.kelola_presensi', compact('dataPresensiPerHari','siswas','kelas','jurusans'));
    }

    public function download_data_presensi(Request $request)
    {
        $options = $request->options ?? 0;

        $presensi = PresensiMasuk::orderBy('created_at', 'desc');

        if($options == 0){
            $presensi = $presensi->get();
        }

        if($options == 1){
            $from_date = $request->dateFrom;
            $to_date = $request->dateTo;

            $presensi = $presensi->whereBetween('created_at', [$from_date, $to_date])->get();
        }

        if($options == 2){
            $siswa = $request->siswa;
            $data = $presensi->whereIn('id_siswa', $siswa);
            if($request->has('dateFrom') && $request->has('dateTo') && $request->dateFrom !== null && $request->dateTo !== null){
                $from_date = $request->dateFrom;
                $to_date = $request->dateTo;
                $presensi = $data->whereBetween('created_at', [$from_date, $to_date])->get();
            } else {
                $presensi = $data->get();
            }
        }

        if($options == 3){
            $kelas = $request->kelas;
            $siswa = KelasSiswa::whereIn('id_kelas',$kelas)->pluck('id_siswa')->toArray();
            $data = $presensi->whereIn('id_siswa', $siswa);
            if($request->has('dateFrom') && $request->has('dateTo') && $request->dateFrom !== null && $request->dateTo !== null){
                $from_date = $request->dateFrom;
                $to_date = $request->dateTo;
                $presensi = $data->whereBetween('created_at', [$from_date, $to_date])->get();
            } else {
                $presensi = $data->get();
            }
        }

        if($options == 4){
            $jurusan = $request->jurusan;
            $kelas = KelasJurusan::whereIn('jurusan', $jurusan)->pluck('id_kelas', 'nama_kelas')->toArray();
            $siswa = KelasSiswa::whereIn('id_kelas',$kelas)->pluck('id_siswa')->toArray();
            $data = $presensi->whereIn('id_siswa', $siswa);
            if($request->has('dateFrom') && $request->has('dateTo') && $request->dateFrom !== null && $request->dateTo !== null){
                $from_date = $request->dateFrom;
                $to_date = $request->dateTo;
                $presensi = $data->whereBetween('created_at', [$from_date, $to_date])->get();
            } else {
                $presensi = $data->get();
            }
        }

        $transform = $presensi->map(function($item){
            return [
                'tanggal' => $item->created_at->format('d/m/Y'),
                'nama_siswa' => $item->siswa?->nama ?? '',
                'nis' => $item->siswa?->nis ?? '',
                'kelas' => getKelasSiswa($item->siswa?->kelas?->id_kelas, 'kelas'),
                'nama_kelas' => getKelasSiswa($item->siswa?->kelas?->id_kelas),
                'jurusan' => getKelasSiswa($item->siswa?->kelas?->id_kelas, 'jurusan'),
                'status' => $item->status
            ];
        });

        return Excel::download(new PresensiExport($transform), 'Presensi Siswa.xlsx');
    }

    public function detail_presensi($id)
    {
        $tanggal = Carbon::today()->subDays($id);

        $presensiMasuk = PresensiMasuk::whereDate('created_at', $tanggal)->latest();
        $presensiPulang = PresensiPulang::whereDate('created_at', $tanggal)->latest();

        $presensi = $presensiMasuk->unionAll($presensiPulang)->orderBy('created_at', 'desc')->get();

        $presensi = $presensi->map(function($item){
                return [
                    'tanggal' => $item->created_at->format('d/m/Y'),
                    'nama_siswa' => $item->siswa?->nama ?? '',
                    'nis' => $item->siswa?->nis ?? '',
                    'kelas' =>  getKelasSiswa($item->siswa?->kelas?->id_kelas),
                    'status' => $item->status
                ];
            });
        
        return view('admin.page.presensi.partial.tabel_presensi', compact('presensi'));
    }

    public function kelas_jurusan()
    {
        $kelas = KelasJurusan::count();

        $kelas_jurusan = KelasJurusan::orderBy('created_at','desc')->get();

        return view('admin.page.kelas_jurusan.kelas-jurusan',compact('kelas','kelas_jurusan'));
    }

    public function store_kelas(Request $request)
    {
        $request->validate([
            'jurusan' => 'required', 
            'kelas' => 'required',
            'nama_kelas' => 'required'
        ]);

        $slug = Str::slug($request->nama_kelas);

        if(KelasJurusan::where('nama_kelas', $request->nama_kelas)->exists()){
            return response()->json([
                'type' => 'error',
                'msg' => 'Kelas sudah terdaftar.'
            ]);
        }

        if(KelasJurusan::where('slug', $slug)->exists()){
            return response()->json([
                'type' => 'error',
                'msg' => 'Kelas sudah terdaftar.'
            ]);
        }

        try{
            KelasJurusan::create([
                'jurusan' => $request->jurusan,
                'kelas' => $request->kelas,
                'nama_kelas' => $request->nama_kelas,
                'slug' => Str::slug($request->nama_kelas)
            ]);
            $count = KelasJurusan::count();
            return response()->json([
                'type' => 'success',
                'msg' => 'Berhasil Menambahkan Kelas Baru',
                'count' => $count,
                'render' => $this->render_kelas_modal()
            ]);
        } catch(\Exception $e){
            return response()->json([
                'type' => 'error',
                'msg' => 'Jurusan, Kelas, dan Nama kelas harus diisi!'
            ]);
        }
    }

    public function import_kelas(Request $request)
    {
        $request->validate([
            'template_kelas' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        if($request->hasFile('template_kelas')){
            $file = $request->file('template_kelas');

            Excel::import(new KelasImport, $file);

            $count_kelas = KelasJurusan::count();

            $errors = Session::get('kelas_import_error');
            $success = Session::get('kelas_import_success');

            if($errors && !$success){
                $msg = 'Gagal Import Kelas <br>';
                foreach($errors as $error){
                    $msg .= "- ".$error."<br>";
                }
                return response()->json([
                    'type' => 'error',
                    'msg' => $msg
                ]);
            }
            if($errors && $success){
                $msg = 'Berhasil Import Kelas <br>';
                $msg = 'Catatan untuk data berikut : <br>';
                
                foreach($errors as $error){
                    $msg .= "- ".$error."<br>";
                }
                return response()->json([
                    'type' => 'warning',
                    'msg' => $msg,
                    'count' => $count_kelas,
                    'render' => $this->render_kelas_modal(),
                ]);
            }
            if(!$errors && $success){
                return response()->json([
                    'type' => 'success',
                    'msg' => "Berhasil Import Data Kelas",
                    'count' => $count_kelas,
                    'render' => $this->render_kelas_modal(),
                ]);
            }
        }

        return response()->json([
            'type' => 'error',
            'msg' => 'File tidak ditemukan / tidak valid'
        ]);
    }

    public function update_kelas(Request $request)
    {
        $request->validate([
            'jurusan' => 'required',
            'kelas' => 'required',
            'nama_kelas' => 'required',
            'id_kelas' => 'required'
        ]);

        try{
            KelasJurusan::find($request->id_kelas)->update([
                'jurusan' => $request->jurusan,
                'kelas' => $request->kelas,
                'nama_kelas' => $request->nama_kelas,
                'slug' => Str::slug($request->nama_kelas)
            ]);

            return response()->json([
                'type' => 'success',
                'msg' => 'Kelas berhasil di Update.'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'type' => 'error',
                'msg' => 'Gagal update Kelas.'
            ]);
        };
    }



    public function delete_kelas(Request $request)
    {
        $kelas = KelasJurusan::find($request->id_kelas);

        if($kelas){
            $kelas_siswa = KelasSiswa::where('id_kelas', $kelas->id_kelas)->pluck('id_siswa','id')->toArray();

            if(count($kelas_siswa) > 0){
                foreach($kelas_siswa as $key => $siswa){
                    $siswa = Siswa::find($siswa)->delete();
                }
            };

            $kelas->delete();
            $count = KelasJurusan::count();
            return response()->json([
                'type'=>'success',
                'msg'=>'Berhasil Menghapus Kelas.',
                'count' => $count
            ]);
        }

        return response()->json(['type'=>'error', 'msg' => 'Kelas Tidak Ditemukan.']);
    }

    public function render_kelas_modal()
    {
        $kelas_jurusan = KelasJurusan::orderBy('created_at','desc')->get();

        return View::make('admin.page.kelas_jurusan.modal-edit-kelas', compact('kelas_jurusan'))->render();
    }

    public function generate_qr_code()
    {
        $masuk =  TokenQrCode::where('nama','masuk')->first();
        $pulang =  TokenQrCode::where('nama','pulang')->first();

        $qr_code = [];

        if(!empty($masuk) && !empty($pulang)){
            $qr_code = [
                'masuk' => $masuk->token,
                'pulang' => $pulang->token,
                'status_masuk' => $masuk->status,
                'status_pulang' => $pulang->status
            ];
        }

        if(empty($masuk) && empty($pulang)){
            $create_token_masuk = TokenQrCode::create([
                'nama' => 'masuk',
                'token' => Str::random(30),
                'status' => 0
            ]);

            $create_token_pulang = TokenQrCode::create([
                'nama' => 'pulang',
                'token' => Str::random(30),
                'status' => 0
            ]);

            $qr_code = [
                'masuk' => $create_token_masuk->token,
                'pulang' => $create_token_pulang->token,
                'status_masuk' => $create_token_masuk->status,
                'status_pulang' => $create_token_pulang->status
            ];
        }
        
        return view('admin.page.generate-qr.generate_qr', compact('qr_code'));
    }

    public function update_qr_code(Request $request)
    {
        $qrCode = TokenQrCode::where('nama', $request->nama)->first();

        if($qrCode->status == 0){
            $qrCode->status = 1;
            $qrCode->save();
            
            return response()->json([
                'type' => 'success',
                'msg' => 'Qr Code Berhasil Aktif'
            ]);
        } else {
            $qrCode->status = 0;
            $qrCode->save();
            
            return response()->json([
                'type' => 'danger',
                'msg' => 'Qr Code Berhasil dimatikan'
            ]);
        }
    }

    public function download_qrcode($token_id)
    {
        if($token_id == 1){
            $qrCode = TokenQrCode::where('nama', 'masuk')->first();

            return response(generateQrcode($qrCode->token))
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="qr-code-masuk.png"');
        };

        if($token_id == 2){
            $qrCode = TokenQrCode::where('nama', 'pulang')->first();

            return response(generateQrcode($qrCode->token))
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="qr-code-pulang.png"');
        };
    }

    public function store_siswa(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|unique:users',
            'password' => 'required',
            'nama_siswa' => 'required',
            'kelas' => 'required',
            'nis' => 'required|unique:siswas,nis',
            'tanggal_lahir' => 'required'
        ], [
            'username.required' => 'Username Harus Diisi',
            'username.unique' => 'Username Sudah Ada',
            'password.required' => 'Password Harus Diisi',
            'nama_siswa.required' => 'Nama Harus Diisi',
            'kelas.required' => 'Kelas Harus Diisi',
            'nis.required' => 'NIS Harus Diisi',
            'nis.unique' => 'NIS Sudah Ada!',
            'tanggal_lahir.required' => 'Tanggal Lahir Harus Diisi'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 422);
        }

        try {
    
            $akun = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'siswa'
            ]);
    
            $orang_tua = OrangTua::create([
                'nama' => $request->nama_orangtua,
                'nomor_telepon' => $request->nomor_telepon
            ]);
    
            if($orang_tua && $akun){
                $siswa = Siswa::create([
                        'user_id' => $akun->id,
                        'id_orangtua' => $orang_tua->id_orangtua,
                        'password' => $request->password,
                        'nama' => $request->nama_siswa,
                        'nis' => $request->nis,
                        'tanggal_lahir' => $request->tanggal_lahir
                    ]);
                
                KelasSiswa::create([
                    'id_kelas' => $request->kelas,
                    'id_siswa' => $siswa->id_siswa
                ]);
        
                return response()->json([
                    'type' => 'success', 
                    'msg'  => 'Berhasil Membuat Akun Siswa',
                    'render' => $this->render_modal_siswa()
                ]);
            } else {
                if($orang_tua){
                    $orang_tua->delete();
                }
                return response()->json([
                    'type' => 'error', 
                    'msg'  => 'Gagal Membuat Akun Siswa'
                ]);
            }
        } catch (\Exception $exception){
            return response()->json([
                'type' => 'error',
                'msg'  => $exception->getMessage()
            ]);
        }
    }

    public function import_siswa(Request $request)
    {
        if($request->hasFile('file_siswa')){
            $file = $request->file('file_siswa');

            Excel::import(new SiswaImport, $file);

            $errors = Session::get('import_errors');
            $success = Session::get('import_success');

    
            if($errors && !$success){
                $message = 'Gagal Import Akun Siswa <br><br>';
                $message .= '*Catatan Gagal Membuat Data Siswa berikut:<br>';
                
                foreach ($errors as $error) {
                   $message .= "- ".$error."<br>";
                }

                return response()->json([
                    'type' => 'error',
                    'msg'  => $message
                ]);
            }
            if($errors && $success){
                $message = 'Berhasil Import Akun Siswa <br><br>';
                $message .= '*Catatan Gagal Membuat Data Siswa berikut:<br>';
                
                foreach ($errors as $error) {
                   $message .= "- ".$error."<br>";
                }

                return response()->json([
                    'type' => 'warning',
                    'msg'  => $message
                ]);
            } 

            if(!$errors && $success){
                return response()->json([
                    'type' => 'success',
                    'msg'  => 'Berhasil Import Akun Siswa'
                ]);
            }

        } else {
            return response()->json([
                'type' => 'error',
                'msg' => 'File Tidak ada!'
            ]);
        }
    }

    public function update_siswa(Request $request)
    {
        $siswa = Siswa::find($request->id_siswa);
        
        if($siswa){
            $user = User::find($siswa->user_id);
            $user->username = $request->username;
            $user->password = $request->password;
            $user->save();

            $orang_tua = OrangTua::find($siswa->id_orangtua);
            $orang_tua->nama = $request->nama_orangtua;
            $orang_tua->nomor_telepon = $request->nomor_telepon;
            $orang_tua->save();

            $kelas = KelasSiswa::where('id_siswa',$siswa->id_siswa)->first();
            $kelas->id_kelas = $request->kelas;
            $kelas->save();

            $siswa->update([
                'nama' => $request->nama_siswa,
                'nis' => $request->nis,
                'tanggal_lahir' => $request->tanggal_lahir,
                'password' => $request->password,
            ]);

            return response()->json([
                'type' => 'success',
                'msg' => 'Berhasil Update Akun!'
            ]);
        }

        return response()->json([
            'type' => 'error',
            'msg' => 'Gagal Update Akun!'
        ]);
    }

    public function delete_siswa(Request $request) : JsonResponse
    {
        $request->validate(['id_siswa' => 'required']);

        $siswa = Siswa::find($request->id_siswa);

        if($siswa){
            User::find($siswa->user_id)->delete();
            OrangTua::find($siswa->id_orangtua)->delete();
        }

        $siswa->delete();

        return response()->json([
            'type' => 'success',
            'msg' => 'Akun Siswa Berhasil dihapus',
            'render' => $this->render_modal_siswa()
        ]);
    }

    private function render_modal_siswa()
    {
        $kelas = KelasJurusan::orderBy('nama_kelas', 'asc')->get();

        $siswas = Siswa::orderBy('created_at', 'desc')->with('orangTua')->get();
        
        $siswas = $siswas->map(function($item){
            $all_kelas = KelasJurusan::pluck('nama_kelas','id_kelas')->toArray();
            
            return [
                'id_siswa' => $item->id_siswa,
                'nama' => $item->nama,
                'nis' => $item->nis,
                'username' => $item->users->username,
                'password' => $item->password,
                'kelas' => $item->getKelas()?->nama_kelas ?? '',
                'all_kelas' => $all_kelas,
                'id_kelas' => $item->kelas?->id_kelas ?? '',
                'tanggal_lahir' => $item->tanggal_lahir->format('Y-m-d'),
                'orang_tua' => $item->orangTua->nama,
                'nomor_telp' => $item->orangTua->nomor_telepon
            ];
        });

        return View::make('admin.page.siswa.partial.modal_siswa', compact('siswas', 'kelas'))->render(); 
    }

    public function store_mapel(Request $request)
    {
         $validator = Validator::make($request->all(),[
            'username' => 'required|unique:users',
            'password' => 'required',
            'nama_mapel' => 'required',
            'kode_mapel' => 'required|unique:mapels,kode_mapel',
            'nama_guru' => 'required',
            'nip' => 'required|unique:mapels,nip'
        ], [
            'username.required' => 'Username Harus Diisi',
            'username.unique' => 'Username Sudah Ada',
            'password.required' => 'Password Harus Diisi',
            'nama_mapel.required' => 'Nama Mapel Harus Diisi',
            'kode_mapel.required' => 'Kode Mapel Harus Diisi',
            'kode_mapel.unique' => 'Kode Mapel Sudah Dipakai',
            'nip.required' => 'NIP Harus Diisi',
            'nip.unique' => 'NIP Sudah Ada!',
            'nama_guru.required' => 'Nama Guru Harus Diisi'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->all()
            ], 422);
        }

        try{
            $akun = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'mapel'
            ]);

            if($akun){

                Mapel::create([
                    'user_id' => $akun->id,
                    'password' => $request->password,
                    'kode_mapel' => $request->kode_mapel,
                    'nama_mapel' => $request->nama_mapel,
                    'nama_guru' => $request->nama_guru,
                    'nip' => $request->nip,
                ]);

                return response()->json(['type' => 'success', 'msg' => 'Berhasil Membuat Akun Mapel']);
            }
        } catch(\Exception $exception){
            return response()->json(['type' => 'error', 'msg' => 'Gagal Membuat Akun Mapel']);
        };

    }

    public function update_mapel(Request $request)
    {
        $mapel = Mapel::find($request->id_mapel);

        if($mapel){
            $user = User::find($mapel->user_id);
            $user->username = $request->username;
            $user->password = $request->password;
            $user->save();

            $mapel->update([
                'nama_mapel' => $request->nama_mapel,
                'kode_mapel' => $request->kode_mapel,
                'nama_guru' => $request->nama_guru,
                'nip' => $request->nip,
                'password' => $request->password, 
            ]);

            return response()->json([
                'type' => 'success',
                'msg' => 'Berhasil Update Akun'
            ]);
        }

        return response()->json([
            'type' => 'error',
            'msg' => 'Akun Tidak Ditemukan'
        ]);
    }

    public function mapel_delete(Request $request)
    {
        $request->validate(['id_mapel' => 'required']);

        $mapel = Mapel::find($request->id_mapel);

        if($mapel){
            User::find($mapel->user_id)->delete();
        }

        $mapel->delete();

        return response()->json([
            'type' => 'success',
            'msg' => 'Berhasil Menghapus Akun'
        ]);
    }

    public function change_password()
    {
        return view('admin.page.change-password');
    }

    public function user_confirm(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required'
        ]);

        try{
            $user = User::where('username',$request->username)->where('email',$request->email)->first();

            return view('admin.page.submit-password', compact('user'));

        } catch (\Exception $ex){

            return redirect()->back()->with('error','Username/Email Tidak valid.');
        }
    }

    public function change_password_admin(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required',
            'id_user' => 'required'
        ]);

        try{
            $user = User::find(decrypt($request->id_user));

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return redirect()->route('admin.login');

        } catch (\Exception $ex){

            return redirect()->back()->with('error','Username/Email Tidak valid.');
        }
    }

}
