<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LokasiUangController;
use App\Http\Controllers\UangKeluarController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UangMasukController;

Route::resource('lokasi_uangs', LokasiUangController::class);
Route::resource('uang_keluars', UangKeluarController::class);
Route::resource('uang_masuks', UangMasukController::class);
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class,'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class,'registration'])->name('register');
Route::post('post-registration',[AuthController::class, 'postRegistration'])->name('register.post');
Route::get('dashboard', [AuthController::class,'dashboard']);
Route::get('logout', [AuthController::class,'logout'])->name('logout');
// Route::get('/lokasi_uang/{lokasi_uang}/edit', LokasiUangController::class,'edit')->name('lokasi_uangs.edit');
// Route::put('/lokasi_uang/{lokasi_uang}/update', LokasiUangController::class,'update')->name('lokasi_uangs.update');


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

Route::get('/', function () {
    return view('welcome');
});
