<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\KetDok;
use Illuminate\Http\Request;

class KetdokController extends Controller
{
    // public function index(){
    //     $ketdok = KetDok::where('id_dokter', 8)->first();
    //     $dokter = Dokter::all();
    //     return view('dashboard.dokter.ketersediaan_dokter.index', [
    //         'ketdok' => $ketdok,
    //         'dokter' => $dokter,
    //     ]);
    // }
    public function update(Request $request, $id){
        $ketdok = KetDok::findOrFail($id);
        $ketdok->update($request->all());

        return response()->json([
        'message' => 'Data ketersediaan dokter berhasil diupdate',
        'data' => $ketdok
        ]);

    }
}
