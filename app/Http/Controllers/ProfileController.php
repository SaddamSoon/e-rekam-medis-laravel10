<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Dokter;


class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $dokter = '';
        if($request->user()->id_dokter !== null){
            $dokter = Dokter::where('id', $request->user()->id_dokter)->first()->spesialis->nama;
        }
        return view('dashboard.profile.index', [
            'user' => $request->user(),
            'dokter' => $dokter
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'new_password.confirmed' => 'Konfirmasi password baru tidak sama.',
            'new_password.min' => 'Password minimal 6 karakter.',
            'current_password.required' => 'Password lama wajib diisi.',
        ]);

        // cek password lama
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        // update password
        User::where('id', auth()->id())->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

}
