<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Obat;
use App\Models\User;
use App\Models\spesialis;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(){
        return view('dashboard.admin.obat.index', [
            'obat' => Obat::all()
        ]);
    }
    
    public function create(){
        return view('dashboard.admin.obat.create');
    }
    public function store(Request $request){
        $request->validate([
            'nama' => 'required|max:100',
            'harga' => 'required|integer'
        ]);
       Obat::create([
        'nama' => $request->nama,
        'harga' => $request->harga
       ]);
       

       return redirect('/dashboard/obat')->with('success', 'Sukses Tambah Obat');
    }
    public function edit(Obat $obat){
        return view('dashboard.admin.obat.edit', [
            'obat' => $obat
        ]);
    }
    public function update(Request $request, Obat $obat){
        $request->validate([
            'nama' => 'required|max:100',
            'harga' => 'required|integer'
        ]);
       Obat::where('id', $obat->id)->update([
        'nama' => $request->nama,
        'harga' => $request->harga
       ]);

       return redirect('/dashboard/obat')->with('success', 'Sukses Edit Obat');
    }
    
    public function destroy($id){
        $obat = Obat::where('id', $id)->first();
        $obat->delete();

        return redirect('/dashboard/obat')->with('success', 'Sukses Hapus Obat');
    }
}
