<?php

use App\Models\Area;
use App\Models\Package;
use App\Models\PackageLog;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Village;
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



Route::middleware(['auth:sanctum', 'driver'])->group(function () {
    Route::post('balance', function (Request $request) {
        $budget = $request->user()->budget;
        $arr = [
            'code' => 200,
            'state' => 'success',
            'budget' => $budget
        ];
        return response()->json($arr);
    });
    Route::post('packages', function (Request $request) {
        $packages = Package::where('driver_id', $request->user()->id)
        ->where('package_location','مع السائق')
        ->where('invoice_id', null)
        ->orderBy('updated_at', 'desc')->get();
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
    Route::post('packages/byid', function (Request $request) {
        try {
            $package = Package::find($request->package_id);
            $area = Area::find($package->area_id);
            $package['area'] = $area->area_name;
            $village = Village::find($package->village_id);
            $package['village'] = $village->village_name;
            $package['log'] = $package->log;
            $sender = User::find($package->user_id);
            $package['sender_phone'] = $sender->phone;
            $package['tm_name'] = $sender->tm_name;
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
            $package = Package::where('qr_code', $request->qr_code)->where('driver_id',$request->user()->id)->first();
            $package['log'] = $package->log;
            $sender = User::find($package->user_id);
            $package['sender_phone'] = $sender->phone;
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
    Route::post('packages/returns', function (Request $request) {
        $package = Package::find($request->package_id);
        //$driver = $request->user();
        $sender = User::find($package->user_id);
        $package->update([
            'shipping_state' => 'returns',
        ]);
        if ($sender->returns_cost > 0) {
            $returns_cost = $package->delivery_cost * ($sender->returns_cost / 100);
            $sender->update([
                'budget' => $sender->budget - $returns_cost
            ]);
        }
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $package
        ];
        return response()->json($arr);
    });
    Route::post('packages/stuck', function (Request $request) {
        $package = Package::find($request->package_id);
        $package->update([
            'shipping_state' => 'stuck',
            'driver_note' => $request->driver_note
        ]);
        PackageLog::create([
            'user' => $request->user()->fname . ' ' . $request->user()->lname,
            'package_id' => $package->id,
            'package_location' => $package->package_location,
            'shipping_state' => 'stuck',
            'details' => 'قام السائق  ' . $request->user()->fname . ' ' . $request->user()->lname . ' ' . ' بتعليق الطرد ووضع الملاحظة ' . $request->driver_note,
        ]);
        $area = Area::find($package->area_id);
        $package['area'] = $area->area_name;
        $village = Village::find($package->village_id);
        $package['village'] = $village->village_name;
        $package['log'] = $package->log;
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $package
        ];
        return response()->json($arr);
    });

    Route::post('packages/normal/deliver', function (Request $request) {
        $package = Package::find($request->package_id);
        if($package->shipping_state != 'delivered'){
        $sender = User::find($package->user_id);
        $driver = User::find($package->driver_id);
        if ($package->total_cost == 0) {
            $sender->update([
                'budget' => $sender->budget - $package->delivery_cost
            ]);
            $package->update([
                'shipping_state' => 'delivered',
                'package_location' => 'مع المستلم'
            ]);
            PackageLog::create([
                'user' => $request->user()->fname . ' ' . $request->user()->lname,
                'package_id' => $package->id,
                'package_location' => $package->package_location,
                'shipping_state' => 'delivered',
                'details' => 'توصيل الطرد وخصم قيمة التوصيل من التاجر'
            ]);

            $package['log'] = $package->log;
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $package
            ];
            return response()->json($arr);
        } else if ($package->total_cost > 0 && $package->total_cost < $package->delivery_cost) {
            $package->update([
                'shipping_state' => 'delivered',
                'package_location' => 'مع المستلم'
            ]);
            $sender->update([
                'budget' => $sender->budget - ($package->delivery_cost - $package->total_cost)
            ]);
            $driver->update([
                'budget' => $driver->budget + $package->total_cost
            ]);
            PackageLog::create([
                'user' => $request->user()->fname . ' ' . $request->user()->lname,
                'package_id' => $package->id,
                'package_location' => $package->package_location,
                'shipping_state' => 'delivered',
                'details' => 'توصيل الطرد وخصم فرق قيمة التوصيل من التاجر'
            ]);
            $package['log'] = $package->log;
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $package
            ];
            return response()->json($arr);
        } else {

            $sender->update([
                'budget' => $sender->budget + ($package->total_cost - ($package->delivery_cost + $package->plus_cost))
            ]);
            $driver->update([
                'budget' => $driver->budget + $package->total_cost
            ]);
            $package->update([
                'shipping_state' => 'delivered',
                'package_location' => 'مع المستلم'
            ]);
            PackageLog::create([
                'user' => $request->user()->fname . ' ' . $request->user()->lname,
                'package_id' => $package->id,
                'package_location' => $package->package_location,
                'shipping_state' => 'delivered',
                'details' => 'قام السائق ' . $request->user()->fname . ' ' . $request->user()->lname . ' بتوصيل الطرد'
            ]);
            $package['log'] = $package->log;
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $package
            ];
            return response()->json($arr);
        }    
        }
        
    });



    Route::post('packages/exchange/deliver', function (Request $request) {
        $roles = [
            'package_id' => 'required',
            'qr_code' => 'required|unique:packages,qr_code'
        ];
        $validator = Validator::make($request->all(), $roles);
        if ($validator->fails()) {
            $arr = [
                'code' => 302,
                'state' => 'false',
                'data' => $validator->errors(),
            ];
            return response()->json($arr);
        } else {
            $package = Package::find($request->package_id);
            if($package->shipping_state != 'delivered'){
                $driver = User::find($package->driver_id);
            $sender = User::find($package->user_id);
            $package_cost = $package->total_cost - ($package->plus_cost - $package->delivery_cost);
            if ($package->total_cost == 0) {
                $sender->update([
                    'budget' => $sender->budget - $package->delivery_cost
                ]);
                PackageLog::create([
                    'user' => $request->user()->fname . ' ' . $request->user()->lname,
                    'package_id' => $package->id,
                    'package_location' => $package->package_location,
                    'shipping_state' => 'delivered',
                    'details' => 'أستبدال الطرد وخصم قيمة التوصيل من التاجر'
                ]);
            }
            $driver->update([
                'budget' => $driver->budget + $package->total_cost
            ]);
            $sender->update([
                'budget' => $sender->budget + $package->total_cost - $package->delivery_cost - $package->plus_cost
            ]);
            PackageLog::create([
                'user' => $request->user()->fname . ' ' . $request->user()->lname,
                'package_id' => $package->id,
                'package_location' => $package->package_location,
                'shipping_state' => 'stuck',
                'details' => 'قام السائق  ' . $request->user()->fname . ' ' . $request->user()->lname . ' ' . '  بتبديل الطرد ووضع الملصق الجديد ' . $request->qr_code . ' بدلا من الملصق القديم ' . $package->qr_code,
            ]);
            $package->update([
                'qr_code' => $request->qr_code,
                'shipping_state' => 'delivered',
                'package_location' => 'مع المستلم'
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
    Route::post('packages/pay/deliver', function (Request $request) {
        $roles = [
            'package_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $roles);
        if ($validator->fails()) {
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $validator->errors(),
            ];
            return response()->json($arr);
        } else {
            $package = Package::find($request->package_id);
            if($package->shipping_state != 'delivered'){
                $driver = User::find($package->driver_id);
            $sender = User::find($package->user_id);
            //$package_cost = $package->total_cost - ($package->plus_cost - $package->delivery_cost);
            $driver->update([
                'budget' => $driver->budget + $package->total_cost
            ]);
            $sender->update([
                'budget' => $sender->budget + ($package->total_cost - $package->delivery_cost - $package->plus_cost)
            ]);
            PackageLog::create([
                'user' => $request->user()->fname . ' ' . $request->user()->lname,
                'package_id' => $package->id,
                'package_location' => $package->package_location,
                'shipping_state' => 'stuck',
                'details' => 'قام السائق  ' . $request->user()->fname . ' ' . $request->user()->lname . ' ' . '  بتوصيل الطرد ',
            ]);
            $package->update([
                'shipping_state' => 'delivered',
                'package_location' => 'مع المستلم'
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
    Route::post('packages/return-buy/deliver', function (Request $request) {
        $roles = [
            'package_id' => 'required',
            'qr_code' => 'required|unique:packages,qr_code',
        ];
        $validator = Validator::make($request->all(), $roles);
        if ($validator->fails()) {
            $arr = [
                'code' => 302,
                'state' => 'false',
                'data' => $validator->errors(),
            ];
            return response()->json($arr);
        } else {
            $package = Package::find($request->package_id);
            
             if($package->shipping_state != 'delivered'){
                 $package->update([
                'qr_code' => $request->qr_code,
            ]);
            $driver = User::find($package->driver_id);
            $sender = User::find($package->user_id);
            $driver->update([
                'budget' => $driver->budget + $package->total_cost
            ]);
            $sender->update([
                'budget' => $sender->budget + $package->total_cost - $package->delivery_cost - $package->plus_cost
            ]);
            $package->update([
                'shipping_state' => 'delivered',
                'package_location' => 'مع المستلم'
            ]);
            
            PackageLog::create([
                'user' => $request->user()->fname . ' ' . $request->user()->lname,
                'package_id' => $package->id,
                'package_location' => $package->package_location,
                'shipping_state' => 'delivered',
                'details' => 'قام السائق  ' . $request->user()->fname . ' ' . $request->user()->lname . ' ' . '  بدفع قيمة الطرد ',
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
});
