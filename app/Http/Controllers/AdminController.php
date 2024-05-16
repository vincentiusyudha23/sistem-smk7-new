<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\OrangTua;
use App\Models\TokenQrCode;
use Illuminate\Support\Str;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
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
        $siswa = Siswa::pluck('id_siswa');

        return view('admin.page.dashboard.dashboard', compact('siswa'));
    }

    public function register()
    {
        return view('admin.page.register');
    }

    public function akun_siswa()
    {
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();
        $siswas = Siswa::orderBy('created_at', 'desc')->with('kelas','jurusan','orangTua')->get();
        
        return view('admin.page.siswa.kelola_siswa', compact('kelas','jurusan','siswas'));
    }

    public function akun_mapel()
    {
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();
        $mapels = Mapel::orderBy('created_at', 'desc')->with(['kelas', 'jurusan'])->get();
        return view('admin.page.mapel.kelola_mapel', compact('kelas','jurusan', 'mapels'));
    }

    public function presensi()
    {
        return view('admin.page.presensi.kelola_presensi');
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
        try {
            $request->validate([
                'username' => 'required|unique:users',
                'password' => 'required',
                'nama_siswa' => 'required',
                'nis' => 'required',
                'tanggal_lahir' => 'required'
            ]);
    
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
                Siswa::create([
                    'user_id' => $akun->id,
                    'id_orangtua' => $orang_tua->id_orangtua,
                    'id_kelas' => $request->kelas,
                    'id_jurusan' => $request->jurusan,
                    'password' => $request->password,
                    'nama' => $request->nama_siswa,
                    'nis' => $request->nis,
                    'tanggal_lahir' => $request->tanggal_lahir
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
                'msg'  => 'Username Sudah Ada'
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

            $siswa->update([
                'nama' => $request->nama_siswa,
                'nis' => $request->nis,
                'tanggal_lahir' => $request->tanggal_lahir,
                'password' => $request->password,
                'id_kelas' => $request->kelas,
                'id_jurusan' => $request->jurusan
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
        $akun = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'mapel'
        ]);

        if($akun){
            Mapel::create([
                'user_id' => $akun->id,
                'id_kelas' => $request->kelas,
                'id_jurusan' => $request->jurusan,
                'password' => $request->password,
                'kode_mapel' => $request->kode_mapel,
                'nama_mapel' => $request->nama_mapel,
                'nama_guru' => $request->nama_guru,
                'nip' => $request->nip,
            ]);
    
            return response()->json(['type' => 'success', 'msg' => 'Berhasil Membuat Akun Mapel']);
        } else {
            return response()->json(['type' => 'error', 'msg' => 'Gagal Membuat Akun Mapel']);
        }
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
                'id_kelas' => $request->kelas,
                'id_jurusan' => $request->jurusan,
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

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
