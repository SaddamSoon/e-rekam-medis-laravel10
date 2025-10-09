<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
class PasienController extends Controller
{
    public function index(){
        return view('dashboard.admin.pasien.index', [
            'pasien' => Pasien::all()
        ]);
    }
    
    public function create(){
        return view('dashboard.admin.pasien.create');
    }
    public function store(Request $request){
        $request->validate([
            'nama' => 'required|max:100',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp' => 'required|max:16',
        ]);
       Pasien::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp' => $request->no_hp,
            'created_by' => auth()->user()->id
       ]);

       return redirect('/dashboard/pasien')->with('success', 'Sukses Tambah Pasien');
    }
    public function edit(Pasien $pasien){
        return view('dashboard.admin.pasien.edit', [
            'pasien' => $pasien
        ]);
    }
    public function update(Request $request, Pasien $pasien){
        $request->validate([
            'nama' => 'required|max:100',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp' => 'required|max:16',
        ]);
       Pasien::where('id', $pasien->id)->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp' => $request->no_hp,
       ]);

       return redirect('/dashboard/pasien')->with('success', 'Sukses Edit Pasien');
    }
    
    public function destroy($id){
        $pasien = pasien::where('id', $id)->first();
        $pasien->delete();



        return redirect('/dashboard/pasien')->with('success', 'Sukses Hapus Pasien');
    }
}
