<?php

namespace App\Http\Controllers;

use App\Models\spesialis;
use Illuminate\Http\Request;

class SpesialisController extends Controller
{
    public function index(){
        return view('dashboard.admin.spesialis.index', [
            'spesialis' => spesialis::all()
        ]);
    }
    
    public function create(){
        return view('dashboard.admin.spesialis.create', [
            'spesialis' => spesialis::all()
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'nama' => 'required|max:100'
        ]);
       spesialis::create([
        'nama' => $request->nama
       ]);
       

       return redirect('/dashboard/spes')->with('success', 'Sukses Tambah Spesialis');
    }
    public function edit(spesialis $spesialis){
        return view('dashboard.admin.spesialis.edit', [
            'spesialis' => $spesialis
        ]);
    }
    public function update(Request $request, spesialis $spesialis){
        $request->validate([
            'nama' => 'required|max:100',
        ]);
       spesialis::where('id', $spesialis->id)->update([
        'nama' => $request->nama
       ]);

       return redirect('/dashboard/spes')->with('success', 'Sukses Edit Spesialis');
    }
    
    // public function destroy($id){
    //     $spesialis = spesialis::findOrFail($id);
    //     $spesialis->delete();


    //     return redirect('/dashboard/spes')->with('success', 'Sukses Hapus Spesialis');
    // }
}
