<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cuti;

class CutiController extends Controller
{
    public function show($id)
    {
        $cuti = Cuti::find($id);
        if (!$cuti) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
                'data_cuti'  => $cuti
            ], 200);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'nmr_induk' => 'required',
            'tgl_cuti' => 'required',
            'lama_cuti' => 'required',
            'keterangan' => 'required',
        ]);

        // dd($request->all());
        $cuti = new Cuti;
        $cuti->nmr_induk = $request->nmr_induk;
        $cuti->tgl_cuti = $request->tgl_cuti;
        $cuti->lama_cuti = $request->lama_cuti;
        $cuti->keterangan = $request->keterangan;
        $cuti->save();

        return response()->json([
                'message'       => 'Data Berhasil Ditambahkan',
                'data_cuti'  => $cuti
            ], 200);
    }

    public function update(Request $request, $id)
    {
        $cuti = Cuti::find($id);
        if (!$cuti) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'tgl_cuti' => 'required',
            'lama_cuti' => 'required',
            'keterangan' => 'required',
        ]);

        $cuti->update([
            'tgl_cuti' => $request->tgl_cuti,
            'lama_cuti' => $request->lama_cuti,
            'keterangan' => $request->keterangan
            
        ]);

        return response()->json([
                'message'       => 'success',
                'data_cuti'  => $cuti
            ], 200);
    }

    public function delete($id)
    {
        $cuti = Cuti::find($id)->delete();
        if (!$cuti) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
                'message'       => 'data cuti berhasil dihapus'
            ], 200);
    }
}
