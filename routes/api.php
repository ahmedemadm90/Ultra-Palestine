<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\OfficeController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\VillageController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Web\TransactionController;
use App\Models\Area;
use App\Models\Package;
use App\Models\PackageLog;
use App\Models\Village;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/




Route::middleware('throttle:1000,1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');
    Route::post('/register', [AuthController::class, 'register'])->name('api.register');
});




Route::get('/areas', function (Request $request) {
    $areas = Area::all();
    $arr = [
        'code' => 200,
        'msg' => 'success',
        'data' => $areas
    ];
    return response($arr);
});
Route::get('/villages', function (Request $request) {
    $villages = Village::all();
    $arr = [
        'code' => 200,
        'msg' => 'success',
        'data' => $villages
    ];
    return response($arr);
});
Route::get('/route-cache', function () {
    Artisan::call('route:cache');
    return 'Routes cache cleared';
});
//Clear config cache
Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache cleared';
});
// Clear application cache
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return 'Application cache cleared';
});

// Clear view cache
Route::get('/view-clear', function () {
    Artisan::call('view:clear');
    return 'View cache cleared';
});

// Clear cache using reoptimized class
Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return 'View cache cleared';
});
Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
        Route::POST('/invoice',function(Request $request){
            $invoice = $request->user()->budget;
            $arr = [
                'code'=>200,
                'state'=>'success',
                'invoice'=>$invoice
            ];
            return response()->json($arr);
        });
        Route::group(['prefix' => 'invoices'], function () {
            Route::post('/user/create', [InvoiceController::class, "create"])->name('user.invoice.create');
            Route::post('/user/allinvoices', [InvoiceController::class, "myinvoices"])->name('user.allinvoice');
            Route::post('/user/paidinvoices', [InvoiceController::class, "mypaidinvoices"])->name('user.paidinvoices');
            Route::post('/admin/allinvoices', [InvoiceController::class, "allInvoices"])->name('admin.allinvoice');
            Route::post('/admin/paidinvoices', [InvoiceController::class, "allpaidInvoices"])->name('admin.paidinvoices');
            Route::post('/admin/unpaidinvoices', [InvoiceController::class, "allunpaidinvoices"])->name('admin.unpaidinvoices');
            Route::post('/admin/pay', [InvoiceController::class, "payInvoices"])->name('admin.payInvoices');
        });
        Route::get('/profile',[ProfileController::class,'profile'])->name('profile');
        Route::post('/profile/update',[ProfileController::class,'update'])->name('profile.update');
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
        Route::post('packages/setqrcode', function (Request $request) {
            $package = Package::find($request->package_id);
            $input = $request->all();
            $roles = [
                'qr_code' => 'required|unique:packages,qr_code',
            ];
            $validator = Validator::make($input, $roles);
            if ($validator->fails()) {
                $arr = [
                    'code' => '302',
                    'state' => 'false',
                    'data' => null,
                    'errors' => $validator->errors(),
                ];
                return response()->json($arr);
            } else {
                if (isset($package->qr_code)) {
                    PackageLog::create([
                        'user' => $request->user()->fname . ' ' . $request->user()->lname,
                        'package_id' => $package->id,
                        'package_location' => $package->package_location,
                        'shipping_state' => $package->shipping_state,
                        'notes' => null,
                        'details' => 'استبدال الملصق رقم ' . $package->qr_code . ' بالملصق رقم ' . $request->qr_code,
                    ]);
                    $package->update([
                        'qr_code' => $request->qr_code
                    ]);
                    $package['log'] = $package->log;
                    $arr = [
                        'code' => 200,
                        'state' => 'success',
                        'data' => $package
                    ];
                    return response()->json($arr);
                } else {
                    $package->update([
                        'qr_code' => $request->qr_code
                    ]);
                    $package['log'] = $package->log;
                    PackageLog::create([
                        'user' => $request->user()->fname . ' ' . $request->user()->lname,
                        'package_id' => $package->id,
                        'package_location' => $package->package_location,
                        'shipping_state' => $package->shipping_state,
                        'notes' => null,
                        'details' => ' عملية وضع كيو أر كود على الطرد ' . $request->qr_code,
                    ]);
                    $arr = [
                        'code' => 200,
                        'state' => 'success',
                        'data' => $package
                    ];
                    return response()->json($arr);
                }
            }
        });
    }
);
