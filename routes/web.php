<?php

use App\Http\Controllers\Web\OfficeController;
use App\Http\Controllers\Web\AreaController;
use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\PackagesController;
use App\Http\Controllers\Web\TransactionController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\VillageController;
use App\Models\Transaction;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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





// Api To Terms
Route::get('/terms', function () {
    return view('terms.terms');
});


Route::get('/', function () {
    return view('home');
});



// Ajax Route
Route::get('/findareavillages', function (Request $request) {
    $vilages = Village::where('area_id', $request->area_id)->get();
    return response()->json($vilages);
})->name('findareavillages');



Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/dologin', [AuthController::class, 'dologin'])->name('dologin')->middleware('guest');


Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/doregister', [AuthController::class, 'doregister'])->name('doregister');
Route::get('/clear',function(){
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return 'Application cleared';
});

Route::get('/migrate',function(){
    Artisan::call('migrate:fresh --seed');
    return 'Application cleared';
});


Route::group(['middleware'=>'auth'],function(){
    Route::get('/logout', function () {
        auth()->logout();
        return redirect(route('login'));
    })->name('logout');
    Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
    Route::prefix('users')->group(function () {
        Route::get('/index',[UserController::class,'index'])->name('users.index');
        Route::get('/create',[UserController::class,'create'])->name('users.create');
        Route::post('/store',[UserController::class,'store'])->name('users.store');
        Route::get('/show/{id}',[UserController::class, 'show'])->name('users.show');
        Route::get('/edit/{id}',[UserController::class,'edit'])->name('users.edit');
        Route::post('/update/{id}',[UserController::class,'update'])->name('users.update');
        Route::get('/freeze/{id}',[UserController::class, 'freeze'])->name('users.freeze');
        Route::get('/unfreeze/{id}',[UserController::class, 'unfreeze'])->name('users.unfreeze');
    });
    Route::prefix('areas')->group(function () {
        Route::get('/index', [AreaController::class, 'index'])->name('areas.index');
        Route::get('/create', [AreaController::class, 'create'])->name('areas.create');
        Route::post('/store', [AreaController::class, 'store'])->name('areas.store');
        Route::get('/show/{id}', [AreaController::class, 'show'])->name('areas.show');
        Route::get('/edit/{id}', [AreaController::class, 'edit'])->name('areas.edit');
        Route::post('/update/{id}', [AreaController::class, 'update'])->name('areas.update');
    });
    Route::prefix('villages')->group(function () {
        Route::get('/index', [VillageController::class, 'index'])->name('villages.index');
        Route::get('/create', [VillageController::class, 'create'])->name('villages.create');
        Route::post('/store', [VillageController::class, 'store'])->name('villages.store');
        Route::get('/show/{id}', [VillageController::class, 'show'])->name('villages.show');
        Route::get('/edit/{id}', [VillageController::class, 'edit'])->name('villages.edit');
        Route::post('/update/{id}', [VillageController::class, 'update'])->name('villages.update');
        Route::post('/destroy/{id}', [VillageController::class, 'destroy'])->name('villages.destroy');
    });
    Route::prefix('offices')->group(function () {
        Route::get('/index', [OfficeController::class, 'index'])->name('offices.index');
        Route::get('/create', [OfficeController::class, 'create'])->name('offices.create');
        Route::post('/store', [OfficeController::class, 'store'])->name('offices.store');
        Route::get('/show/{id}', [OfficeController::class, 'show'])->name('offices.show');
        Route::get('/edit/{id}', [OfficeController::class, 'edit'])->name('offices.edit');
        Route::post('/update/{id}', [OfficeController::class, 'update'])->name('offices.update');
        Route::post('/destroy/{id}', [OfficeController::class, 'destroy'])->name('offices.destroy');
    });
    Route::prefix('transactions')->group(function () {
        Route::get('/index', [TransactionController::class, 'index'])->name('transactions.index');
    });
    Route::prefix('packages')->group(function () {
        Route::get('/index', [PackagesController::class, 'index'])->name('packages.index');
    });
    Route::prefix('drivers')->group(function () {
        Route::get('/index',function(){
            return view('drivers.index');
        })->name('drivers.index');
    });
});

