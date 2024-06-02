<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\SesiUjian;
use App\Models\HasilUjian;
use App\Imports\SoalImport;
use App\Models\KelasJurusan;
use Illuminate\Http\Request;
use App\Models\SesiUjianKelas;
use App\Exports\HasilUjianExport;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sesi = SesiUjian::where('id_mapel', auth()->user()->mapel->id_mapel)->orderBy('created_at', 'desc')->get();

        $id_sesi = $sesi->pluck('id')->toArray();

        $hasil_ujian = HasilUjian::whereIn('id_sesi_ujian', $id_sesi)
                ->select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('YEAR(created_at) as year'),
                    DB::raw('AVG(nilai) as average_score')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();
        
        $chartData = array_fill(1, 12, 0);

        foreach ($hasil_ujian as $data) {
            $chartData[$data->month] = $data->average_score;
        }


        return view('mapel.page.dashboard.dashboard', compact('sesi','chartData'));
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
        
        try{
            $waktu_mulai = $request->tanggal_ujian." ".$request->start;
            $waktu_selesai = $request->tanggal_ujian." ".$request->end;
            $sesi_ujian = SesiUjian::create([
                    'id_mapel' => auth()->user()->mapel->id_mapel,
                    'tanggal_ujian' => $request->tanggal_ujian,
                    'start' => Carbon::parse($waktu_mulai),
                    'end' => Carbon::parse($waktu_selesai)
                ]);

            $sesi_kelas = [];

            foreach ($request->kelas as $key => $value) {
                $data = [
                    'id_sesi_ujian' => $sesi_ujian->id,
                    'id_kelas' => $value
                ];

                $sesi_kelas[] = $data;
            }

            SesiUjianKelas::insert($sesi_kelas);

            return response()->json([
                'type' => 'success',
                'msg' => 'Berhasil Membuat Sesi Ujian',
                'render' => $this->render_modal_edit()
            ]);

        } catch(\Exception $exception){
            return response()->json([
                'type' => 'error',
                'msg' => $exception->getMessage()
            ]);
        }
    }

    public function update_sesi_ujian(Request $request)
    {
        try{
            $sesi_ujian = SesiUjian::find($request->idSesi);
            $waktu_mulai = $request->tanggal_ujian." ".$request->start;
            $waktu_selesai = $request->tanggal_ujian." ".$request->end;
            $sesi_ujian->update([
                'tanggal_ujian' => $request->tanggal_ujian,
                'start' => Carbon::parse($waktu_mulai),
                'end' => Carbon::parse($waktu_selesai)
            ]);
            
            SesiUjianKelas::where('id_sesi_ujian', $sesi_ujian->id)->delete();
            
            foreach ($request->kelas as $id_kelas) {
                SesiUjianKelas::create([
                    'id_sesi_ujian' => $sesi_ujian->id,
                    'id_kelas' => $id_kelas
                ]);
            }

            return response()->json([
                'type' => 'success',
                'msg' => 'Berhasil Update Sesi Ujian',
                'render' => $this->render_modal_edit()
            ]);

        } catch(\Exception $exception){
            return response()->json([
                'type' => 'error',
                'msg' => 'Gagal Update Sesi Ujian',
                'e' => $exception->getMessage()
            ]);
        }
    }

    private function render_modal_edit()
    {
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

            return View::make('mapel.page.sesiUjian.partial.modal-edit', compact('sesi'))->render();
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

    public function import_soal(Request $request)
    {
        $request->validate([
            'file_soal' => 'required|mimes:xlsx,xls,csv|max:2048',
            'id_sesi' => 'required'
        ]);

        if($request->hasFile('file_soal')){
            $file = $request->file('file_soal');

            Excel::import(new SoalImport, $file);

            $soal = Session::get('soal_ujian');

            if($soal){
                $sesiUjian = SesiUjian::find($request->id_sesi);
                $sesiUjian->update([
                    'soal_ujian' => $soal
                ]);
                $sesi = SesiUjian::find($sesiUjian->id);
                $render = View::make('mapel.page.soalUjian.partial.form-soal', compact('sesi'))->render();

                return response()->json([
                    'type' => 'success',
                    'msg' => 'Berhasil Import Soal.',
                    'render' => $render
                ]);
            }
        }

        return response()->json([
            'type' => 'error',
            'msg' => 'File tidak ditemukan / tidak valid'
        ]);
    }

    public function export_hasil_ujian($id)
    {
        $hasil_ujians = HasilUjian::where('id_sesi_ujian', $id)->with(['siswa'])->orderBy('created_at', 'desc')->get();

        $hasil_ujians = $hasil_ujians->map(function($item){
            return [
                'nama_siswa' => $item->siswa->nama,
                'nis' => $item->siswa->nis,
                'nilai' => (string) $item->nilai,
                'kelas' => getKelasSiswa($item->siswa?->kelas?->id_kelas, 'kelas'),
                'nama_kelas' => getKelasSiswa($item->siswa?->kelas?->id_kelas),
                'jurusan' => getKelasSiswa($item->siswa?->kelas?->id_kelas, 'jurusan'),
                'tanggal' => $item->sesi_ujian->tanggal_ujian->format('d/m/Y')
            ];
        });
        // dd($hasil_ujians);
        return Excel::download(new HasilUjianExport($hasil_ujians), 'Hasil Ujian Siswa.xlsx');
    }
}
