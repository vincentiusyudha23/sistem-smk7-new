<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\SesiUjian;
use App\Models\HasilUjian;
use App\Models\TokenQrCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PresensiMasuk;
use App\Models\PresensiPulang;
use App\Models\SesiUjianKelas;
use Illuminate\Http\JsonResponse;
use App\Services\SendNotification;
use Illuminate\Support\Facades\Auth;
use App\DataTables\SesiUjianDataTable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $presensi_masuk = PresensiMasuk::where('id_siswa', auth()->user()->siswa->id_siswa)->latest();
        $presensi_pulang = PresensiPulang::where('id_siswa', auth()->user()->siswa->id_siswa)->latest();

        $presensi = $presensi_masuk->union($presensi_pulang)->orderBy('created_at','desc')->get();

        return view('siswa.page.dashboard.dashboard', compact('presensi'));
    }

    public function login()
    {
        return view('siswa.page.login');
    }

    public function presensi()
    {
        $token_masuk = TokenQrCode::where('nama','masuk')->first();
        $token_pulang = TokenQrCode::where('nama','pulang')->first();

        $token = [
            'masuk' => $token_masuk?->token,
            'pulang' => $token_pulang?->token
        ];
        return view('siswa.page.presensi.presensi', compact('token'));
    }

    public function riwayat_presensi()
    {
        $presensi_masuk = PresensiMasuk::where('id_siswa', auth()->user()->siswa->id_siswa)->latest();
        $presensi_pulang = PresensiPulang::where('id_siswa', auth()->user()->siswa->id_siswa)->latest();

        $presensi = $presensi_masuk->union($presensi_pulang)->orderBy('created_at','desc')->get();

        return view('siswa.page.presensi.riwayat-presensi', compact('presensi'));
    }

    public function ujian()
    {   
        return view('siswa.page.ujian.ujian');
    }
    
    public function soal_ujian($id)
    {
        $ujian = SesiUjian::where('id', $id)->with('mapel')->first();

        return view('siswa.page.ujian.soal-ujian', compact('ujian'));
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

    public function submit_presensi(Request $request)
    {
        // 1 = masuk
        // 2 = pulang
        $presensi_masuk = PresensiMasuk::where('id_siswa', $request->id_siswa)
                ->whereDate('created_at', Carbon::today())->first();
        $presensi_pulang = PresensiPulang::where('id_siswa', $request->id_siswa)
                ->whereDate('created_at', Carbon::today())->first();

        $qr_masuk = TokenQrCode::where('nama','masuk')->first();
        $qr_pulang = TokenQrCode::where('nama','pulang')->first();

        if($qr_masuk->status != 1 && $request->nama == 1){
            return response()->json([
                'type' => 'error',
                'msg' => 'Saat ini absen masuk Siswa Belum Aktif'
            ]); 
        }
        if($qr_pulang->status != 1 && $request->nama == 2){
            return response()->json([
                'type' => 'error',
                'msg' => 'Saat ini absen pulang Siswa Belum Aktif'
            ]); 
        }

        if($request->distance <= env('DISTANCE_SET') || env('DISTANCE_SCANNER') === false){
            try{
                $siswa = Siswa::find($request->id_siswa);
                $nomor_telp = $siswa->orangTua->nomor_telepon;
                
                if($request->nama == 1){
                    if(empty($presensi_masuk)){
                        PresensiMasuk::create([
                            'id_siswa' => $request->id_siswa,
                            'status' => 'masuk'
                        ]);

                        if ($nomor_telp) {
                            $sendMessage = new SendNotification();
                            $sendMessage->sendMessageMasuk($nomor_telp, $siswa->nama);
                        }


                        return response()->json([
                            'type' => 'success',
                            'msg' => 'Berhasil Absen Masuk!'
                        ]);
    
                        // return redirect()->back()->with('success','Berhasil Absen Masuk!');
                    }
    
                    return response()->json([
                            'type' => 'error',
                            'msg' => 'Anda Sudah Absen Masuk Hari Ini!'
                        ]); 
                    // return redirect()->back()->with('error','Anda Sudah Absen Hari Ini!');
                }
    
                if($request->nama == 2){
                    if(empty($presensi_pulang) ){

                        if(!empty($presensi_masuk)){
                            PresensiPulang::create([
                                'id_siswa' => $request->id_siswa,
                                'status' => 'pulang'
                            ]);
    
                            if ($nomor_telp) {
                                $sendMessage = new SendNotification();
                                $sendMessage->sendMessagePulang($nomor_telp, $siswa->nama);
                            }
    
                            return response()->json([
                                'type' => 'success',
                                'msg' => 'Berhasil Absen Pulang!'
                            ]);
                        }
    
                         return response()->json([
                            'type' => 'error',
                            'msg' => 'Anda Belum Absen Masuk!'
                        ]); 
                    }

                    return response()->json([
                            'type' => 'error',
                            'msg' => 'Anda Sudah Absen Pulang Hari Ini'
                        ]); 
    
                }
            }catch(\Exception $e){
                return response()->json([
                    'type' => 'error',
                    'msg' => $e->getMessage()
                ]);
            }
        } else {
            return response()->json([
                'type' => 'error',
                'msg' => 'Kamu terlalu Jauh Dari Sekolah!'
            ]);
        }
    }
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
