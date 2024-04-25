<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\OrangTua;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

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
                'id_kelas' => $request->id_kelas,
                'id_jurusan' => $request->id_jurusan,
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
