<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\SesiUjian;
use App\Models\HasilUjian;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\DataTables\SesiUjianDataTable;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_kelas = Auth::user()->siswa->id_kelas;
        $id_jurusan = Auth::user()->siswa->id_jurusan;
        
        $ujians = SesiUjian::getUjiansByKelasJurusan($id_kelas,$id_jurusan)->get();

        return view('siswa.page.dashboard.dashboard', compact('ujians'));
    }

    public function login()
    {
        return view('siswa.page.login');
    }

    public function presensi()
    {
        return view('siswa.page.presensi.presensi');
    }

    public function ujian()
    {   
        $id_kelas = Auth::user()->siswa->id_kelas;
        $id_jurusan = Auth::user()->siswa->id_jurusan;
        
        $ujians = SesiUjian::getUjiansByKelasJurusan($id_kelas,$id_jurusan)->get();

        return view('siswa.page.ujian.ujian', compact('ujians'));
    }
    
    public function soal_ujian($id, $mapel)
    {
        $ujian = SesiUjian::find($id);

        return view('siswa.page.ujian.soal-ujian', compact('ujian','mapel'));
    }

    public function submit_jawaban(Request $request): JsonResponse
    {
        $nilai = 0;
        $ujian = SesiUjian::find($request->id_sesi);
        $soal_ujian = json_decode($ujian->soal_ujian, true);
        $jawabans = $request->all();
        $jawabans_siswa = [];
       
        foreach ($soal_ujian as $key => $value) {
            $jawaban = $jawabans[$key] ?? 0;
            if($jawaban !== 0){
                if(decrypt($jawaban) === 1){
                    $nilai++;
                    $jawaban_siswa[$key] = 1;
                } else {
                    $jawaban_siswa[$key] = 0;
                };
            } else {
                $jawaban_siswa[$key] = 0;
            }
            $jawabans_siswa = $jawaban_siswa;
        }
        $nilai_akhir = $nilai/count($soal_ujian)*100;
        
        try{
            HasilUjian::create([
                'id_siswa' => Auth::user()->siswa->id_siswa,
                'id_sesi_ujian' => $ujian->id,
                'nama_siswa' => Auth::user()->siswa->nama,
                'jawaban' => json_encode($jawabans_siswa),
                'nilai' => $nilai_akhir
            ]);
            return response()->json([
                'type' => 'success',
                'msg' => 'Berhasil Mensubmit Ujian!'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'type' => 'error',
                'msg' => 'Gagal Mensubmit Jawaban',
                'ex' => $e->getMessage()
            ]);
        }
    }

    public function submit_ujian($mapel)
    {
        return view('siswa.page.ujian.partials.submit-ujian', compact('mapel'));
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
