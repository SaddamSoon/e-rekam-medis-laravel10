<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PasswordResetController extends Controller
{
    /**
     * Tampilkan form lupa password (input email).
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Kirim link reset password ke email.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Link reset password sudah dikirim ke email kamu.')
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Tampilkan form reset password (pakai token).
     */
    public function showResetForm(Request $request, $token = null)
    {
        $email = $request->query('email');

        // Cari data reset token berdasarkan email
        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        // Validasi token (ingat token di DB sudah di-hash)
        if (! $record || ! Hash::check($token, $record->token)) {
            abort(403, 'Token tidak valid atau sudah kadaluarsa.');
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    /**
     * Proses reset password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login.form')->with('success', 'Password berhasil direset.')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
