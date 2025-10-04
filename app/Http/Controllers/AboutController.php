<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\About;

class AboutController extends Controller
{
    public function index(){
        return view('dashboard.admin.cms.about.index', [
            'about' => About::all()
        ]);
    }
    
    public function create(){
        
        return view('dashboard.admin.cms.about.create');
    }
    public function store(Request $request){
        // dd($request->text_content);
        $request->validate([
            'img_url' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title' => 'required',
            'text_content' => 'required',
            'is_active' => 'required',
        ]);
        if($request->hasFile('img_url')){
            $file = $request->file('img_url');
            $namaFile = time().'-'.$file->getClientOriginalName();
            $file->move(public_path('uploads/about'), $namaFile);
        }
       
       About::create([
            'img_url' => $namaFile,
            'title' => $request->title,
            'text_content' => $request->text_content,
            'is_active' => $request->is_active,
            'created_by' => 1,
            'lastupdate_by' => 1,
       ]);

       return redirect('/dashboard/about')->with('success', 'Sukses Tambah About');
    }
    public function edit(About $about){
        
        return view('dashboard.admin.cms.about.edit', [
            'about' => $about,
        ]);
    }
    public function update(Request $request, About $about){
        $request->validate([
            'img_url' => 'image|mimes:jpeg,jpg,png|max:2048',
            'title' => 'required',
            'text_content' => 'required',
            'is_active' => 'required',
        ]);
        if($request->hasFile('img_url')){
            // hapus file
            if(file_exists(public_path('uploads/about/'.$about->img_url))){
                unlink(public_path('uploads/about/'.$about->img_url));
            }
            $file = $request->file('img_url');
            $namaFile = time().'-'.$file->getClientOriginalName();
            $file->move(public_path('uploads/about'), $namaFile);
        }else{
            $namaFile = $about->img_url;
        }
        
       About::where('id', $about->id)->update([
            'img_url' => $namaFile,
            'title' => $request->title,
            'text_content' => $request->text_content,
            'is_active' => $request->is_active,
            'lastupdate_by' => 1,
       ]);

       return redirect('/dashboard/about')->with('success', 'Sukses Edit about');
    }
    
    public function destroy($id){
        $about = About::where('id', $id)->first();
        if(file_exists(public_path('uploads/about/'.$about->img_url))){
            unlink(public_path('/uploads/about/'.$about->img_url));
        }
        $about->delete();

        return redirect('/dashboard/about')->with('success', 'Sukses Hapus Data About');
    }
}
