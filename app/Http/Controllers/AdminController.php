<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\OrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $siswas = Siswa::orderBy('created_at', 'asc')->with('kelas','jurusan','orangTua')->get();
        
        return view('admin.page.siswa.kelola_siswa', compact('kelas','jurusan','siswas'));
    }

    public function akun_mapel()
    {
        $kelas = Kelas::all();
        $jurusan = Jurusan::all();
        return view('admin.page.mapel.kelola_mapel', compact('kelas','jurusan'));
    }

    public function presensi()
    {
        return view('admin.page.presensi.kelola_presensi');
    }

    public function store_siswa(Request $request)
    {
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
                'nama' => $request->nama_siswa,
                'nis' => $request->nis,
                'tanggal_lahir' => $request->tanggal_lahir
            ]);
    
            return response()->json(['success', 'Berhasil Membuat Akun Siswa']);
        } else {
            return response()->json(['error', 'Gagal Membuat Akun Siswa']);
        }
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
                'kode_mapel' => $request->kode_mapel,
                'nama_mapel' => $request->nama_mapel,
                'nama_guru' => $request->nama_guru,
                'nip' => $request->nip,
            ]);
    
            return response()->json(['success' => true, 'msg' => 'Berhasil Membuat Akun Mapel']);
        } else {
            return response()->json(['error' => true, 'msg' => 'Gagal Membuat Akun Mapel']);
        }
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
