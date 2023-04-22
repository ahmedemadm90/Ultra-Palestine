<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Village;
use App\Models\User;
use App\Models\Area;
use App\Models\PackageLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    // Packages Route
    public function index(Request $request)
    {
        $packages = Package::orderBy('updated_at', 'desc')->get();
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
    }
    public function create(Request $request)
    {
        $input = $request->all();
        $user = $request->user();
        $roles = [
            'to_name' => 'required|string|max:50',
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
            $input['user_id'] = $user->id;
            $village = Village::find($request->village_id);
            $input['area_id'] = $village->area->id;
            if ($user->delivery_cost_discount != 0) {
                $discount = $village->delivery_cost * ($user->delivery_cost_discount / 100);
                $input['delivery_cost'] = ceil($village->delivery_cost - $discount);
            } else {
                $input['delivery_cost'] = $village->delivery_cost;
            }

            $input['package_location'] = 'user-custody';
            if ($request->qr_code) {
                $input['shipping_state'] = 'ready';
            } else {
                $input['shipping_state'] = 'processing';
            }
            $package = Package::create($input);
            PackageLog::create([
                'user' => $package->user->fname . ' ' . $package->user->lname,
                'package_id' => $package->id,
                'package_location' => $input['package_location'],
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
    public function show(Request $request)
    {
        $package = Package::find($request->package_id);
        if ($package) {
            if ($request->user()->role == 'admin' || $request->user()->role == 'employee') {
                $arr = [
                    'code' => 200,
                    'state' => 'success',
                    'data' => $package,
                ];
                return response()->json($arr);
            } elseif ($request->user()->id == $package->user_id) {
                $arr = [
                    'code' => 200,
                    'state' => 'success',
                    'data' => $package,
                ];
                return response()->json($arr);
            } else {
                $arr = [
                    'code' => '302',
                    'state' => 'false',
                    'data' => null,
                ];
                return response()->json($arr);
            }
        } else {
            $arr = [
                'code' => '302',
                'state' => 'false',
                'data' => null,
            ];
            return response()->json($arr);
        }
    }
    public function userUpdate(Request $request)
    {
        $input = $request->all();
        $user = $request->user();
        if ($user) {
            $package = Package::find($request->package_id);
            if ($package && $user->id == $package->user_id && $package->package_location == 'user-custody') {
                $roles = [
                    'to_name' => 'required|string|max:50',
                    'to_phone' => 'required|string',
                    'alter_phone' => 'nullable|string',
                    'package_type' => 'required|string|max:8',
                    'village_id' => 'required|string',
                    'street' => 'required|string',
                    'total_cost' => 'required|numeric',
                    'description' => 'required|string',
                    'note' => 'nullable|string',
                    'state' => 'nullable|string',
                ];
                $validator = Validator::make($input, $roles);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()]);
                } else {
                    $input['delivery_cost'] = $package->village->delivery_cost;
                    $input['state'] = 'processing';
                    $package->update($input);
                    PackageLog::create([
                        'user' => $package->user->fname . ' ' . $package->user->lname,
                        'package_id' => $package->id,
                        'package_location' => $input['package_location'],
                        'shipping_state' => $package->shipping_state,
                        'notes' => null,
                        'details' => 'تعديل بيانات الطرد',
                    ]);
                    $arr = [
                        'code' => 200,
                        'state' => 'success',
                        'data' => $package,
                    ];
                    return response()->json($arr);
                }
            } else {
                $arr = [
                    'code' => '302',
                    'state' => 'false',
                    'data' => null,
                ];
                return response()->json($arr);
            }
        } else {
            $arr = [
                'code' => '302',
                'state' => 'false',
                'data' => null,
            ];
            return response()->json($arr);
        }
    }
    public function adminUpdate(Request $request)
    {
        $input = $request->all();
        $user = $request->user();
        if ($user->role != 'client') {
            $package = Package::find($request->package_id);
            if ($package) {
                $roles = [
                    'to_name' => 'required|string|max:50',
                    'to_phone' => 'required|string',
                    'alter_phone' => 'nullable|string',
                    'package_type' => 'required|string|max:8',
                    'city_id' => 'required|string',
                    'street' => 'required|string',
                    'total_cost' => 'required|numeric',
                    'plus_cost' => 'nullable|numeric',
                    'delivery_cost' => 'required|numeric',
                    'description' => 'required|string',
                    'note' => 'nullable|string',
                    'state' => 'nullable|string',
                    'qr_code' => 'nullable|string',
                ];
                $validator = Validator::make($input, $roles);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()]);
                } else {
                    $package->update($input);
                    $arr = [
                        'code' => 200,
                        'state' => 'success',
                        'data' => $package,
                    ];
                    return response()->json($arr);
                }
            } else {
                $arr = [
                    'code' => '302',
                    'state' => 'false',
                    'data' => null,
                ];
                return response()->json($arr);
            }
        } else {
            $arr = [
                'code' => '302',
                'state' => 'false',
                'data' => null,
            ];
            return response()->json($arr);
        }
    }
    public function packagebyqrcode(Request $request)
    {
        $package = Package::where('qr_code', $request->qr_code)->first();
        if ($package) {
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $package
            ];
            return response()->json($arr);
        } else {
            $arr = [
                'code' => 302,
                'state' => 'false',
                'data' => null
            ];
            return response()->json($arr);
        }
    }
    // End Packages Routes

    // Start Admin Packages Routes
    public function setqrcode(Request $request)
    {
        if ($request->user()->role->role_name == 'admin' || $request->user()->role->role_name == 'employee' || $request->user()->role->role_name == 'client') {
            $roles = [
                'package_id' => 'required|exists:packages,id',
                'qr_code' => 'required|unique:packages,qr_code',
            ];
            $input = $request->all();
            $validator = Validator::make($input, $roles);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            } else {
                $package = Package::find($request->package_id);
                $package->update([
                    'state' => 'ready',
                    'qr_code' => $request->qr_code
                ]);
                PackageLog::create([
                    'user' => $request->user()->fname . ' ' . $request->user()->lname,
                    'package_id' => $package->id,
                    'package_location' => $package->package_location,
                    'shipping_state' => $package->shipping_state,
                    'notes' => null,
                    'details' => 'عملية وضع كيو أر كود على الطرد',
                ]);
                $arr = [
                    'code' => 200,
                    'state' => 'success',
                    'data' => $package
                ];
                return response()->json($arr);
            }
        } else {
            $arr = [
                'code' => 302,
                'state' => 'false',
                'data' => null
            ];
            return response()->json($arr);
        }
    }

    public function cancel(Request $request)
    {
        $package = Package::find($request->package_id);
        if ($package->package_location == 'user-custody') {
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




    // Driver Package Functions
    public function deliverd(Request $request)
    {
        $package = Package::find($request->package_id);
        $package_user = User::find($package->user_id);
        $package->update([
            'shipping_state' => $request->state,
        ]);
        $package_user->update([
            'budget' => $package_user->budget + ($package->total_cost - $package->delivery_cost)
        ]);
    }


    public function stateToDriver($driver, $package)
    {
        $package->update([
            'driver_id' => $driver->id,
            'package_location' => 'driver-custody'
        ]);
    }

    public function stateToffice($package)
    {
        $package->update([
            'driver_id' => null,
            'package_location' => 'office-custody'
        ]);
    }
    public function driverToClient($driver, $package)
    {
        $driver->update([
            'budget' => $driver->budget + $package->total_cost
        ]);
        $package->update([
            'package_location' => 'delivered'
        ]);
    }
    public function getmypackages(Request $request)
    {
        $packagesAll = $request->user()->packages;
        $packages = [];
        foreach ($packagesAll as $p) {
            $p['log'] = $p->log;
            $area = Area::find($p->area_id);
            $package['area'] = $area->area_name;
            $village = Village::find($p->village_id);
            $p['village'] = $village->village_name;
            array_push($packages, $p);
        }
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $packages,
        ];
        return response()->json($arr);
    }
    public function packages(Request $request)
    {
        $user = $request->user();
        if ($user->role->role_name == 'driver') {
            $packages = Package::orderBy('updated_at', 'desc')->where('driver_id', $user->id)->where('invoice_id', null)->get();

            foreach ($packages as $package) {
                $sender = User::find($user->id);
                $package['tm_name'] = $user->tm_name;
                $area = Area::find($package->area_id);
                $package['area'] = $area->area_name;
                $village = Village::find($package->village_id);
                $package['village'] = $village->village_name;
            }
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $packages,
            ];
            return response()->json($arr);
        }
    }
    public function changeState(Request $request)
    {
        $user = $request->user();
        if ($user->role->role_name == 'driver' || $user->role->role_name == 'admin' || $user->role->role_name == 'employee') {
            $package = Package::find($request->package_id);
            if ($package) {
                $package->update([
                    'shipping_state' => $request->state,
                ]);
                PackageLog::create([
                    'user_id' => $user->id,
                    'package_id' => $package->id,
                    'package_location' => $package->package_location,
                    'details' => 'تغيير حالة الطرد من ' . $package->shipping_state . ' الى الحاله' . $request->state,
                ]);
                if ($package->shipping_state == 'delivered') {
                    $driver = User::find($package->driver_id);
                    $sender = User::find($package->user_id);
                    Transaction::create([
                        'driver_id' => $driver->id,
                        'old_budget' => $driver->budget,
                        'new_budget' => ($driver->budget + $package->total_cost),
                        'details' => 'توصيل طرد بقيمة' . $package->total_cost,
                    ]);
                    $driver->update([
                        'budget' => $driver->budget + $package->total_cost,
                    ]);
                    Transaction::create([
                        'user_id' => $driver->id,
                        'old_budget' => $sender->budget,
                        'new_budget' => ($sender->budget + ($package->total_cost - $package->delivery_cost)),
                        'details' => 'توصيل طرد بقيمة' . ($package->total_cost - $package->delivery_cost),
                    ]);
                    $sender->update([
                        'budget' => $sender->budget + ($package->total_cost - $package->delivery_cost),
                    ]);
                }
                $arr = [
                    'code' => 200,
                    'state' => 'success',
                    'data' => $package,
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
        }
    }
    public function plusCost(Request $request)
    {
        $package = Package::find($request->package_id);
        $package->update([
            'plus_cost' => $request->plus_cost,
        ]);
        PackageLog::create([
            'user' => $request->user()->fname . ' ' . $request->user()->lname,
            'package_id' => $package->id,
            'package_location' => $package->package_location,
            'shipping_state' => $package->shipping_state,
            'notes' => null,
            'details' => 'أضافة تكلفة أضافية بقيمة ' . ' ' . $request->plus_cost . ' ' . $request->user()->fname . ' ' . $request->user()->lname,
        ]);
    }
    public function changepackagelocation(Request $request)
    {
        $user = $request->user();
    }
}
