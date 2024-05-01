<?php

namespace App\Http\Controllers;

use App\Models\SesiUjian;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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
        return view('mapel.page.hasilUjian.hasil-ujian');
    }

    public function sesi_ujian()
    {
        $sesi = SesiUjian::where('id_mapel', auth()->user()->mapel->id_mapel)->orderBy('created_at', 'desc')->get();

        return view('mapel.page.sesiUjian.sesi-ujian', compact('sesi'));
    }

    public function soal_ujian($id)
    {
        $sesi = SesiUjian::where('id', $id)->first();
        return view('mapel.page.soalUjian.soal-ujian', compact('sesi'));
    }

    public function store_sesiujian(Request $request): JsonResponse
    {
        try{
            $request->validate([
                'tanggal_ujian' => 'required',
                'start' => 'required',
                'end' => 'required'
            ]);

            SesiUjian::create([
                'id_mapel' => auth()->user()->mapel->id_mapel,
                'tanggal_ujian' => $request->tanggal_ujian,
                'start' => $request->start,
                'end' => $request->end
            ]);

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
            $sesi = SesiUjian::find($request->idSesi);
            $sesi->tanggal_ujian = $request->tanggal_ujian;
            $sesi->start = $request->start;
            $sesi->end = $request->end;
            $sesi->save();

            return response()->json([
                'type' => 'success',
                'msg' => 'Berhasil Update Sesi Ujian'
            ]);
        } catch(\Exception $exception){
            return response()->json([
                'type' => 'error',
                'msg' => 'Gagal Update Sesi Ujian'
            ]);
        }
    }

    public function store_soal_ujian(Request $request)
    {
        return dd($request->request);
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
