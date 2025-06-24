<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LsuController;
use App\Http\Controllers\BlokController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\JalanController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ArestaController;
use App\Http\Controllers\ChInputController;
use App\Http\Controllers\NurseryController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\AirSungaiController;
use App\Http\Controllers\PerawatanController;
use App\Http\Controllers\ContractpkController;
use App\Http\Controllers\CurahHujanController;
use App\Http\Controllers\PupukRawatController;
use App\Http\Controllers\ArestaInputController;
use App\Http\Controllers\ContractcpoController;
use App\Http\Controllers\FfbInternalController;
use App\Http\Controllers\ProduksicpoController;
use App\Http\Controllers\TbsInternalController;
use App\Http\Controllers\FfbEksternalController;
use App\Http\Controllers\LhoController;
use App\Http\Controllers\PupukrawatinputController;
use App\Http\Controllers\PanenController;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/user', UserController::class);
Route::get('/user/hapus/{id}', [UserController::class, 'destroy']);
Route::post('/user/changePassword/{id}', [UserController::class, 'changePassword'])->name('user.changePassword');
Route::resource('/comp', CompanyController::class);
Route::get('/comp/hapus/{id}', [CompanyController::class, 'destroy']);
Route::resource('/aresta', ArestaController::class);
Route::resource('/airsungai', AirSungaiController::class);
Route::post('/airsungai/store', [AirSungaiController::class, 'store'])->name('airsungai.store');
Route::get('/airsungai/hapus/{id}', [AirSungaiController::class, 'destroy']);
Route::post('/airsungai', [AirSungaiController::class, 'import'])->name('airsungai.import');
Route::resource('/curah', ChInputController::class);
Route::post('/curah/store', [ChInputController::class, 'store'])->name('curah.store');
Route::post('/curah', [ChInputController::class, 'import'])->name('curah.import');
Route::get('/curah/hapus/{id}', [ChInputController::class, 'destroy']);
Route::resource('/areal', ArestaInputController::class);
Route::post('/areal', [ArestaInputController::class, 'import'])->name('areal.import');
Route::post('/areal/store', [ArestaInputController::class, 'store'])->name('areal.store');
Route::get('/areal/hapus/{id}', [ArestaInputController::class, 'destroy']);
Route::resource('/tbsinternal', TbsInternalController::class);
Route::post('/tbsinternal/save', [TbsInternalController::class, 'save'])->name('tbsinternal.save');
Route::get('/tbsinternal/hapus/{id}', [TbsInternalController::class, 'destroy']);
Route::post('/tbsinternal', [TbsInternalController::class, 'import'])->name('tbsinternal.import');
Route::resource('/panen', PanenController::class);
Route::get('/panen/hapus/{id}', [PanenController::class, 'destroy']);
Route::resource('/ffbinternal', FfbInternalController::class);
Route::post('/ffbinternal', [FfbInternalController::class, 'import'])->name('ffbinternal.import');
Route::resource('/ffbeksternal', FfbEksternalController::class);
Route::post('/ffbeksternal', [FfbEksternalController::class, 'import'])->name('ffbeksternal.import');
Route::resource('/produksicpo', ProduksicpoController::class);
Route::post('/produksicpo', [ProduksicpoController::class, 'import'])->name('produksicpo.import');
Route::resource('/contractcpo', ContractcpoController::class);
Route::post('/contractcpo', [ContractcpoController::class, 'import'])->name('contractcpo.import');
Route::resource('/contractpk', ContractpkController::class);
Route::post('/contractpk', [ContractpkController::class, 'import'])->name('contractpk.import');
Route::resource('/pupuk', PupukrawatinputController::class);
Route::post('/pupuk', [PupukrawatinputController::class, 'import'])->name('pupuk.import');
Route::resource('/perawatan', PerawatanController::class);
Route::post('/perawatan', [PerawatanController::class, 'import'])->name('perawatan.import');
Route::resource('/payroll', PayrollController::class);
Route::post('/payroll', [PayrollController::class, 'import'])->name('payroll.import');
Route::resource('/lho', LhoController::class);
Route::post('/lho', [LhoController::class, 'import'])->name('lhobbm.import');
Route::resource('/curahhujan', CurahHujanController::class);
Route::resource('/produksi', ProduksiController::class);
Route::resource('/pr', PupukRawatController::class);
Route::resource('/vra', UnitController::class);
Route::resource('/road', JalanController::class);
Route::resource('/legal', LegalController::class);
Route::resource('/lsu', LsuController::class);
Route::resource('/blok', BlokController::class);
Route::resource('/bibit', NurseryController::class);
