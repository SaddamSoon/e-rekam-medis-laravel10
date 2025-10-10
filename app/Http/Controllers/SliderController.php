<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
class SliderController extends Controller
{
    public function index(){
        return view('dashboard.admin.CMS.slider.index', [
            'slider' => Slider::all()
        ]);
    }
    
    public function create(){
        
        $totalOrdArr = Slider::pluck('order')->toArray();
        // dd($totalOrdArr);
        if(empty($totalOrdArr)){
            array_push($totalOrdArr, 0);
        }
        $currOrd = max($totalOrdArr)+1;
        array_push($totalOrdArr, $currOrd);
        sort($totalOrdArr);
        $link = Slider::pluck('link')->toArray();
        // dd($link);
        if(!count($totalOrdArr) < 3){
            return redirect('/dashboard/slider');
        }
        return view('dashboard.admin.cms.slider.create',[
            'order' => $totalOrdArr,
            'link' => $link,
        ]);
    }
    public function store(Request $request){
        $totalOrdArr = Slider::pluck('order')->toArray();
        // dd($totalOrdArr);
        if(empty($totalOrdArr)){
            array_push($totalOrdArr, 0);
        }
        $currOrd = max($totalOrdArr)+1;
        array_push($totalOrdArr, $currOrd);
        sort($totalOrdArr);
        
        if(!count($totalOrdArr) < 3){
            return redirect('/dashboard/slider');
        }
        $request->validate([
            'img_url' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'caption' => 'required',
            'link' => 'required',
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
            'link' => $request->link,
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
            'link' => 'required',
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
        if($request->link != $slider->link){
            $otherSlider= Slider::where('link', $request->link)->first();
            if($otherSlider){
                $otherSlider->update(['link' => $slider->link]);
            }
        }
       Slider::where('id', $slider->id)->update([
            'img_url' => $namaFile,
            'caption' => $request->caption,
            'order' => $request->order,
            'link' => $request->link,
            'is_active' => $request->is_active,
            'lastupdate_by' => 1,
       ]);

       return redirect('/dashboard/slider')->with('success', 'Sukses Edit Slider');
    }
    
    public function destroy($id){
        $totalOrdArr = Slider::pluck('order')->toArray();
        // dd($totalOrdArr);
        if(empty($totalOrdArr)){
            array_push($totalOrdArr, 0);
        }
        $currOrd = max($totalOrdArr)+1;
        array_push($totalOrdArr, $currOrd);
        sort($totalOrdArr);
        if($totalOrdArr == 1){
            return redirect('/dashboard/slider');
        }
        $slider = Slider::where('id', $id)->first();
        if(file_exists(public_path('uploads/slider/'.$slider->img_url))){
            unlink(public_path('/uploads/slider/'.$slider->img_url));
        }
        $slider->delete();

        return redirect('/dashboard/slider')->with('success', 'Sukses Hapus Slider');
    }
}
