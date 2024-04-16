<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('admin.page.dashboard.dashboard');
    }

    public function register()
    {
        return view('admin.page.register');
    }

    public function akun_siswa()
    {
        return view('admin.page.siswa.kelola_siswa');
    }

    public function akun_mapel()
    {
        return view('admin.page.mapel.kelola_mapel');
    }

    public function presensi()
    {
        return view('admin.page.presensi.kelola_presensi');
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
