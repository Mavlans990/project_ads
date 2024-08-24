<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $karyawans_4 = Karyawan::with('getcuti')->get()->map(function ($karyawan) {
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
                'sisa_cuti' => max($sisaCuti, 0)
            ];
        });

        return view('karyawan.index',[
            'karyawans' => Karyawan::all(),
            'karyawans_2' => Karyawan::orderBy('tgl_bergabung', 'asc')->take(3)->get(),
            'karyawans_3' => Karyawan::whereHas('getcuti')->get(),
            'karyawans_4' => $karyawans_4 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('karyawan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'tgl_lahir' => 'required',
            'tgl_bergabung' => 'required'
        ]);

        $auto_kode = $this->generate_id();
        $validate['nmr_induk'] = $auto_kode;

        Karyawan::create($validate);
        return redirect('/karyawan')->with('success', 'Data berhasil ditambahkan!');
    }

    public function generate_id()
    {
        $kode_faktur = DB::table('tb_karyawan')->max('nmr_induk');

        if ($kode_faktur) {
            $nilai = substr($kode_faktur, 4);
            $kode = (int) $nilai;

            //tambahkan sebanyak + 1
            $kode = $kode + 1;
            $auto_kode = "IP06" . str_pad($kode, 3, "0", STR_PAD_LEFT);
        } else {
            $auto_kode = "IP06001";
        }
        return $auto_kode;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', [
            'karyawans' => $karyawan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'tgl_lahir' => 'required',
            'tgl_bergabung' => 'required'
        ]);

        Karyawan::where('nmr_induk', $karyawan->nmr_induk)->update($validate);
        return redirect('/karyawan')->with('success', 'Ubah data berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Karyawan $karyawan)
    {
        Karyawan::destroy($karyawan->nmr_induk);
        return redirect('/karyawan')->with('success', 'Data berhasil dihapus!');
    }
}
