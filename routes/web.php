<?php

use Carbon\Carbon;
use App\Models\Obat;
use App\Models\Poly;
use App\Models\About;
use App\Models\Dokter;
use App\Models\KetDok;
use App\Models\Rekmed;
use App\Models\Slider;
use App\Models\LayananTarif;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\KetdokController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JanjiTemuController;
use App\Http\Controllers\SpesialisController;
use App\Http\Controllers\RekamMedisController;
use App\Http\Controllers\InfoLayananController;
use App\Http\Controllers\PasswordResetController;
use App\Models\janjiTemu;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Informasi Layanan
Route::get('/', function () {
    $dokter = Dokter::all();
    $slider = Slider::all();
    $about = About::where('is_active', 1)->first();
    return view('informasiLayanan.index',[
        'dokter' => $dokter,
        'slider' => $slider,
        'about' => $about,
    ]);
});
// addons
Route::post('/janjitemu', [JanjiTemuController::class, 'store']); //input data pendaftaran janji temu 
Route::get('/logout', function () {
    return redirect()->route('login.form')->with('error', 'Logout hanya bisa dengan tombol logout.');
});
Route::get('/layanan-tarif', function(){
    return view('informasiLayanan.layanan_tarif',['layanan' => LayananTarif::all(), 'poly' => Poly::all()]);
})->name('layanan-tarif');
// authenticated
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $dokter = Dokter::count();
        if(Gate::allows('isAdmin')){
            $rekmed = Rekmed::whereBetween('created_at', [
                Carbon::now()->subWeek(), 
                Carbon::now()             
                ])->count();
            $status = [];
            $janjiTemu = janjiTemu::whereDate('created_at', Carbon::now())->count();
        }else{
            $rekmed = Rekmed::where('id_dokter', auth()->user()->id_dokter)->whereBetween('created_at', [
                        Carbon::now()->subWeek(), 
                        Carbon::now()             
                    ])->count();
            $dokter = Dokter::where('id', auth()->user()->id_dokter)->first();
            $status = $dokter->ket_dok->status;
            $janjiTemu = janjiTemu::where('id_dokter', auth()->user()->id_dokter)->whereDate('created_at', Carbon::now())->count();
        }
        $dokTersedia = Dokter::
                            whereHas('ket_dok', function ($query) {
                        $query->where('status', 'tersedia');})->count();
        $obat = Obat::count();
        return view('dashboard.admin.index', [
            'dokter' => $dokter,
            'rekmed' => $rekmed,
            'dokTersedia' => $dokTersedia,
            'obat' => $obat,
            'status' => $status,
            'janjiTemu' => $janjiTemu,
        ]);
    });
    // Rekmed
    Route::get('/dashboard/rekmed', [RekamMedisController::class, 'index'])->name('rekmed');
    // Pasien
    Route::get('/dashboard/pasien', [PasienController::class, 'index'])->name('pasien');
    Route::get('/dashboard/pasien/create', [PasienController::class, 'create'])->name('pasien.create');
    Route::post('/dashboard/pasien', [PasienController::class, 'store'])->name('pasien.store');
    Route::get('/dashboard/pasien/{pasien:id}', [PasienController::class, 'edit']);
    Route::put('/dashboard/pasien/{pasien:id}', [PasienController::class, 'update'])->name('pasien.update');
    Route::delete('/dashboard/pasien/{id}', [PasienController::class, 'destroy'])->name('pasien.destroy');
    //Profile User
    Route::get('/dashboard/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    //janji temu in admin dashboard
    Route::get('/dashboard/janjitemu', [JanjiTemuController::class, 'index'])->name('janjitemu');
    Route::put('/dashboard/janjitemu_appr/{id}', [JanjiTemuController::class, 'approve'])->name('janjitemu.approve');
    Route::put('/dashboard/janjitemu_batal/{id}', [JanjiTemuController::class, 'batal'])->name('janjitemu.batal');
    Route::put('/dashboard/janjitemu_selesai/{id}', [JanjiTemuController::class, 'selesai'])->name('janjitemu.selesai');
    //logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

// isAdmin
Route::middleware(['isAdmin'])->group(function () {
    // Dokter
    Route::get('/dashboard/dokter', [DokterController::class, 'index'])->name('dokter');
    Route::get('/dashboard/dokter/create', [DokterController::class, 'create'])->name('dokter.create');
    Route::post('/dashboard/dokter', [DokterController::class, 'store'])->name('dokter.store');
    Route::get('/dashboard/dokter/{dokter:id}', [DokterController::class, 'edit']);
    Route::put('/dashboard/dokter/{dokter:id}', [DokterController::class, 'update'])->name('dokter.update');
    Route::delete('/dashboard/dokter/{id}', [DokterController::class, 'destroy'])->name('dokter.destroy');
    // Ketersediaan Dokter
    // Route::get('/dashboard/ketdok', [KetdokController::class, 'index'])->name('ketdok');
    Route::put('/dashboard/ketdok/{id}', [KetdokController::class, 'update'])->name('ketdok.update');
    // Obat
    Route::get('/dashboard/obat', [ObatController::class, 'index'])->name('obat');
    Route::get('/dashboard/obat/create', [ObatController::class, 'create'])->name('obat.create');
    Route::post('/dashboard/obat', [ObatController::class, 'store'])->name('obat.store');
    Route::get('/dashboard/obat/{obat:id}', [ObatController::class, 'edit']);
    Route::put('/dashboard/obat/{obat:id}', [ObatController::class, 'update'])->name('obat.update');
    Route::delete('/dashboard/obat/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');
    // Spesialis Dokter
    Route::get('/dashboard/spes', [SpesialisController::class, 'index'])->name('spes');
    Route::get('/dashboard/spes/create', [SpesialisController::class, 'create'])->name('spes.create');
    Route::post('/dashboard/spes', [SpesialisController::class, 'store'])->name('spes.store');
    Route::get('/dashboard/spes/{spesialis:id}', [SpesialisController::class, 'edit']);
    Route::put('/dashboard/spes/{spesialis:id}', [SpesialisController::class, 'update'])->name('spes.update');
    
    //=================CMS=================\\
    // SLider
    Route::get('/dashboard/slider', [SliderController::class, 'index'])->name('slider');
    Route::get('/dashboard/slider/create', [SliderController::class, 'create'])->name('slider.create');
    Route::post('/dashboard/slider', [SliderController::class, 'store'])->name('slider.store');
    Route::get('/dashboard/slider/{slider:id}', [SliderController::class, 'edit']);
    Route::put('/dashboard/slider/{slider:id}', [SliderController::class, 'update'])->name('slider.update');
    Route::delete('/dashboard/slider/{slider:id}', [SliderController::class, 'destroy'])->name('slider.destroy');
    // About
    Route::get('/dashboard/about', [AboutController::class, 'index'])->name('about');
    Route::get('/dashboard/about/create', [AboutController::class, 'create'])->name('about.create');
    Route::post('/dashboard/about', [AboutController::class, 'store'])->name('about.store');
    Route::get('/dashboard/about/{about:id}', [AboutController::class, 'edit']);
    Route::put('/dashboard/about/{about:id}', [AboutController::class, 'update'])->name('about.update');
    Route::delete('/dashboard/about/{about:id}', [AboutController::class, 'destroy'])->name('about.destroy');
    // Layanan dan Tarif
    Route::get('/dashboard/layanan', [InfoLayananController::class, 'index'])->name('layanan');
    Route::get('/dashboard/layanan/create', [InfoLayananController::class, 'create'])->name('layanan.create');
    Route::post('/dashboard/layanan', [InfoLayananController::class, 'store'])->name('layanan.store');
    Route::get('/dashboard/layanan/{layanan:id}', [InfoLayananController::class, 'edit']);
    Route::put('/dashboard/layanan/{layanan:id}', [InfoLayananController::class, 'update'])->name('layanan.update');
    Route::delete('/dashboard/layanan/{layanan:id}', [InfoLayananController::class, 'destroy'])->name('layanan.destroy');
});

// isDokter
Route::middleware(['isDokter'])->group(function () {
    //=================e-Rekam Medis=================\\
    Route::get('/dashboard/rekmed/selectpasien', [RekamMedisController::class, 'selectedPasien']);
    Route::get('/dashboard/rekmed/create', [RekamMedisController::class, 'create'])->name('rekmed.create');
    Route::post('/dashboard/rekmed', [RekamMedisController::class, 'store'])->name('rekmed.store');
    Route::get('/dashboard/rekmed/{dokter:id}', [RekamMedisController::class, 'edit']);
    Route::put('/dashboard/rekmed/{dokter:id}', [RekamMedisController::class, 'update'])->name('rekmed.update');
    Route::delete('/dashboard/rekmed/{id}', [RekamMedisController::class, 'destroy'])->name('rekmed.destroy');
    //janji temu readonly
    // Route::get('/dashboard/janjitemuDok', [JanjiTemuController::class, 'indexDok'])->name('janjitemuDok');

});

// guest 
Route::middleware(['guest'])->group(function(){
    // Forgot Password
    Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    // Auth (Login)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

