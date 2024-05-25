<?php

namespace App\Http\Controllers;

use App\Models\SesiUjian;
use App\Models\HasilUjian;
use App\Models\KelasJurusan;
use Illuminate\Http\Request;
use App\Models\SesiUjianKelas;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mapel.page.dashboard.dashboard');
    }

    public function login()
    {
        return view('mapel.page.login');
    }

    public function hasil_ujian()
    {
        $sesi = SesiUjian::where('id_mapel', auth()->user()->mapel->id_mapel)->orderBy('created_at', 'desc')->get();

        return view('mapel.page.hasilUjian.hasil-ujian', compact('sesi'));
    }

    public function hasil_ujian_siswa($id)
    {
        $hasil_ujians = HasilUjian::where('id_sesi_ujian', $id)->orderBy('created_at', 'desc')->get();

        $sesi = SesiUjian::where('id', $id)->first();

        return view('mapel.page.hasilUjian.siswa-hasil-ujian', compact('hasil_ujians','sesi'));
    }

    public function sesi_ujian()
    {
        $sesi = SesiUjian::where('id_mapel', auth()->user()->mapel->id_mapel)->get();

        $sesi = $sesi->map(function($item){

            $getIdKelas = SesiUjianKelas::where('id_sesi_ujian', $item->id)->pluck('id_kelas')->toArray();

            $kelas = KelasJurusan::whereIn('id_kelas',$getIdKelas)->pluck('nama_kelas')->toArray();

            return [
                'id' => $item->id,
                'mata_pelajaran' => $item->mapel->nama_mapel,
                'kelas' => $kelas,
                'tanggal' => $item->tanggal_ujian->format('Y-m-d'),
                'start' => $item->start,
                'end' => $item->end,
                'status' => $item->status,
                'soal' => $item->soal_ujian
            ];
        });

        $kelas = KelasJurusan::orderBy('created_at', 'desc')->get();

        return view('mapel.page.sesiUjian.sesi-ujian', compact('sesi','kelas'));
    }

    public function soal_ujian($id)
    {
        $sesi = SesiUjian::where('id', $id)->first();
        return view('mapel.page.soalUjian.soal-ujian', compact('sesi'));
    }

    public function store_sesiujian(Request $request): JsonResponse
    {
        $request->validate([
            'tanggal_ujian' => 'required',
            'kelas' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);
        // dd($request->all());
        try{
            $sesi = SesiUjian::create([
                    'id_mapel' => auth()->user()->mapel->id_mapel,
                    'tanggal_ujian' => $request->tanggal_ujian,
                    'start' => $request->start,
                    'end' => $request->end
                ]);

            $sesi_kelas = [];

            foreach ($request->kelas as $key => $value) {
                $data = [
                    'id_sesi_ujian' => $sesi->id,
                    'id_kelas' => $value
                ];

                $sesi_kelas[] = $data;
            }

            SesiUjianKelas::insert($sesi_kelas);

            return response()->json([
                'type' => 'success',
                'msg' => 'Berhasil Membuat Sesi Ujian'
            ]);
        } catch(\Exception $exception){
            return response()->json([
                'type' => 'error',
                'msg' => 'Gagal Membuat Sesi Ujian'
            ]);
        }
    }

    public function update_sesi_ujian(Request $request)
    {
        try{
            $sesi_ujian = SesiUjian::find($request->idSesi);
            $sesi_ujian->update([
                'tanggal_ujian' => $request->tanggal_ujian,
                'start' => $request->start,
                'end' => $request->end
            ]);
            
            SesiUjianKelas::where('id_sesi_ujian', $sesi_ujian->id)->delete();
            
            foreach ($request->kelas as $id_kelas) {
                SesiUjianKelas::create([
                    'id_sesi_ujian' => $sesi_ujian->id,
                    'id_kelas' => $id_kelas
                ]);
            }

            $id_mapel = auth()->user()->mapel?->id_mapel;

            $sesi = SesiUjian::where('id_mapel', $id_mapel)->get();

            $sesi = $sesi->map(function($item){

                $getIdKelas = SesiUjianKelas::where('id_sesi_ujian', $item->id)->pluck('id_kelas')->toArray();

                $kelas = KelasJurusan::whereIn('id_kelas',$getIdKelas)->pluck('nama_kelas')->toArray();

                return [
                    'id' => $item->id,
                    'mata_pelajaran' => $item->mapel->nama_mapel,
                    'kelas' => $kelas,
                    'tanggal' => $item->tanggal_ujian->format('Y-m-d'),
                    'start' => $item->start,
                    'end' => $item->end,
                    'status' => $item->status,
                    'soal' => $item->soal_ujian
                ];
            });

            $render = View::make('mapel.page.sesiUjian.partial.modal-edit', compact('sesi'))->render();

            return response()->json([
                'type' => 'success',
                'msg' => 'Berhasil Update Sesi Ujian',
            ]);

        } catch(\Exception $exception){
            return response()->json([
                'type' => 'error',
                'msg' => 'Gagal Update Sesi Ujian',
                'e' => $exception->getMessage()
            ]);
        }
    }

    public function store_soal_ujian(Request $request)
    {   
        $request->validate([
            'id_sesi' => 'required',
            'soal' => 'required'
        ]);

        $data = $request->soal;

        $sesi = SesiUjian::find($request->id_sesi);

        $sesi->update([
            'soal_ujian' => $data
        ]);
        
        return Redirect::route('mapel.sesi-ujian');
    }

    public function update_status(Request $request): JsonResponse
    {
        $request->validate([
            'id_sesi' => 'required',
            'status' => 'required'
        ]);
        $status = $request->status ?? 0;
        $sesi = SesiUjian::find($request->id_sesi);

        if(!empty($sesi->soal_ujian)){
            if($status == 0){
                $sesi->update([
                    'status' => 1
                ]);
            } else{
                $sesi->update([
                    'status' => 2
                ]);
            }
            return response()->json([
                'type' => 'success',
                'msg' => 'Berhasil Update Status'
            ]);
        }

        return response()->json([
            'type' => 'error',
            'msg' => 'Belum ada soal ujian!'
        ]);

    }

    public function delete_sesi(Request $request)
    {
        $sesi = SesiUjian::find($request->id_sesi);
        try{
            $sesi->delete();
            return response()->json(['type'=>'success','msg'=>'Berhasil Menghapus Sesi Ujian']);
        }catch(\Exception $e){
            return response()->json(['type'=>'error', 'msg' => $e->getMessage()]);
        }
    }
}
