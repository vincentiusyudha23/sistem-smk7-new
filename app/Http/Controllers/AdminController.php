<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
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
        return view('admin.page.mapel.kelola_mapel');
    }

    public function presensi()
    {
        return view('admin.page.presensi.kelola_presensi');
    }

    public function store_siswa(Request $request)
    {
        $orang_tua = OrangTua::create([
            'nama' => $request->nama_orangtua,
            'nomor_telepon' => $request->nomor_telepon
        ]);

        if($orang_tua){
            Siswa::create([
                'id_orangtua' => $orang_tua->id_orangtua,
                'id_kelas' => $request->kelas,
                'id_jurusan' => $request->jurusan,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'nama' => $request->nama_siswa,
                'nis' => $request->nis,
                'tanggal_lahir' => $request->tanggal_lahir
            ]);
    
            return response()->json(['success', 'Berhasil Membuat Akun Siswa']);
        } else {
            return response()->json(['error', 'Gagal Membuat Akun Siswa']);
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
