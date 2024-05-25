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
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
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
        $presensiMasuk = PresensiMasuk::where('created_at',Carbon::today())->count() ?? 0; 
        $presensiPulang = PresensiPulang::where('created_at',Carbon::today())->count() ?? 0;
        $total_presensi = $presensiMasuk + $presensiPulang;
        
        $persen_hadir = $total_presensi/$siswa;

        if($persen_hadir > 0){
            $persen_hadir = $persen_hadir * 100;
        } else {
            $persen_hadir = 0;
        }

        return view('admin.page.dashboard.dashboard', compact('siswa','total_presensi','persen_hadir'));
    }

    public function register()
    {
        return view('admin.page.register');
    }

    public function akun_siswa()
    {
        $kelas = KelasJurusan::orderBy('nama_kelas', 'asc')->get();
        return view('admin.page.siswa.kelola_siswa', compact('kelas'));
    }

    public function akun_mapel()
    {
        $mapels = Mapel::orderBy('created_at', 'desc')->get();
        return view('admin.page.mapel.kelola_mapel', compact('mapels'));
    }

    public function presensi()
    {
        return view('admin.page.presensi.kelola_presensi');
    }

    public function kelas_jurusan()
    {
        $kelas = KelasJurusan::count();

        return view('admin.page.kelas_jurusan.kelas-jurusan',compact('kelas'));
    }

    public function store_kelas(Request $request)
    {
        $request->validate([
            'jurusan' => 'required', 
            'kelas' => 'required',
            'nama_kelas' => 'required'
        ]);

        try{
            KelasJurusan::create([
                'jurusan' => $request->jurusan,
                'kelas' => $request->kelas,
                'nama_kelas' => $request->nama_kelas
            ]);
            $count = KelasJurusan::count();
            return response()->json([
                'type' => 'success',
                'msg' => 'Berhasil Menambahkan Kelas Baru',
                'count' => $count
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

            $import = Excel::import(new KelasImport, $file);

            if($import){
                $count = KelasJurusan::count();
                return response()->json([
                    'type' => 'success',
                    'msg' => 'Berhasil Import Data Kelas',
                    'count' => $count
                ]);
            } else {
                return response()->json([
                    'type' => 'error',
                    'msg' => 'Gagal membuat data kelas.'
                ]);
            }
        }

        return response()->json([
            'type' => 'error',
            'msg' => 'File tidak ditemukan / tidak valid'
        ]);
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

    public function generate_qr_code()
    {
        $masuk =  TokenQrCode::where('nama','masuk')->select('token','status')->first() ?? '';
        $pulang =  TokenQrCode::where('nama','pulang')->select('token','status')->first() ?? '';
        
        $token_masuk = $masuk->token ?? '';
        $token_pulang = $pulang->token ?? '';

        $status_masuk = $masuk->status ?? '';
        $status_pulang = $pulang->status ?? '';

        $qr_code = [
            'masuk' => $this->generate_qr_code_render($token_masuk),
            'pulang' => $this->generate_qr_code_render($token_pulang),
            'status_masuk' => $status_masuk,
            'status_pulang' => $status_pulang
        ];
        return view('admin.page.generate-qr.generate_qr', compact('qr_code'));
    }

    public function render_qr_code(Request $request)
    {
        $request->validate([
            'nama' => 'required'
        ]);
        
        $token = TokenQrCode::where('nama',$request->nama)->first();

        if(empty($token)){
            $token_id = Str::random(30);
            $create_token = TokenQrCode::create([
                'nama' => $request->nama,
                'token' => $token_id,
                'status' => 0
            ]);
            $qr_code = $this->generate_qr_code_render($create_token->token);
            $nama_qr = $request->nama;
            $view = View::make('admin.page.generate-qr.partials.render_qr_code', compact('qr_code','nama_qr'))->render();

            return response()->json([
                'type' => 'success',
                'msg' => 'Berhasil Membuat Qr Code',
                'view' => $view 
            ]);
        }

        return response()->json([
            'type' => 'error',
            'msg' => 'Qr Code Sudah Ada!'
        ]);
    }

    private function generate_qr_code_render($token)
    {
        if($token !== ''){
            return QrCode::format('png')->size(250)->generate($token);
        } else {
            return '';
        }
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
                    'msg'  => 'Berhasil Membuat Akun Siswa'
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

    public function import_siswa(Request $request) : JsonResponse
    {
        if($request->hasFile('file_siswa')){
            $file = $request->file('file_siswa');

            Excel::import(new SiswaImport, $file);

            return response()->json([
                'type' => 'success',
                'msg'  => 'Berhasil Membuat Akun Siswa'
            ]);
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
            'msg' => 'Akun Siswa Berhasil dihapus'
        ]);
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

}
