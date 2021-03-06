<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Autentikasi\AuthController;
use App\Http\Controllers\Web\Autentikasi\UserController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\Panitia\DashboardPenggunaController;
use App\Http\Controllers\Web\Panitia\PanitiaDesaController;
use App\Http\Controllers\Web\Desa\PendaftaranDesaController;
use App\Http\Controllers\Web\Desa\DashboardSuperadminController;
use App\Http\Controllers\DesaAdatController;
use App\Http\Controllers\Web\MasterData\NomorSuratController;
use App\Http\Controllers\Web\MasterData\PrajuruDesaController;
use App\Http\Controllers\Web\MasterData\PrajuruBanjarController;
use App\Http\Controllers\Web\Surat\SuratKeluarController;
use App\Http\Controllers\Web\Surat\SuratKeluarPanitiaController;
use App\Http\Controllers\Web\Surat\SuratMasukController;
use App\Http\Controllers\Web\Surat\DashboardSuratKeluarController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return view('landing-page');
});

//Auth
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/loginsession', [AuthController::class, 'loginsession'])->name('loginsession');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Middleware Admin
Route::group(['middleware' => ['auth','cek_login:Admin,Bendesa,Penyarikan,Panitia']], function () {
    route::get('/admin', [DashboardController::class, 'index'])->name('admin');
});

// Route::group(['middleware' => ['auth', 'cek_login:Kepala Desa']], function () {
//     route::get('/kades', [DashboardController::class, 'index'])->name('kades');
// });

Route::group(['middleware' => ['auth', 'cek_login:Krama']], function () {
    route::get('/panitia', [DashboardController::class, 'index'])->name('panitia');
});

// Middleware Superadmin
Route::group(['middleware' => ['auth', 'cek_login:Super Admin']], function () {
    route::get('/superadmin', [DashboardSuperadminController::class, 'index'])->name('superadmin');
    route::get('/superadmin/desa/konfirmasi/{id}', [DashboardSuperadminController::class, 'edit'])->name('konfirm-pendaftaran-desa');
    route::get('/superadmin/desa/detail/{id}', [DashboardSuperadminController::class, 'show'])->name('detail-desa');
    route::get('/superadmin/desa/berhasil/{id}', [DashboardSuperadminController::class, 'update'])->name('pendaftaran-desa-berhasil');
    route::post('/superadmin/desa/tolak', [DashboardSuperadminController::class, 'tolak'])->name('pendaftaran-desa-ditolak');
    route::get('/superadmin/desa/detail/tolak/{id}', [DashboardSuperadminController::class, 'showtolak'])->name('detail-desa-tolak');
    route::get('/superadmin/search', [DashboardSuperadminController::class, 'search'])->name('search-data-desa');
});

// //Middleware User
Route::group(['middleware' => ['auth', 'cek_login:Krama']], function () {
    route::get('/krama', [DashboardPenggunaController::class, 'index'])->name('krama');
});

Route::get('/master-data', function () {
    return view('superadmin.masterdata.master-data');
});

//Pendaftaran Desa
Route::get('/desaadat/create', [PendaftaranDesaController::class, 'create'])->name('create-desa-adat');
Route::post('/desaadat/create/getkabupaten', [PendaftaranDesaController::class, 'getkabupaten'])->name('get-kabupaten');
Route::post('/desaadat/create/getkecamatan', [PendaftaranDesaController::class, 'getkecamatan'])->name('get-kecamatan');
Route::post('/desaadat/create/getdesaadat', [PendaftaranDesaController::class, 'getdesaadat'])->name('get-desa-adat');
Route::post('/desaadat/create/caridata', [PendaftaranDesaController::class, 'loaddata'])->name('caridata');
Route::post('/desaadat/save', [PendaftaranDesaController::class, 'save'])->name('save-desa-adat');
Route::get('/desaadat/create/success', [PendaftaranDesaController::class, 'success'])->name('daftar-desa-sukses');

//Desa
Route::get('/desa', [DesaController::class, 'index'])->name('desa');
Route::post('/desa/add', [DesaController::class, 'store'])->name('add-desa');
Route::get('/desa/edit/{id}', [DesaController::class, 'edit'])->name('edit-desa');
Route::post('/desa/update/{id}', [DesaController::class, 'update'])->name('update-desa');
Route::get('/desa/delete/{id}', [DesaController::class, 'destroy'])->name('delete-desa');


//Nomor Surat
Route::get('/nomor-surat', [NomorSuratController::class, 'index'])->name('nomor-surat');
Route::get('/nomor-surat/create', [NomorSuratController::class, 'create'])->name('create-nomor-surat');
Route::post('/nomor-surat/add', [NomorSuratController::class, 'store'])->name('add-update-nomor-surat');
Route::post('/nomor-surat/edit', [NomorSuratController::class, 'edit'])->name('edit-nomor-surat');
Route::post('/nomor-surat/update/{id}', [NomorSuratController::class, 'update'])->name('update-nomor-surat');
Route::get('/nomor-surat/delete/{id}', [NomorSuratController::class, 'destroy'])->name('delete-nomor-surat');

//Prajuru Desa Adat
Route::get('/prajuru/desaadat', [PrajuruDesaController::class, 'index'])->name('prajuru-desa-adat');
Route::get('/prajuru/desaadat/create', [PrajuruDesaController::class, 'create'])->name('create-prajuru-desa-adat');
Route::post('/prajuru/desaadat/create/getpassword', [PendaftaranDesaController::class, 'getpassword'])->name('get-password');
Route::post('/prajuru/desaadat/add', [PrajuruDesaController::class, 'store'])->name('add-prajuru-desa-adat');
Route::get('/prajuru/desaadat/edit/{id}', [PrajuruDesaController::class, 'edit'])->name('edit-prajuru-desa-adat');
Route::post('/prajuru/desaadat/update/{id}', [PrajuruDesaController::class, 'update'])->name('update-prajuru-desa-adat');
Route::get('/prajuru/desaadat/nonaktif/{id}', [PrajuruDesaController::class, 'nonaktif'])->name('nonaktif-prajuru-desa-adat');
Route::get('/prajuru/desaadat/aktif/{id}', [PrajuruDesaController::class, 'aktif'])->name('aktif-prajuru-desa-adat');
Route::get('/prajuru/desaadat/detail/{id}', [PrajuruDesaController::class, 'detail'])->name('detail-prajuru-desa-adat');

//Prajuru Banjar Adat
Route::get('/prajuru/banjaradat', [PrajuruBanjarController::class, 'index'])->name('prajuru-banjar-adat');
Route::get('/prajuru/banjaradat/create', [PrajuruBanjarController::class, 'create'])->name('create-prajuru-banjar-adat');
Route::post('/prajuru/banjaradat/add', [PrajuruBanjarController::class, 'store'])->name('add-prajuru-banjar-adat');
Route::get('/prajuru/banjaradat/edit/{id}', [PrajuruBanjarController::class, 'edit'])->name('edit-prajuru-banjar-adat');
Route::post('/prajuru/banjaradat/update/{id}', [PrajuruBanjarController::class, 'update'])->name('update-prajuru-banjar-adat');
Route::get('/prajuru/banjaradat/nonaktif/{id}', [PrajuruBanjarController::class, 'nonaktif'])->name('nonaktif-prajuru-banjar-adat');
Route::get('/prajuru/banjaradat/aktif/{id}', [PrajuruBanjarController::class, 'aktif'])->name('aktif-prajuru-banjar-adat');
Route::get('/prajuru/banjaradat/detail/{id}', [PrajuruBanjarController::class, 'detail'])->name('detail-prajuru-banjar-adat');

//Panitia Desa Adat
Route::get('/panitia/desaadat', [PanitiaDesaController::class, 'index'])->name('panitia-desa-adat');
Route::get('/panitia/desaadat/create', [PanitiaDesaController::class, 'create'])->name('create-panitia-desa-adat');
Route::post('/panitia/desaadat/add', [PanitiaDesaController::class, 'store'])->name('add-panitia-desa-adat');
Route::post('/panitia/desaadat/getkegiatan', [PanitiaDesaController::class, 'getkegiatan'])->name('get-kegiatan-panitia');

//Profile
Route::get('/profile/show/{id}', [UserController::class, 'show'])->name('show-profile');
Route::get('/profile/edit/{id}', [UserController::class, 'edit'])->name('edit-profile');
Route::post('profile/crop', [UserController::class, 'crop'])->name('crop-picture');
Route::post('/profile/update/{id}', [UserController::class, 'update'])->name('update-profile');

//Surat Keluar
Route::get('/surat/keluar', [DashboardSuratKeluarController::class, 'index'])->name('dashboard-surat-keluar');

//Surat Keluar Panitia
Route::get('/surat/keluar/panitia', [SuratKeluarPanitiaController::class, 'index'])->name('home-surat-keluar-panitia');
Route::get('/surat/keluar/panitia/create', [SuratKeluarPanitiaController::class, 'create'])->name('create-surat-keluar-panitia');
Route::post('/surat/keluar/panitia/add', [SuratKeluarPanitiaController::class, 'store'])->name('add-surat-keluar-panitia');
Route::get('/surat/keluar/panitia/edit/{id}', [SuratKeluarPanitiaController::class, 'edit'])->name('edit-surat-keluar-panitia');
Route::post('/surat/keluar/panitia/update/{id}', [SuratKeluarPanitiaController::class, 'update'])->name('update-surat-keluar-panitia');
Route::get('/surat/keluar/panitia/detail/waiting/{id}', [SuratKeluarPanitiaController::class, 'show'])->name('detail-surat-keluar-panitia');
Route::get('/surat/keluar/panitia/detail/inprogress/{id}', [SuratKeluarPanitiaController::class, 'showinprogress'])->name('detail-surat-keluar-panitia-inprogress');
Route::get('/surat/keluar/panitia/lepihan/{id}', [SuratKeluarPanitiaController::class, 'showlepihan'])->name('lampiran-surat-keluar-panitia');
Route::get('/surat/keluar/panitia/cetak/{id}', [SuratKeluarPanitiaController::class, 'cetak'])->name('cetak-surat-keluar-panitia');
Route::get('/surat/keluar/panitia/daftar/cetak', [SuratKeluarPanitiaController::class, 'list'])->name('cetak-daftar-surat-keluar-panitia');
Route::get('/surat/keluar/panitia/response/inprogress/{id}', [SuratKeluarPanitiaController::class, 'inprogress'])->name('inprogress-surat-keluar-panitia');

//Surat Keluar Non-Panitia
Route::get('/surat/keluar/non-panitia', [SuratKeluarController::class, 'index'])->name('home-surat-keluar-non-panitia');
Route::get('/surat/keluar/non-panitia/create', [SuratKeluarController::class, 'create'])->name('create-surat-keluar-non-panitia');
Route::post('/surat/keluar/non-panitia/add', [SuratKeluarController::class, 'store'])->name('add-surat-keluar-non-panitia');
Route::get('/surat/keluar/non-panitia/edit/{id}', [SuratKeluarController::class, 'edit'])->name('edit-surat-keluar-non-panitia');
Route::post('/surat/keluar/non-panitia/update/{id}', [SuratKeluarController::class, 'update'])->name('update-surat-keluar-non-panitia');
Route::get('/surat/keluar/non-panitia/detail/waiting/{id}', [SuratKeluarController::class, 'show'])->name('detail-surat-keluar-non-panitia');
Route::get('/surat/keluar/non-panitia/detail/inprogress/{id}', [SuratKeluarController::class, 'showinprogress'])->name('detail-surat-keluar-non-panitia-inprogress');
Route::get('/surat/keluar/non-panitia/lepihan/{id}', [SuratKeluarController::class, 'showlepihan'])->name('lampiran-surat-keluar-non-panitia');
Route::get('/surat/keluar/non-panitia/cetak/{id}', [SuratKeluarController::class, 'cetak'])->name('cetak-surat-keluar-non-panitia');
Route::get('/surat/keluar/non-panitia/daftar/cetak', [SuratKeluarController::class, 'list'])->name('cetak-daftar-surat-keluar-non-panitia');
Route::get('/surat/keluar/non-panitia/response/inprogress/{id}', [SuratKeluarController::class, 'inprogress'])->name('inprogress-surat-keluar-panitia');

//Surat Masuk
Route::get('/surat/masuk', [SuratMasukController::class, 'index'])->name('dashboard-surat-masuk');
Route::get('/surat/masuk/create', [SuratMasukController::class, 'create'])->name('create-surat-masuk');
Route::post('/surat/masuk/add', [SuratMasukController::class, 'store'])->name('add-surat-masuk');
Route::get('/surat/masuk/edit/{id}', [SuratMasukController::class, 'edit'])->name('edit-surat-masuk');
Route::get('/surat/masuk/detail/{id}', [SuratMasukController::class, 'show'])->name('detail-surat-masuk');
Route::post('/surat/masuk/update/{id}', [SuratMasukController::class, 'update'])->name('update-surat-masuk');
Route::get('/surat/masuk/file/{id}', [SuratMasukController::class, 'showfile'])->name('file-surat-masuk');
Route::get('/surat/masuk/delete/{id}', [SuratMasukController::class, 'destroy'])->name('delete-surat-masuk');
Route::get('/surat/masuk/daftar/cetak', [SuratMasukController::class, 'list'])->name('cetak-daftar-surat-masuk');
