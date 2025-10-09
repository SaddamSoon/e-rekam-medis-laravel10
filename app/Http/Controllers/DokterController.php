<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\KetDok;
use App\Models\Pasien;
use App\Models\Rekmed;
use App\Models\User;
use App\Models\spesialis;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index(){
        return view('dashboard.admin.dokter.index', [
            'dokter' => Dokter::all()
        ]);
    }
    
    public function create(){
        return view('dashboard.admin.dokter.create', [
            'spesialis' => spesialis::all()
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'nama' => 'required|max:100',
            'email' => 'required',
            'no_str' => 'required|max:12',
            'password' => 'required|max:16',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'id_spesialis' => 'required|exists:spesialis_dokter,id',
            'no_hp' => 'required|max:18'
        ]);
       Dokter::create([
        'nama' => $request->nama,
        'id_spesialis' => $request->id_spesialis,
        'id_poly' => spesialis::where('id', $request->id_spesialis)->first()->id_poly,
        'no_str' => $request->no_str
       ]);
       KetDok::create([
        'id_dokter' => Dokter::max('id'),
        'jam_mulai' => $request->jam_mulai,
        'jam_selesai' => $request->jam_selesai,
        'status' => 'Tidak Tersedia'
       ]);
       $lastIdDokter = Dokter::max('id');
       User::create([
        'id_dokter' => $lastIdDokter,
        'name' => $request->nama,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'no_hp' => $request->no_hp,
        'roles' => 'Dokter'
       ]);

       return redirect('/dashboard/dokter')->with('success', 'Sukses Tambah Dokter');
    }
    public function edit(Dokter $dokter){
        return view('dashboard.admin.dokter.edit', [
            'spesialis' => spesialis::all(),
            'dokter' => $dokter
        ]);
    }
    public function update(Request $request, Dokter $dokter){
        $request->validate([
            'nama' => 'required|max:100',
            'email' => 'required',
            'no_str' => 'required|max:12',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'id_spesialis' => 'required|exists:spesialis_dokter,id',
            'no_hp' => 'required|max:18'
        ]);
       Dokter::where('id', $dokter->id)->update([
        'nama' => $request->nama,
        'id_spesialis' => $request->id_spesialis,
        'no_str' => $request->no_str
       ]);
       if(!KetDok::where('id_dokter', $dokter->id)->exists()){
           KetDok::create([
                'id_dokter' => $dokter->id,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => 'Tidak Tersedia'
            ]);
       }else{
         KetDok::where('id_dokter', $dokter->id)->update([
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai
        ]);
       }

       User::where('id_dokter', $dokter->id)->update([
        'id_dokter' => $dokter->id,
        'name' => $request->nama,
        'email' => $request->email,
        'no_hp' => $request->no_hp
       ]);

       return redirect('/dashboard/dokter')->with('success', 'Sukses Edit Dokter');
    }
    
    public function destroy($id){
        $updateRekmed = Rekmed::where('id_dokter', $id)->update([
            'id_dokter'  => NULL
        ]);
        $user = User::where('id_dokter', $id)->first();
        $updatePasien = Pasien::where('created_by', $user->id_dokter)->update([
            'created_by' => 1
        ]);
        $user->delete();
        
        if(KetDok::where('id_dokter', $id)->exists()){
            $ket_dok = KetDok::where('id_dokter', $id)->first();
            $ket_dok->delete();
        }

        $dokter = Dokter::findOrFail($id);
        $dokter->delete();


        return redirect('/dashboard/dokter')->with('success', 'Sukses Hapus Dokter');
    }
}
