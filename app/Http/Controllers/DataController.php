<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\SesiUjian;
use App\Models\KelasJurusan;
use Illuminate\Http\Request;
use App\Exports\KelasTemplate;
use App\Exports\SiswaTemplate;
use App\Models\SesiUjianKelas;
use Maatwebsite\Excel\Facades\Excel;

class DataController extends Controller
{
    public function getDataKelas()
    {
        $kelas = KelasJurusan::orderBy('id_kelas', 'desc')->get();
        $kelas = $kelas->map(function($item){
            return [
                'id_kelas' => $item->id_kelas,
                'jurusan' => $item->jurusan,
                'kelas' => getCapitalText($item->kelas),
                'nama_kelas' => $item->nama_kelas,
                'total_siswa' => count($item->siswa)
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
            $all_kelas = KelasJurusan::pluck('nama_kelas','id_kelas')->toArray();
            
            return [
                'id_siswa' => $item->id_siswa,
                'nama' => $item->nama,
                'nis' => $item->nis,
                'username' => $item->users->username,
                'password' => $item->password,
                'kelas' => $item->getKelas()->nama_kelas,
                'all_kelas' => $all_kelas,
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

    public function getDataSesi($id_mapel)
    {
        $sesi = SesiUjian::where('id_mapel', $id_mapel)->get();

        $sesi = $sesi->map(function($item){

            $getIdKelas = SesiUjianKelas::where('id_sesi_ujian', $item->id)->pluck('id_kelas')->toArray();

            $kelas = KelasJurusan::whereIn('id_kelas',$getIdKelas)->pluck('nama_kelas')->toArray();

            return [
                'id_sesi' => $item->id,
                'mata_pelajaran' => $item->mapel->nama_mapel,
                'kelas' => $kelas,
                'tanggal' => $item->tanggal_ujian,
                'start' => $item->start,
                'end' => $item->end,
                'status' => $item->status
            ];
        });

        return response()->json(['data' => $sesi]);
    }

    public function template_kelas()
    {
        return Excel::download(new KelasTemplate, 'template_kelas.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function template_siswa()
    {
        return Excel::download(new SiswaTemplate, 'template_siswa.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
