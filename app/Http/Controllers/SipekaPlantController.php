<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SipekaPlant;

class SipekaPlantController extends Controller
{
    public function index()
    {
        $plant = SipekaPlant::all();
        return view('master-data.index-plant', compact('plant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_plant' => 'required|string|max:255',
            'kode_plant' => 'required|string|max:10|unique:sipeka_plant,kode_plant',
        ]);

        SipekaPlant::create($request->all());
        return redirect()->route('plant.index')->with('success', 'Data Plant berhasil ditambahkan.');
    }


    public function update(Request $request, $id_plant)
    {
        $request->validate([
            'nama_plant' => 'required',
            'kode_plant' => 'required'
        ]);

        $plant = SipekaPlant::findOrFail($id_plant);
        $plant->update($request->only(['nama_plant', 'kode_plant']));
        return redirect()->route('plant.index')->with('success', 'Data Plant berhasil diupdate.');
    }

    public function destroy($id_plant)
    {
        $plant = SipekaPlant::findOrFail($id_plant);
        $plant->delete();
        return redirect()->route('plant.index')->with('success', 'Data Plant berhasil dihapus.');
    }
}
