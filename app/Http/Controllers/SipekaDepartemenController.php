<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SipekaDepartemen;

class SipekaDepartemenController extends Controller
{
    public function index()
    {
        $departemen = SipekaDepartemen::all();
        return view('master-data.index-departemen', compact('departemen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required',
            'kode_departemen' => 'required|unique:sipeka_departemen,kode_departemen',
        ]);

        SipekaDepartemen::create($request->all());
        return redirect()->route('departemen.index')->with('success', 'Data departemen berhasil ditambahkan.');
    }

    public function update(Request $request, $id_departemen)
    {
        $request->validate([
            'nama_departemen' => 'required',
            'kode_departemen' => 'required'
        ]);

        $departemen = SipekaDepartemen::findOrFail($id_departemen);
        $departemen->update($request->only(['nama_departemen', 'kode_departemen']));
        return redirect()->route('departemen.index')->with('success', 'Data departemen berhasil diupdate.');
    }


    public function destroy($id_departemen)
    {
        $departemen = SipekaDepartemen::findOrFail($id_departemen);
        $departemen->delete();
        return redirect()->route('departemen.index')->with('success', 'Data departemen berhasil dihapus.');
    }
}
