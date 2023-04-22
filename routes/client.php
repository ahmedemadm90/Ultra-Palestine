<?php

use App\Models\Area;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\PackageLog;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Village;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
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
Route::middleware(['auth:sanctum', 'client'])->group(function () {
    Route::post('packages', function (Request $request) {
        $packages = Package::where('user_id', $request->user()->id)->where('invoice_id', null)->orderBy('updated_at', 'desc')->get();
        foreach ($packages as $package) {
            $area = Area::find($package->area_id);
            $package['area'] = $area->area_name;
            $village = Village::find($package->village_id);
            $package['village'] = $village->village_name;
            $package['log'] = $package->log;
        }
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $packages,
        ];
        return response()->json($arr);
    });
    Route::post('packages/create', function (Request $request) {
        $input = $request->all();
        $user = $request->user();
        $roles = [
            'to_name' => 'required|string',
            'to_phone' => 'required|string',
            'alter_phone' => 'nullable|string',
            'package_type' => 'required|string',
            'village_id' => 'required|exists:villages,id',
            'street' => 'nullable|string',
            'total_cost' => 'required|numeric',
            'description' => 'nullable|string',
            'note' => 'nullable|string',
            'deliver_date' => 'nullable|string',
            'description' => 'required|string',
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
            $village = Village::find($request->village_id);
            $input['area_id'] = $village->area->id;
            if ($user->delivery_cost_discount != 0) {
                $discount = $village->delivery_cost * ($user->delivery_cost_discount / 100);
                $input['delivery_cost'] = ceil($village->delivery_cost - $discount);
            } else {
                $input['delivery_cost'] = $village->delivery_cost;
            }
            $input['user_id'] = $request->user()->id;
            $input['package_location'] = 's-csd';
            if ($request->qr_code) {
                $input['shipping_state'] = 'ready';
            } else {
                $input['shipping_state'] = 'processing';
            }
            if ($request->package_type == 'normal') {
                $package = Package::create($input);
                PackageLog::create([
                    'user' => $request->user()->fname . ' ' . $request->user()->lname,
                    'package_id' => $package->id,
                    'package_location' => 's-csd',
                    'shipping_state' => $package->shipping_state,
                    'notes' => null,
                    'details' => 'عملية أنشاء طرد',
                ]);
                $arr = [
                    'code' => 200,
                    'state' => 'success',
                    'data' => $package,
                ];
                return response()->json($arr);
            }
            if ($request->package_type == 'exchange') {
                $package = Package::create($input);
                PackageLog::create([
                    'user' => $request->user()->fname . ' ' . $request->user()->lname,
                    'package_id' => $package->id,
                    'package_location' => 's-csd',
                    'shipping_state' => $package->shipping_state,
                    'notes' => null,
                    'details' => 'عملية أنشاء طرد',
                ]);
                $arr = [
                    'code' => 200,
                    'state' => 'success',
                    'data' => $package,
                ];
                return response()->json($arr);
            }
            if ($request->package_type == 'returns/buy') {
                $package = Package::create($input);
                PackageLog::create([
                    'user' => $request->user()->fname . ' ' . $request->user()->lname,
                    'package_id' => $package->id,
                    'package_location' => 'o-csd',
                    'shipping_state' => $package->shipping_state,
                    'notes' => null,
                    'details' => 'عملية أنشاء طرد',
                ]);
                $arr = [
                    'code' => 200,
                    'state' => 'success',
                    'data' => $package,
                ];
                return response()->json($arr);
            }
            if ($request->package_type == 'pay') {
                $package = Package::create($input);
                PackageLog::create([
                    'user' => $request->user()->fname . ' ' . $request->user()->lname,
                    'package_id' => $package->id,
                    'package_location' => 'o-csd',
                    'shipping_state' => $package->shipping_state,
                    'notes' => null,
                    'details' => 'عملية أنشاء طرد',
                ]);
                $arr = [
                    'code' => 200,
                    'state' => 'success',
                    'data' => $package,
                ];
                return response()->json($arr);
            }
        }
    });
    Route::post('packages/update', function (Request $request) {
        $input = $request->all();
        $package = Package::find($request->package_id);
        $village = Village::find($package->village_id);
        $input['area_id'] = $village->area->id;
        $package->update($input);
        PackageLog::create([
            'user' => $request->user()->fname . ' ' . $request->user()->lname,
            'package_id' => $package->id,
            'package_location' => $package->package_location,
            'shipping_state' => $package->shipping_state,
            'notes' => null,
            'details' => 'تعديل بيانات الطرد',
        ]);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $package
        ];
        return response()->json($arr);
    });
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
                $package = Package::find($request->package_id);
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
    Route::post('packages/byid', function (Request $request) {
        try {
            $package = Package::find($request->package_id);
            $area = Area::find($package->area_id);
            $package['area'] = $area->area_name;
            $village = Village::find($package->village_id);
            $package['village'] = $village->village_name;
            $package['log'] = $package->log;
            if (isset($package->driver_id)) {
                $driver = User::find($package->driver_id);
                $package['driver_phone'] = $driver->phone;
            } else {
                $package['driver_phone'] = 'لم يتم تعيين الطرد لسائق';
            }


            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $package,
            ];
            return response()->json($arr);
        } catch (\Throwable $th) {
            $arr = [
                'code' => 302,
                'state' => 'false',
                'data' => null,
            ];
            return response()->json($arr);
        }
    });
    Route::post('packages/byqrcode', function (Request $request) {
        try {
            $package = Package::where('qr_code', $request->qr_code)->first();
            $package['log'] = $package->log;
            if (isset($package->driver_id)) {
                $driver = User::find($package->driver_id);
                $package['driver_phone'] = $driver->phone;
            } else {
                $package['driver_phone'] = 'لم يتم تعيين الطرد لسائق';
            }

            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $package,
            ];
            return response()->json($arr);
        } catch (\Throwable $th) {
            $arr = [
                'code' => 302,
                'state' => 'false',
                'data' => null,
            ];
            return response()->json($arr);
        }
    });
    Route::post('packages/cancel', function (Request $request) {
        $package = Package::find($request->package_id);
        if ($package->user_id == $request->user()->id) {
            if ($package->package_location == 's-csd') {
                foreach ($package->log as $log) {
                    $log->delete();
                }
                $package->delete();
                $arr = [
                    'code' => 200,
                    'state' => 'success',
                ];
                return response()->json($arr);
            } else {
                $arr = [
                    'code' => 302,
                    'state' => 'false',
                ];
                return response()->json($arr);
            }
        }
    });
    Route::post('balance', function (Request $request) {
        $budget = $request->user()->budget;
        $arr = [
            'code' => 200,
            'state' => 'success',
            'budget' => $budget
        ];
        return response()->json($arr);
    });
    Route::post('invoices', function (Request $request) {
        $invoices = Invoice::where('user_id', $request->user()->id)->get();
        $packages = [];
        foreach ($invoices as $invoice) {
            $packages = [];
            foreach ($invoice['packages_ids'] as $id) {
                $package = Package::find($id);
                $package['user_name'] = $request->user()->fname . ' ' . $request->user()->lname;
                $package['village'] = Village::find($package->village_id)->village_name;
                array_push($packages, $package);
            }
            $invoice['packages'] = $packages;
        }
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $invoices
        ];
        return response()->json($arr);
    });
    Route::post('invoices/create', function (Request $request) {
        $invoice_packages = [];
        $invoice_packages_ids = [];
        $user = $request->user();
        $packages = $user->packages;
        foreach ($packages as $package) {
            if ($package->shipping_state == 'delivered' && $package->invoice_state == null || $package->shipping_state == 'returns' && $package->invoice_state == null) {
                array_push($invoice_packages, $package);
                array_push($invoice_packages_ids, $package->id);
            }
        }
        if (count($invoice_packages) > 0) {
            $invoice = Invoice::create([
                'user_id' => $user->id,
                'packages_ids' => $invoice_packages_ids,
                'invoice_cost' => $user->budget,
                'invoice_state' => 'unpaid',
            ]);
            foreach ($invoice_packages as $package) {
                $package->update([
                    'invoice_state' => 'closed',
                    'invoice_id' => $invoice->id,
                ]);
                PackageLog::create([
                    'user' => $request->user()->fname . ' ' . $request->user()->lname,
                    'package_location' => $package->package_location,
                    'package_id' => $package->id,
                    'shipping_state' => $package->shipping_state,
                    'details' => 'تم اضافة الطرد رقم ' . $package->id . ' الى فاتورة',
                ]);
            }
            $invoice['packages'] = $invoice_packages;
            $user->update([
                'budget' => 0
            ]);
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $invoice,
            ];
            return response()->json($arr);
        } else {
            $arr = [
                'code' => 302,
                'state' => 'false',
                'data' => null,
            ];
            return response()->json($arr);
        }
    });
    Route::post('packages/delivered', function (Request $request) {
        $package = Package::find($request->package_id);
        if ($package->package_type == 'normal') {
            $package_cost = $package->total_cost - ($package->delivery_cost + $package->plus_cost);
            $sender = User::find($package->user_id);
            $sender->update([
                'budget' => $sender->budget + $package_cost,
            ]);
            $package->update([
                'shipping_state' => 'delivered'
            ]);
            PackageLog::create([
                'user' => $request->user()->fname . ' ' . $request->user()->lname,
                'package_location' => $package->package_location,
                'package_id' => $package->id,
                'shipping_state' => 'delivered',
                'details' => 'قام السائق ' . $request->user()->fname . ' ' . $request->user()->lname . ' بتحصيل قيمة الطرد من المستلم',
            ]);
            $package['log'] = $package->log;
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $package,
            ];
            return response()->json($arr);
        } else if ($package->package_type == 'pay') {
            $package_cost = -$package->total_cost - ($package->delivery_cost + $package->plus_cost);
            $sender = User::find($package->user_id);
            $sender->update([
                'budget' => $sender->budget + $package_cost,
            ]);
            $package->update([
                'shipping_state' => 'delivered'
            ]);
            PackageLog::create([
                'user' => $request->user()->fname . ' ' . $request->user()->lname,
                'package_location' => $package->package_location,
                'package_id' => $package->id,
                'shipping_state' => 'delivered',
                'details' => 'قام السائق ' . $request->user()->fname . ' ' . $request->user()->lname . ' بدفع قيمة الطرد الى المستلم',
            ]);
            $package['log'] = $package->log;
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $package,
            ];
            return response()->json($arr);
        } else if ($package->package_type == 'exchange') {
            $package_cost = $package->total_cost - ($package->delivery_cost + $package->plus_cost);
            $sender = User::find($package->user_id);
            $sender->update([
                'budget' => $sender->budget + $package_cost,
            ]);
            PackageLog::create([
                'user' => $request->user()->fname . ' ' . $request->user()->lname,
                'package_location' => $package->package_location,
                'package_id' => $package->id,
                'shipping_state' => 'delivered',
                'details' => 'قام السائق ' . $request->user()->fname . ' ' . $request->user()->lname . ' بتبديل الطرد من المستلم',
            ]);
            $package['log'] = $package->log;
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $package,
            ];
            return response()->json($arr);
        } else if ($package->package_type == 'returns/buy') {
            $package_cost = -$package->total_cost - ($package->delivery_cost + $package->plus_cost);
            $sender = User::find($package->user_id);
            $sender->update([
                'budget' => $sender->budget + $package_cost,
            ]);
            PackageLog::create([
                'user' => $request->user()->fname . ' ' . $request->user()->lname,
                'package_location' => $package->package_location,
                'package_id' => $package->id,
                'shipping_state' => 'delivered',
                'details' => 'قام السائق ' . $request->user()->fname . ' ' . $request->user()->lname . ' بدفع قيمة الطرد الى المستلم',
            ]);
            $package['log'] = $package->log;
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $package,
            ];
            return response()->json($arr);
        }
    });
    Route::post('invoices/returns', function (Request $request) {
        $packages = [];
        $all = $request->user()->packages;
        foreach ($all as $package) {
            if ($package['invoice_id'] != null && $package['shipping_state'] == 'returns') {
                array_push($packages, $package);
            }
            $area = Area::find($package->area_id);
            $package['area'] = $area->area_name;
            $village = Village::find($package->village_id);
            $package['village'] = $village->village_name;
            $package['log'] = $package->log;
        }
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $packages,
        ];
        return response()->json($arr);
    });
    Route::post('invoices/closed', function (Request $request) {
        $packages = [];
        $all = $request->user()->packages;
        foreach ($all as $package) {
            if ($package['shipping_state'] == 'closed') {
                array_push($packages, $package);
            }
            $area = Area::find($package->area_id);
            $package['area'] = $area->area_name;
            $village = Village::find($package->village_id);
            $package['village'] = $village->village_name;
            $package['log'] = $package->log;
        }
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $packages,
        ];
        return response()->json($arr);
    });
    Route::post('packages/changestate', function (Request $request) {
        $package = Package::find($request->package_id);
        if ($request->state == 'returns') {
            $sender = User::find($package->user_id);
            $deduct = $package->delivery_cost * ($sender->returns_cost / 100);
            $sender->update([
                'budget' => $sender->budget - $deduct,
            ]);
            $package->update([
                'shipping_state' => $request->state,
                'delivery_cost' => $deduct,
            ]);
        } else if ($request->state != 'delivered') {
            $package->update([
                'shipping_state' => $request->state,
            ]);
            $package['log'] = $package->log;
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $package,
            ];
            return response()->json($arr);
        }
    });
    Route::post('packages/returns', function (Request $request) {
        $package = Package::find($request->package_id);
        $sender = User::find($package->user_id);
        if ($sender->returns_cost > 0) {
            $returns_cost = $package->delivery_cost * ($sender->returns_cost / 100);
            $sender->update([
                'budget' => $sender->budget - $returns_cost
            ]);
            $package->update([
                'shipping_state' => 'returns',
                'delivery_cost' => $returns_cost,
            ]);
        } else {
            $package->update([
                'shipping_state' => 'returns',
            ]);
        }

        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $package
        ];
        return response()->json($arr);
    });
});
