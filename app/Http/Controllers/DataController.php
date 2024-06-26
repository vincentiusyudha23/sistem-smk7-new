<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\SesiUjian;
use App\Models\HasilUjian;
use App\Models\KelasJurusan;
use Illuminate\Http\Request;
use App\Exports\SoalTemplate;
use App\Models\PresensiMasuk;
use App\Exports\KelasTemplate;
use App\Exports\SiswaTemplate;
use App\Models\PresensiPulang;
use App\Models\SesiUjianKelas;
use App\Exports\SiswaDataExport;
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
                'jurusan' => $item->getKelas()?->jurusan ?? '',
                'kelas' => $item->getKelas()?->nama_kelas ?? '',
                'all_kelas' => $all_kelas,
                'id_kelas' => $item->kelas?->id_kelas ?? '',
                'tanggal_lahir' => $item->tanggal_lahir->format('d/m/Y'),
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
        $sesi = SesiUjian::where('id_mapel', $id_mapel)->orderBy('created_at', 'desc')->get();

        $sesi = $sesi->map(function($item){

            $getIdKelas = SesiUjianKelas::where('id_sesi_ujian', $item->id)->pluck('id_kelas')->toArray();

            $kelas = KelasJurusan::whereIn('id_kelas',$getIdKelas)->pluck('nama_kelas')->toArray();

            return [
                'id_sesi' => $item->id,
                'mata_pelajaran' => $item->mapel->nama_mapel,
                'kelas' => $kelas,
                'tanggal' => $item->tanggal_ujian->format('d/m/Y'),
                'start' => $item->start->format('H:i'),
                'end' => $item->end->format('H:i'),
                'status' => $item->status,
                'soal' => $item->soal_ujian
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

    public function data_siswa()
    {
        return Excel::download(new SiswaDataExport, 'Data_siswa.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function template_soal()
    {
        return Excel::download(new SoalTemplate, 'Template_soal.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    public function getSesiUjian()
    {
        $id_kelas = auth()->user()->siswa->kelas->id_kelas;
        $ujian = SesiUjianKelas::where('id_kelas', $id_kelas)->get();
        
        $ujian = $ujian->map(function($item){
            $sesi = SesiUjian::where('id', $item->id_sesi_ujian)->first();

            $hasil = HasilUjian::where('id_siswa', auth()->user()->siswa->id_siswa)
                        ->where('id_sesi_ujian',$sesi->id)->first() ? true : false;
            return [
                'id' => $sesi->id,
                'mata_pelajaran' => $sesi->mapel->nama_mapel,
                'kode_mapel' => $sesi->mapel->kode_mapel,
                'tanggal_ujian' => $sesi->tanggal_ujian->format('d/m/Y'),
                'start' => $sesi->start->format('H:i'),
                'end' => $sesi->end->format('H:i'),
                'status' => $sesi->status,
                'status_hasil' => $hasil,
                'soal_ujian' => $sesi->soal_ujian
            ];
        });
        return response()->json(['data' => $ujian]);
    }

    public function getDataPresensi()
    {
        $masuk = PresensiMasuk::whereDate('created_at', Carbon::today())->latest();
        $pulang = PresensiPulang::whereDate('created_at', Carbon::today())->latest();

        $presensi = $masuk->unionAll($pulang)->orderBy('created_at', 'desc')->get();

        $presensi = $presensi->map(function($item){
            return [
                'tanggal' => $item->created_at->format('d/m/Y'),
                'nama_siswa' => $item->siswa?->nama ?? '',
                'nis' => $item->siswa?->nis ?? '',
                'kelas' =>  getKelasSiswa($item->siswa?->kelas?->id_kelas),
                'status' => $item->status
            ];
        });

        return response()->json(['data' => $presensi]);
    }

    public function getHasilUjianSiswa($id)
    {
        $hasil_ujians = HasilUjian::where('id_sesi_ujian', $id)->with(['siswa'])->orderBy('created_at', 'desc')->get();

        $hasil_ujians = $hasil_ujians->map(function($item){
            return [
                'nama_siswa' => $item->siswa->nama,
                'nis' => $item->siswa->nis,
                'kelas' => $item->siswa?->kelas?->kelas?->nama_kelas,
                'nilai' => $item->nilai,
                'tanggal' => $item->sesi_ujian->tanggal_ujian->format('d/m/Y')
            ];
        });

        return response()->json(['data' => $hasil_ujians]);
    }
}
