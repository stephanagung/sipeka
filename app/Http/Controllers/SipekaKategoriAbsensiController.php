<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SipekaKategoriAbsensi;

class SipekaKategoriAbsensiController extends Controller
{
    public function index()
    {
        $kategoriAbsensi = SipekaKategoriAbsensi::all();
        return view('master-data.index-kategori-absensi', compact('kategoriAbsensi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori_absensi' => 'required',
            'kode_kategori_absensi' => 'required|unique:sipeka_kategori_absensi,kode_kategori_absensi',
        ]);

        SipekaKategoriAbsensi::create($request->all());
        return redirect()->route('kategoriAbsensi.index')->with('success', 'Data kategori absensi berhasil ditambahkan.');
    }

    public function update(Request $request, $id_kategori_absensi)
    {
        $request->validate([
            'nama_kategori_absensi' => 'required',
            'kode_kategori_absensi' => 'required'
        ]);

        $kategoriAbsensi = SipekaKategoriAbsensi::findOrFail($id_kategori_absensi);
        $kategoriAbsensi->update($request->only(['nama_kategori_absensi', 'kode_kategori_absensi']));
        return redirect()->route('kategoriAbsensi.index')->with('success', 'Data kategori absensi berhasil diupdate.');
    }


    public function destroy($id_kategori_absensi)
    {
        $kategoriAbsensi = SipekaKategoriAbsensi::findOrFail($id_kategori_absensi);
        $kategoriAbsensi->delete();
        return redirect()->route('kategoriAbsensi.index')->with('success', 'Data kategori absensi berhasil dihapus.');
    }
}
