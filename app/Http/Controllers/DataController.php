<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\KelasJurusan;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function getDataKelas()
    {
        $kelas = KelasJurusan::all();
        $kelas = $kelas->map(function($item){
            return [
                'id_kelas' => $item->id_kelas,
                'jurusan' => $item->jurusan,
                'kelas' => getCapitalText($item->kelas),
                'nama_kelas' => $item->nama_kelas,
                'total_siswa' => 10
            ];
        });

        return response()->json([
            'data' => $kelas
        ]);
    }

    public function getDataSiswa()
    {
        $siswa = Siswa::orderBy('created_at', 'desc')->with('orangTua')->get();

        $siswa = $siswa->map(function($item){
            return [
                'id_siswa' => $item->id_siswa,
                'nama' => $item->nama,
                'nis' => $item->nis,
                'username' => $item->users->username,
                'password' => $item->password,
                'kelas' => $item->getKelas()->nama_kelas,
                'id_kelas' => $item->kelas->id_kelas,
                'tanggal_lahir' => $item->tanggal_lahir,
                'orang_tua' => $item->orangTua->nama,
                'nomor_telp' => $item->orangTua->nomor_telepon
            ];
        });

        return response()->json([ 'data' => $siswa ]);
    }

    public function getDataMapel()
    {
        $mapel = Mapel::orderBy('created_at','desc')->get();

        $mapel = $mapel->map(function($item){
            return [
                'id_mapel' => $item->id_mapel,
                'nama_mapel' => $item->nama_mapel,
                'kode_mapel' => $item->kode_mapel,
                'nama_guru' => $item->nama_guru,
                'nip' => $item->nip,
                'password' => $item->password,
                'username' => $item->users->username
            ];
        });

        return response()->json(['data' => $mapel]);
    }
}
