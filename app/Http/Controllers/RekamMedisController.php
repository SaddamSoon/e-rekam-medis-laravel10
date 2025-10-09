<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Rekmed;
use App\Models\Pasien;
use App\Models\Obat;
use App\Models\ResepObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class RekamMedisController extends Controller
{
    public function index(){
        if(Gate::allows('isAdmin')){
            $rekmed = Rekmed::all();
        }else{
            $rekmed = Rekmed::where('id_dokter', auth()->user()->id_dokter)->get();
        }
        return view('dashboard.admin.rekmed.index', [
            'rekmed' => $rekmed
        ]);
    }
    
    public function create(Request $request){
        $nama = $request->nama;
        $tgl_lahir = $request->tgl_lahir;
        $pasienOld = Pasien::where('nama',$nama)->where('tanggal_lahir',$tgl_lahir)->first();
        
        return view('dashboard.admin.rekmed.create', [
            'pasien' => Pasien::all(),
            'obat' => Obat::all(),
            'pasienOld' => $pasienOld
        ]);
    }
    public function selectedPasien(Request $request){
       $pasien = Pasien::where('id', $request->id_pasien)->first();
       return response()->json([
                'asal' => $pasien->alamat,
                'tanggal_lahir' => $pasien->tanggal_lahir,
                'no_hp' => $pasien->no_hp
            ]);
    }
    public function store(Request $request){
        $dokter = Dokter::where('id', auth()->user()->id_dokter)->first();
        $validated = [
            'diagnosa' => 'required',
            'tindakan' => 'required',
            'asal' => 'required',
            'tanggal_lahir' => 'required',
            'no_hp' => 'required',
        ];
        if($request->has('nama_text') && $request->nama_text != null){
            $validated['nama_text'] = 'required|max:80';
        }else{
            $validated['nama_select'] = 'required|max:80';
        }
        if($request->jumlah[0] != null || $request->nama_obat[0] != null || $request->ket_dosis[0] != null){
            $validated['jumlah.*'] = 'required';
            $validated['nama_obat.*'] = 'required';
            $validated['ket_dosis.*'] = 'required';
        }

        $request->validate($validated);
        if($request->has('nama_text') && $request->nama_text != null){
            Pasien::create([
                'nama' => $request->nama_text,
                'alamat' => $request->asal,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp' => $request->no_hp,
                'created_by' => auth()->user()->id_dokter,
            ]);
            $lastIdPasien = Pasien::max('id');
            Rekmed::create([
                'id_pasien' => $lastIdPasien,
                'id_dokter' => auth()->user()->id_dokter,
                'tgl_periksa' => now(),
                'diagnosa' => $request->diagnosa,
                'poly' => $dokter->poly->id,
                'tindakan' => $request->tindakan
            ]);

        if($request->jumlah[0] != null || $request->nama_obat[0] != null || $request->ket_dosis[0] != null){
            $lastIdRekmed = Rekmed::max('id');
            $jumlah = $request->jumlah;
            $obat_id = $request->nama_obat;
            $ket_dosis = $request->ket_dosis;
            if($jumlah && $obat_id && $ket_dosis){
                foreach($jumlah as $i => $jml){
                    ResepObat::create([
                        'id_rekam' => $lastIdRekmed, 
                        'id_obat' => $obat_id[$i], 
                        'jumlah' => $jml, 
                        'ket_dosis' => $ket_dosis[$i]
                    ]);
                }
            }
        }
            
        }else{
            Rekmed::create([
                'id_pasien' => $request->nama_select,
                'id_dokter' => auth()->user()->id_dokter,
                'tgl_periksa' => now(),
                'poly' => $dokter->poly->id,
                'diagnosa' => $request->diagnosa,
                'tindakan' => $request->tindakan
            ]);

        if($request->jumlah[0] != null || $request->nama_obat[0] != null || $request->ket_dosis[0] != null){
            $lastIdRekmed = Rekmed::max('id');
            $jumlah = $request->jumlah;
            $obat_id = $request->nama_obat;
            $ket_dosis = $request->ket_dosis;
            if($jumlah && $obat_id && $ket_dosis){
                foreach($jumlah as $i => $jml){
                    ResepObat::create([
                        'id_rekam' => $lastIdRekmed, 
                        'id_obat' => $obat_id[$i], 
                        'jumlah' => $jml, 
                        'ket_dosis' => $ket_dosis[$i]
                    ]);
                }
            }
        }

          
        }
      
       

       return redirect('/dashboard/rekmed')->with('success', 'Sukses Tambah Rekam Medis');
    }
    public function edit($id)
        {
            $rekmed = Rekmed::findOrFail($id);
            $obat = Obat::all();
            $pasien = Pasien::all();

            // Ambil old input dulu, kalau ada
            $jumlahOld = old('jumlah', $rekmed->resep->pluck('jumlah')->toArray());
            $namaObatOld = old('nama_obat', $rekmed->resep->pluck('id_obat')->toArray());
            $ketDosisOld = old('ket_dosis', $rekmed->resep->pluck('ket_dosis')->toArray());

            // hitung max jumlah row
            $count = max(count($jumlahOld), count($namaObatOld), count($ketDosisOld), 1);

            return view('dashboard.admin.rekmed.edit', compact(
                'rekmed',
                'obat',
                'jumlahOld',
                'namaObatOld',
                'ketDosisOld',
                'count',
                'pasien'
            ));
        }



public function update(Request $request, $id)
{
    $rekmed = Rekmed::findOrFail($id);

    // Validasi hanya untuk rekmed & resep
    $validated = [
        'diagnosa' => 'required',
        'tindakan' => 'required',
    ];

    // Jika ada resep, validasi resep
    if (
        $request->jumlah[0] != null ||
        $request->nama_obat[0] != null ||
        $request->ket_dosis[0] != null
    ) {
        $validated['jumlah.*'] = 'required';
        $validated['nama_obat.*'] = 'required';
        $validated['ket_dosis.*'] = 'required';
    }

    $request->validate($validated);

    // Update rekam medis
    $rekmed->diagnosa = $request->diagnosa;
    $rekmed->tindakan = $request->tindakan;
    $rekmed->save();

    // Update resep obat
    ResepObat::where('id_rekam', $rekmed->id)->delete();

    if (
        $request->jumlah[0] != null ||
        $request->nama_obat[0] != null ||
        $request->ket_dosis[0] != null
    ) {
        $jumlah = $request->jumlah;
        $obat_id = $request->nama_obat;
        $ket_dosis = $request->ket_dosis;

        foreach ($jumlah as $i => $jml) {
            if (!empty($jml) && !empty($obat_id[$i]) && !empty($ket_dosis[$i])) {
                ResepObat::create([
                    'id_rekam' => $rekmed->id,
                    'id_obat' => $obat_id[$i],
                    'jumlah' => $jml,
                    'ket_dosis' => $ket_dosis[$i],
                ]);
            }
        }
    }

    return redirect('/dashboard/rekmed')
        ->with('success', 'Sukses Update Rekam Medis');
}


    
        public function destroy($id)
        {
            $rekmed = Rekmed::with('resep')->findOrFail($id);
            if($rekmed->id_dokter == auth()->user()->id_dokter || auth()->user()->roles == 'Admin'){
            // Hapus semua resep dulu
            $rekmed->resep()->delete();

            // Hapus rekmed
            $rekmed->delete();

            return redirect()->route('rekmed')
                            ->with('success', 'Data rekam medis dan resep berhasil dihapus.');
            }
            
        }

}
