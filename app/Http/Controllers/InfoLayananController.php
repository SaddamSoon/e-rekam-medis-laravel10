<?php

namespace App\Http\Controllers;

use App\Models\LayananTarif;
use App\Models\KetDok;
use App\Models\Poly;
use Illuminate\Http\Request;

class InfoLayananController extends Controller
{
    public function index(){
        return view('dashboard.admin.cms.layanan.index', [
            'layanan' => LayananTarif::all(),
            'poly' => Poly::all()
        ]);
    }
    
    public function create(){
        $poly = Poly::all();
        return view('dashboard.admin.cms.layanan.create', ['poly' => $poly]);
    }
    public function store(Request $request){
        $request->validate([
            'img_url' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'caption' => 'required',
            'poly' => 'required',
            'price' => 'required',
            'is_active' => 'required',
        ]);
        if($request->hasFile('img_url')){
            $file = $request->file('img_url');
            $namaFile = time().'-'.$file->getClientOriginalName();
            $file->move(public_path('uploads/layanan'), $namaFile);
        }
        
       LayananTarif::create([
            'img_url' => $namaFile,
            'caption' => $request->caption,
            'id_poly' => $request->poly,
            'price' => $request->price,
            'is_active' => $request->is_active,
            'created_by' => 1,
            'lastupdate_by' => 1,
       ]);

       return redirect('/dashboard/layanan')->with('success', 'Sukses Tambah Layanan Tarif');
    }
    public function edit(LayananTarif $layanan){
       
        return view('dashboard.admin.cms.layanan.edit', [
            'layanan' => $layanan,
            'poly' => Poly::all(),
        ]);
    }
    public function update(Request $request, LayananTarif $layanan){
        $request->validate([
            'img_url' => 'image|mimes:jpeg,jpg,png|max:2048',
            'caption' => 'required',
            'poly' => 'required',
            'price' => 'required',
            'is_active' => 'required'
        ]);
        if($request->hasFile('img_url')){
            // hapus file
            if(file_exists(public_path('uploads/layanan/'.$layanan->img_url))){
                unlink(public_path('uploads/layanan/'.$layanan->img_url));
            }
            $file = $request->file('img_url');
            $namaFile = time().'-'.$file->getClientOriginalName();
            $file->move(public_path('uploads/layanan'), $namaFile);
        }else{
            $namaFile = $layanan->img_url;
        }
        
        
       LayananTarif::where('id', $layanan->id)->update([
            'img_url' => $namaFile,
            'caption' => $request->caption,
            'id_poly' => $request->poly,
            'price' => $request->price,
            'is_active' => $request->is_active,
            'lastupdate_by' => 1,
       ]);

       return redirect('/dashboard/layanan')->with('success', 'Sukses Edit Layanan Tarif');
    }
    
    public function destroy($id){
        $layanan = LayananTarif::where('id', $id)->first();
        if(file_exists(public_path('uploads/layanan/'.$layanan->img_url))){
            unlink(public_path('/uploads/layanan/'.$layanan->img_url));
        }
        $layanan->delete();

        return redirect('/dashboard/layanan')->with('success', 'Sukses Hapus Layanan Tarif');
    }
}
