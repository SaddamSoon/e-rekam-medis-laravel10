<?php

namespace App\Http\Controllers;

use App\Events\JanjiTemuCreated;
use Illuminate\Http\Request;
use App\Models\janjiTemu;
use App\Models\Dokter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Helpers\WhatsappHelper;
use App\Models\KetDok;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class JanjiTemuController extends Controller
{
    // method index janji temu di dashboard - ADMIN
    public function index(){   
        $user = User::where('id', auth()->user()->id)->first();
        $user->unreadNotifications->markAsRead(); 
        
        $janji_temu = janjiTemu::orderBy('status', 'asc')->get();
        return view('dashboard.admin.janjiTemu.index', [
            'janji_temu' => $janji_temu
        ]);
    }
    // method index janji temu di dashboard - Dokter(ReadOnly, no Action choice)
    public function indexDok(){   
        $user = User::where('id', auth()->user()->id)->first();
        $user->unreadNotifications->markAsRead(); 

        $janji_temu = janjiTemu::where('id_dokter', auth()->user()->id_dokter)->orderBy('created_at', 'asc')->get();
        return view('dashboard.dokter.janjiTemuDok.index', [
            'janji_temu' => $janji_temu
        ]);
    }
    // approve janji temu
    public function approve(Request $request, $id){
        $janji = JanjiTemu::find($request->id);
        $janji->status = 'dikonfirmasi';
        $janji->save();

        if(!$janji){
            return response()->json(['message', 'gagal'], 400);
        }
        $dokter = Dokter::find($janji->id_dokter);
        
        $nama_dokter = $dokter->nama;
        $nama_pasien = urlencode($janji->nama);
        $tanggal = urlencode(Carbon::now('Asia/Jakarta')->format('d M Y'));
        $jam_mulai = urlencode(Carbon::createFromFormat('H:i:s', $dokter->ket_dok->jam_mulai)->format('H:i'));
        $jam_selesai = urlencode(Carbon::createFromFormat('H:i:s', $dokter->ket_dok->jam_selesai)->format('H:i'));
        $pesan = "Halo $nama_pasien,%0AJanji temu Anda di Klinik drg. Birna Marwikka telah disetujui ✅.%0A Dokter: $nama_dokter %0A📅 Jadwal: $tanggal%0A⏰ Waktu: $jam_mulai - $jam_selesai%0A%0AMohon hadir tepat waktu.%0A Silahkan perlihatkan pesan ini kepada petugas klinik %0A Terima kasih 🙏";
        $format_no_hp = WhatsappHelper::formatNumber($janji->no_hp);
        $button = view('dashboard.admin.janjiTemu.partials.button', ['jt' => $janji])->render();
        $col_status = view('dashboard.admin.janjiTemu.partials.col_status', ['jt' => $janji])->render();

        return response()->json([
            'message' => 'Janji temu berhasil approved', 
            'button' => $button,
            'col_status' => $col_status,
            'no_hp' => $format_no_hp,
            'pesan' => $pesan
        ]);
    }
    // method batal janji_temu dari admin klinik
    public function batal(Request $request, $id){
        $janji = JanjiTemu::find($request->id);
        $janji->status = 'batal';
        $janji->save();

        if(!$janji){
            return response()->json(['message', 'gagal'], 400);
        }
        $dokter = Dokter::find($janji->id_dokter);
        $nama_dokter = $dokter->nama;
        $nama_pasien = urlencode($janji->nama_pasien);
        $tanggal = urlencode(Carbon::now('Asia/Jakarta')->format('d M Y'));
        $jam_mulai = urlencode(Carbon::createFromFormat('H:i:s', $dokter->ket_dok->jam_mulai)->format('H:i'));
        $jam_selesai = urlencode(Carbon::createFromFormat('H:i:s', $dokter->ket_dok->jam_selesai)->format('H:i'));
        $pesan = "Halo $nama_pasien,%0A
                    Mohon maaf, janji temu Anda di Klinik drg. Birna Marwikka pada:%0A
                    Dokter: $nama_dokter %0A
                    📅 Jadwal: $tanggal%0A
                    ⏰ Waktu: $jam_mulai - $jam_selesai%0A
                    %0ATerpaksa *dibatalkan* karena ada keperluan mendadak dari dokter.%0A
                    Silakan hubungi klinik untuk penjadwalan ulang.%0A
                    Terima kasih atas pengertiannya 🙏";
        $format_no_hp = WhatsappHelper::formatNumber($janji->no_hp);
        $col_status = view('dashboard.admin.janjiTemu.partials.col_status', ['jt' => $janji])->render();
        $button = view('dashboard.admin.janjiTemu.partials.button', ['jt' => $janji])->render();

        return response()->json([
            'message' => 'Pembatalan janji berhasil!', 
            'col_status' => $col_status,
            'no_hp' => $format_no_hp,
            'pesan' => $pesan,
            'button' => $button
        ]);
    }
    // method selesai janji_temu dari admin klinik
    public function selesai(Request $request, $id){
        $janji = JanjiTemu::find($request->id);
        if($janji->status !== 'dikonfirmasi'){
            return response()->json(['message', 'gagal'], 400);
        }
        $janji->status = 'selesai';
        $janji->save();
        if(!$janji){
            return response()->json(['message', 'gagal'], 400);
        }
        
        $col_status = view('dashboard.admin.janjiTemu.partials.col_status', ['jt' => $janji])->render();
        $button = view('dashboard.admin.janjiTemu.partials.button', ['jt' => $janji])->render();

        return response()->json([
            'message' => 'Status janji temu telah selesai', 
            'col_status' => $col_status,
            'button' => $button,
            'redirect' => route('rekmed.create').'?nama='.$janji->nama_pasien.'&tgl_lahir='.            $janji->tgl_lahir
        ]);
    }
    // method request input janji temu - PASIEN
    public function store(Request $request){
        
        $dokter = Dokter::where('id', $request->id_dokter)->first();
        $JmlLimitJanjiDok = KetDok::sum('limit_janji');
        if($JmlLimitJanjiDok >= 30){
            return response()->json(['gagal', 'Limit Janji Temu telah habis untuk hari ini'], 405);
        }
        if($dokter->ket_dok->limit_janji === null){
            $dokter->ket_dok->limit_janji = 1;
            $dokter->save();
        }else{
            $dokter->ket_dok->limit_janji += 1;
            $dokter->save();
        }
        $jamSelesai  = Carbon::createFromFormat('H:i:s', $dokter->ket_dok->jam_selesai);
        //jika ada user mencoba menghilangkan disable tombol janji temu melalui inspect browser
        if($dokter->ket_dok->status == 'Tidak Tersedia'){
            return response()->json(['gagal' => 'Jangan Coba-coba!'], 400);
        }
        $validator = Validator::make($request->all(), [
            'nama_pasien' => 'required',
            'tgl_lahir' => 'required',
            'no_hp' => ['required','regex:/^(?:\+62|62|0)8[1-9][0-9]{6,11}$/', Rule::unique('janji_temu', 'no_hp')
            ->where(fn ($query) => 
                $query->whereDate('created_at', now()->toDateString())
            )], 
            'alamat' => 'required',
            'keluhan' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        
        $janjiTemu = janjiTemu::create([
            'id_dokter' => $request->id_dokter,
            'nama_pasien' => $request->nama_pasien,
            'tgl_lahir' => $request->tgl_lahir,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'keluhan' => $request->keluhan,
            'status' => 'pending',
        ]);
        // trigger event notif
        event(new JanjiTemuCreated($janjiTemu));
        
        return response()->json(['message' => 'Janji temu dikirim, Menunggu konfirmasi Admin lewat WA']);

    }

}
