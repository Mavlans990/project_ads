<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\KaryawanResource;
use App\Models\Cuti;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Carbon;

class KaryawanController extends Controller
{
    public function show(Request $request)
    {
        $perPage = $request->get('per_page');

        $karyawan = Karyawan::paginate($perPage);
        $collectionKaryawan = KaryawanResource::collection($karyawan);

        $dataKaryawan['data'] = $collectionKaryawan;
        $dataKaryawan['next_page_url'] = $karyawan->nextPageUrl();

        return response()->json([
                'data_karyawan'  =>  $dataKaryawan
            ], 200);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'karyawans' => 'required|array',
            'karyawans.*.nmr_induk' => 'required|string|max:255',
            'karyawans.*.nama' => 'required|string|max:255',
            'karyawans.*.alamat' => 'required|string|max:255',
            'karyawans.*.tgl_lahir' => 'required|date',
            'karyawans.*.tgl_bergabung' => 'required|date',
            // 'karyawans.*.list_cuti' => 'nullable|array',
            // 'karyawans.*.list_cuti.*.tgl_cuti' => 'required|date',
            // 'karyawans.*.list_cuti.*.lama_cuti' => 'required|integer',
            // 'karyawans.*.list_cuti.*.keterangan' => 'nullable|string',
        ]);
    
        $data_karyawan = [];
    
        foreach ($request->karyawans as $karyawanData) {
            $karyawan = new Karyawan;
            $karyawan->nmr_induk = $karyawanData['nmr_induk'];
            $karyawan->nama = $karyawanData['nama'];
            $karyawan->alamat = $karyawanData['alamat'];
            $karyawan->tgl_lahir = $karyawanData['tgl_lahir'];
            $karyawan->tgl_bergabung = $karyawanData['tgl_bergabung'];
            $karyawan->save();
    
            $data_karyawan[] = $karyawan;
    
            if (!empty($karyawanData['list_cuti'])) {
                foreach ($karyawanData['list_cuti'] as $cutiData) {
                    $cuti = new Cuti;
                    $cuti->nmr_induk = $karyawanData['nmr_induk'];
                    $cuti->tgl_cuti = $cutiData['tgl_cuti'];
                    $cuti->lama_cuti = $cutiData['lama_cuti'];
                    $cuti->keterangan = $cutiData['keterangan'] ?? null;
                    $cuti->save();
                }
            }
        }
    
        return response()->json([
            'message' => 'Karyawan Berhasil Ditambahkan',
            'data_karyawan' => $data_karyawan
        ], 200);
    }

    public function update(Request $request, $nmr_induk)
    {
        $karyawan = Karyawan::where('nmr_induk', $nmr_induk)->first();
        if (!$karyawan) {
            return response()->json([
                'message' => 'Karyawan tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'tgl_lahir' => 'required',
            'tgl_bergabung' => 'required'
        ]);

        $karyawan->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tgl_lahir' => $request->tgl_lahir,
            'tgl_bergabung' => $request->tgl_bergabung
            
        ]);

        return response()->json([
                'message'       => 'success',
                'data_karyawan'  => $karyawan
            ], 200);
    }

    public function delete($nmr_induk)
    {
        $karyawan = Karyawan::where('nmr_induk', $nmr_induk)->first()->delete();
        if (!$karyawan) {
            return response()->json([
                'message' => 'Karyawan tidak ditemukan'
            ], 404);
        }

        return response()->json([
                'message'       => 'data karyawan berhasil dihapus'
            ], 200);
    }

    public function firstJoined()
    {
        $karyawans = Karyawan::orderBy('tgl_bergabung', 'asc')->take(3)->get();
        return response()->json([
            '3_data_karyawan_first_join'  => $karyawans
        ]);
    }

    public function takenLeave()
    {
        $karyawans = Karyawan::whereHas('getcuti')->get();
        return response()->json([
            'data_karyawan_yg_pernah_cuti'  => $karyawans
        ]);
    }

    public function leaveBalance()
    {
        $karyawans = Karyawan::with('getcuti')->get()->map(function ($karyawan) {
            $tahunMulaiBekerja = Carbon::parse($karyawan->tgl_bergabung)->year;
            $tahunSekarang = now()->year; 

            $totalCuti = $karyawan->getcuti->filter(function ($cuti) use ($tahunMulaiBekerja, $tahunSekarang) {
                $tglCuti = Carbon::parse($cuti->tgl_cuti);
                return $tglCuti->year >= $tahunMulaiBekerja && $tglCuti->year <= $tahunSekarang;
            })->sum('lama_cuti');

            $jumlahTahunAktif = $tahunSekarang - $tahunMulaiBekerja;
            $totalQuotaCuti = $jumlahTahunAktif * 12;

            $sisaCuti = $totalQuotaCuti - $totalCuti;
            return [
                'nmr_induk' => $karyawan->nmr_induk,
                'nama' => $karyawan->nama,
                'sisa_cuti' => max($sisaCuti, 0) . " Hari" 
            ];
        });

        return response()->json([
            'data_sisa_cuti' => $karyawans
        ]);
    }
}
