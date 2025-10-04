<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
class SliderController extends Controller
{
    public function index(){
        return view('dashboard.admin.cms.slider.index', [
            'slider' => Slider::all()
        ]);
    }
    
    public function create(){
        // note langkah selanjutnya, tampilkan  dulu formnya, baru di lanjut ke logic kolom input order 'all order + 1, sebagai order baru' 
        $totalOrdArr = Slider::pluck('order')->toArray();
        // dd($totalOrdArr);
        if(empty($totalOrdArr)){
            array_push($totalOrdArr, 0);
        }
        $currOrd = max($totalOrdArr)+1;
        array_push($totalOrdArr, $currOrd);
        sort($totalOrdArr);
        return view('dashboard.admin.cms.slider.create',[
            'order' => $totalOrdArr
        ]);
    }
    public function store(Request $request){
        $request->validate([
            'img_url' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'caption' => 'required',
            'order' => 'required',
            'is_active' => 'required',
        ]);
        if($request->hasFile('img_url')){
            $file = $request->file('img_url');
            $namaFile = time().'-'.$file->getClientOriginalName();
            $file->move(public_path('uploads/slider'), $namaFile);
        }
        $allOrd = Slider::pluck('order')->toArray();
        for($i=0;$i<count($allOrd);$i++){
            if($allOrd[$i] == $request->order){
                
                Slider::where('order', $allOrd[$i])->update([
                    'order' => max($allOrd)+1
                ]);
            }
        }
       Slider::create([
            'img_url' => $namaFile,
            'caption' => $request->caption,
            'order' => $request->order,
            'is_active' => $request->is_active,
            'created_by' => 1,
            'lastupdate_by' => 1,
       ]);

       return redirect('/dashboard/slider')->with('success', 'Sukses Tambah Slider');
    }
    public function edit(Slider $slider){
        $totalOrdArr = Slider::pluck('order')->toArray();
        sort($totalOrdArr);
        // dd($totalOrdArr);
        return view('dashboard.admin.cms.slider.edit', [
            'slider' => $slider,
            'order' => $totalOrdArr
        ]);
    }
    public function update(Request $request, Slider $slider){
        $request->validate([
            'img_url' => 'image|mimes:jpeg,jpg,png|max:2048',
            'caption' => 'required',
            'order' => 'required',
            'is_active' => 'required',
        ]);
        if($request->hasFile('img_url')){
            // hapus file
            if(file_exists(public_path('uploads/slider/'.$slider->img_url))){
                unlink(public_path('uploads/slider/'.$slider->img_url));
            }
            $file = $request->file('img_url');
            $namaFile = time().'-'.$file->getClientOriginalName();
            $file->move(public_path('uploads/slider'), $namaFile);
        }else{
            $namaFile = $slider->img_url;
        }
        // nanti jika sudah selesai logic dibawah ini, kita tanya ke gpt gimana cara cek data satu persatu, data request yang sesuai dengan data yang ada
        $allOrd = Slider::pluck('order')->toArray();
        if($request->order !== $slider->order){
            for($i=0;$i<count($allOrd);$i++){
            if($allOrd[$i] == $request->order){
                Slider::where('order', $allOrd[$i])->update([
                    'order' => $slider->order
                ]);
            }
            }
        }
        
       Slider::where('id', $slider->id)->update([
            'img_url' => $namaFile,
            'caption' => $request->caption,
            'order' => $request->order,
            'is_active' => $request->is_active,
            'lastupdate_by' => 1,
       ]);

       return redirect('/dashboard/slider')->with('success', 'Sukses Edit Slider');
    }
    
    public function destroy($id){
        $slider = Slider::where('id', $id)->first();
        if(file_exists(public_path('uploads/slider/'.$slider->img_url))){
            unlink(public_path('/uploads/slider/'.$slider->img_url));
        }
        $slider->delete();

        return redirect('/dashboard/slider')->with('success', 'Sukses Hapus Slider');
    }
}
