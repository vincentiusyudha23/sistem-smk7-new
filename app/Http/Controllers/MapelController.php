<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('mapel.page.sesiUjian.sesi-ujian');
    }

    public function soal_ujian()
    {
        return view('mapel.page.soalUjian.soal-ujian');
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
