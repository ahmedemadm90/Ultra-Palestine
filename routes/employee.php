<?php

use App\Models\Area;
use App\Models\Invoice;
use App\Models\Office;
use App\Models\Package;
use App\Models\PackageLog;
use App\Models\Transaction;
use App\Models\Village;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
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

Route::get('/offices', function (Request $request) {
    $offices = Office::all();
    $arr = [
        'code' => 200,
        'msg' => 'success',
        'data' => $offices
    ];
    return response($arr);
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
Route::get('/drivers/list', function () {
    $drivers = User::select('id', 'fname', 'lname')->where('role_id', 3)->get();
    foreach ($drivers as $driver) {
        $driver['fname'] = $driver->fname . ' ' . $driver->lname;
    }
    $arr = [
        'code' => 200,
        'state' => 'success',
        'data' => $drivers
    ];
    return response()->json($arr);
});


Route::middleware(['auth:sanctum', 'employee'])->group(function () {
    Route::get('/offices', function (Request $request) {

        $offices = Office::all();

        $arr = [
            'code' => 200,
            'msg' => 'success',
            'data' => $offices
        ];
        return response($arr);
    });
    Route::get('/packages/changelocation', function (Request $request) {
        $package = Package::find($request->package_id);
        $package->update([
            'package_location' => $request->location,
        ]);
        $arr = [
            'code' => 200,
            'msg' => 'success',
            'data' => $package
        ];
        return response($arr);
    });
    Route::POST('/invoices', function (Request $request) {
        $invoices = Invoice::all();
        $packages = [];
        foreach ($invoices as $invoice) {
            // foreach ($invoice->packages_ids as $id) {
            //     $package = Package::find($id);
            //     array_push($packages, $package);
            // }
            // $invoice['packages'] = $packages;
            $invoice['packages'] = $invoice->packages;
        }

        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $invoices
        ];
        return response()->json($arr);
    });
    Route::POST('/invoicebyid', function (Request $request) {
        $invoice = Invoice::find($request->invoice_id);
        $invoice['packages'] = $invoice->packages;
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $invoice
        ];
        return response()->json($arr);
    });
    Route::POST('/packages', function (Request $request) {
        $packages = Package::where('invoice_id', null)->get();
        foreach ($packages as $package) {
            $user = User::find($package->user_id);
            $package['user_name'] = $user->fname . " " . $user->lname;
            $village = Village::find($package->village_id);
            $package['village'] = $village->village_name;
        }
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $packages
        ];
        return response()->json($arr);
    });
        Route::POST('/packages/scan', function (Request $request) {
        $packages = Package::all();
        foreach ($packages as $package) {
            $user = User::find($package->user_id);
            $package['user_name'] = $user->fname . " " . $user->lname;
            $village = Village::find($package->village_id);
            $package['village'] = $village->village_name;
        }
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $packages
        ];
        return response()->json($arr);
    });
    
    
    
    
    
    
    Route::POST('/packages/byid', function (Request $request) {
        $package = Package::find($request->package_id);
        $user = User::find($request->user()->id);
        $package['user'] = $user->fname . " " . $user->lname;
        $village = Village::find($package->village_id);
        $package['village'] = $village->village_name;
        $package['log'] = $package->log;
        if (isset($package->driver_id)) {
            $driver = User::find($package->driver_id);
            $package['driver_phone'] = $driver->phone;
        }
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $package
        ];
        return response()->json($arr);
    });
    Route::POST('/drivers', function (Request $request) {
        $drivers = User::where('role_id', 3)->get();
        foreach ($drivers as $driver) {
            $packages = Package::where('driver_id', $driver->id)->get();
            foreach ($packages as $package) {
                $user = User::find($package->user_id);
                $package['user'] = $user->fname . " " . $user->lname;
                $village = Village::find($package->village_id);
                $package['village'] = $village->village_name;
            }
            $driver['packages'] = $packages;
        }
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $drivers
        ];
        return response()->json($arr);
    });
    Route::POST('/clients', function (Request $request) {
        $clients = User::where('role_id', 2)->get();
        foreach ($clients as $client) {
            $packages = Package::where('user_id', $client->id)->where('invoice_id', null)->get();
            foreach ($packages as $package) {
                $village = Village::find($package->village_id);
                $package['village'] = $village->village_name;
                if (isset($package->driver_id)) {
                    $driver = User::find($package->driver_id);
                    $package['driver'] = $driver->fname . " " . $driver->lname;
                }
            }
            $invoices = $client->invoices;
            foreach ($invoices as $invoice) {
                $invoice_packages = [];
                foreach ($invoice->packages_ids as $id) {
                    $package = Package::find($id);
                    array_push($invoice_packages, $package);
                }
                $invoice['packages'] = $invoice_packages;
            }
            $client['packages'] = $packages;
            $client['invoices'] = $invoices;
            if (!isset($client->tm_name)) {
                $client['tm_name'] = 'Temp Tm Name';
            } else {
                $client['tm_name'] = $client->tm_name;
            }
        }
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $clients
        ];

        return response()->json($arr);
    });
    Route::POST('/workers', function (Request $request) {
        $workers = User::where('role_id', '!=', 2)
            ->where('role_id', '!=', 1)
            ->where('id', '!=', $request->user()->id)
            ->get();
        foreach ($workers as $worker) {
            $worker['fname'] = $worker->fname . ' ' . $worker->lname;
            if ($worker->role_id == 3) {
                $packages = [];
                foreach (Package::all() as $package) {
                    if ($package->driver_id == $worker->id) {
                        array_push($packages, $package);
                    }
                }
                $worker['packages'] = $packages;
            }
        }

        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $workers
        ];

        return response()->json($arr);
    });
    
    Route::POST('/workers', function (Request $request) {
        $workers = User::where('role_id', '!=', 2)
            ->where('role_id', '!=', 1)
            ->where('id', '!=', $request->user()->id)
            ->get();
        foreach ($workers as $worker) {
            $worker['fname'] = $worker->fname . ' ' . $worker->lname;
            if ($worker->role_id == 3) {
                $packages = [];
                foreach (Package::all() as $package) {
                    if ($package->driver_id == $worker->id) {
                        array_push($packages, $package);
                    }
                }
                $worker['packages'] = $packages;
            }
        }

        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $workers
        ];

        return response()->json($arr);
    });
    
    
    
    Route::post('packages/setqr', function (Request $request) {
        $roles = [
            'qr_code' => 'required|unique:packages,qr_code'
        ];
        $validator = Validator::make($request->all(), $roles);
        if ($validator->fails()) {
            $arr = [
                'code' => 302,
                'state' => 'false',
            ];
            return response()->json($arr);
        } else {
            $package = Package::find($request->package_id);
            $package->update([
                'qr_code' => $request->qr_code,
            ]);
            PackageLog::create([
                'user' => $request->user()->fname . ' ' . $request->user()->lname,
                'package_id' => $package->id,
                'shipping_state' => $package->shipping_state,
                'package_location' => $package->package_location,
                'details' => 'وضع رقم تسلسل للطرد',
            ]);
            $package['logs'] = $package->log;
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $package
            ];
            return response()->json($arr);
        }
    });
    Route::post('invoice/pay', function (Request $request) {
        $invoice = Invoice::find($request->invoice_id);
        $invoice->update([
            'invoice_state' => 'paid',
            'pay_to' => $request->pay_to,
            'pay_date' => Carbon::now()
        ]);
        $office = Office::find($request->user()->office_id);
        $invoice_user = User::find($invoice->user_id);
        if ($invoice->invoice_cost < 0) {
            $details = 'تحصيل قيمة فاتورة على العميل' . $invoice->user->fname . ' ' . $invoice->user->lname;
        } else {
            $details = ' دفع قيمة فاتورة الى العميل' . $invoice->user->fname . ' ' . $invoice->user->lname;
        }
        Transaction::create([
            'user_id' => $request->user()->id,
            'from' => $request->user()->fname . ' ' . $request->user()->lname,
            'to' => $invoice_user->fname . ' ' . $invoice_user->lname,
            'old_budget' => $office->budget,
            'new_budget' => ($office->budget - $invoice->invoice_cost),
            'details' => $details,
        ]);
        $office->update([
            'budget' => ($office->budget - $invoice->invoice_cost),
        ]);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $invoice
        ];
        return response()->json($arr);
    });
    Route::post('addexpense', function (Request $request) {
        $office = Office::find($request->user()->office_id);
        $office->update([
            'budget' => ($office->budget - $request->amount)
        ]);
        Transaction::create([
            'user_id' => $request->user()->id,
            'from' => $request->user()->fname . ' ' . $request->user()->lname,
            'to' => 'مصروفات',
            'old_budget' => $office->budget,
            'new_budget' => ($office->budget - $request->amount),
            'details' => 'مصروف بقيمة ' . $request->amount
        ]);
        $arr = [
            'code' => 200,
            'state' => 'success',
        ];
        return response()->json($arr);
    });
    Route::post('packages/changestate', function (Request $request) {
        try {
            $package = Package::find($request->package_id);
            if ($package) {
                $package->update([
                    'shipping_state' => $request->state,
                ]);
                PackageLog::create([
                    'user_id' => $request->user()->id,
                    'package_id' => $package->id,
                    'package_location' => $package->package_location,
                    'details' => 'تغيير حالة الطرد من ' . $package->shipping_state . ' الى الحاله' . $request->state,
                ]);
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
        } catch (\Throwable $th) {
            $arr = [
                'code' => 302,
                'state' => 'false',
                'data' => null,
            ];
            return response()->json($arr);
        }
    });
    Route::post('packages/settodriver', function (Request $request) {
        $package = Package::find($request->package_id);
        $package->update([
            'driver_id' => $request->driver_id,
        ]);
        $driver = User::find($request->driver_id);
        PackageLog::create([
            'user' => $request->user()->fname . ' ' . $request->user()->lname,
            'package_id' => $package->id,
            'package_location' => $package->package_location,
            'shipping_state' => $package->shipping_state,
            'details' => 'تحميل الطرد الي السائق ' . $driver->fname . ' ' . $driver->lname,
        ]);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $package,
        ];
        return response()->json($arr);
    });
    Route::post('packages/changelocation', function (Request $request) {
        $package = Package::find($request->package_id);
        $package->update([
            'package_location' => $request->package_location,
        ]);
        PackageLog::create([
            'user' => $request->user()->fname . ' ' . $request->user()->lname,
            'package_id' => $package->id,
            'shipping_state' => $package->shipping_state,
            'package_location' => $request->package_location,
            'details' => 'تغيير مكان الطرد الى ' . $request->package_location,
        ]);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $package,
        ];
        return response()->json($arr);
    });
    Route::post('packages/settooffice', function (Request $request) {
        $package = Package::find($request->package_id);
        $package->update([
            'driver_id' => null,
        ]);
        PackageLog::create([
            'user_id' => $request->user()->id,
            'package_id' => $package->id,
            'package_location' => $package->package_location,
            'details' => ' ارجاع الطرد الى المكتب',
        ]);
    });
    Route::post('balance', function (Request $request) {
        $budget = $request->user()->office->budget;
        $arr = [
            'code' => 200,
            'state' => 'success',
            'budget' => $budget
        ];
        return response()->json($arr);
    });
    Route::post('packages/bulkupdate', function (Request $request) {
        foreach ($request->packages_id as $id) {
            $package = Package::find($id);
            $packages = [];
            array_push($packages, $package);
            if (isset($request->state)) {
                if ($request->state == 'returns') {
                    $sender = User::find($package->user_id);
                    if ($sender->returns_cost > 0) {
                        $returns_cost = $package->delivery_cost * ($sender->returns_cost / 100);
                        $sender->update([
                            'budget' => $sender->budget - $returns_cost
                        ]);
                    }
                    $package->update([
                        'shipping_state' => 'returns',
                        'delivery_cost' => $returns_cost,
                    ]);
                }
                $package->update([
                    'shipping_state' => $request->state
                ]);
            }
            if (isset($request->location)) {
                $package->update([
                    'package_location' => $request->location
                ]);
            }
            if (isset($request->driver_id)) {
                $package->update([
                    'driver_id' => $request->driver_id
                ]);
            }
        }
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $packages,
        ];
        return response()->json($arr);
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
            'details' => 'قام الموظف ' . $request->user()->fname . ' ' . $request->user()->lname . ' ' . 'بتعديل بيانات الطرد',
        ]);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $package
        ];
        return response()->json($arr);
    });
    Route::post('/packages/cancel', function (Request $request) {
        $package = Package::find($request->package_id);
        if ($package->shipping_state == 'processing' || $package->shipping_state == 'ready') {
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
    });
    Route::post('/packages/replaceqr', function (Request $request) {
        $package = Package::find($request->package_id);
        $roles = [
            'qr_code' => 'required|unique:packages,qr_code'
        ];
        $validator = Validator::make($request->all(), $roles);
        if ($validator->fails()) {
            $arr = [
                'code' => 302,
                'state' => 'false',
            ];
            return response()->json($arr);
        } else {
            $package->update([
                'qr_code' => $request->qr_code,
            ]);
            PackageLog::create([
                'user' => $request->user()->fname . ' ' . $request->user()->lname,
                'package_id' => $package->id,
                'package_location' => $package->package_location,
                'shipping_state' => $package->shipping_state,
                'notes' => null,
                'details' => 'قام الموظف ' . $request->user()->fname . ' ' . $request->user()->lname . ' ' . 'بأستبدال رقم التتبع للطرد٫',
            ]);
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $package
            ];
            return response()->json($arr);
        }
    });
    Route::post('/packages/resend', function (Request $request) {
        $package = Package::find($request->package_id);
        $package->update([
            'shipping_state' => 'shipped'
        ]);
        $package['logs'] = $package->log;
        PackageLog::create([
            'user' => $request->user()->fname . ' ' . $request->user()->lname,
            'package_id' => $package->id,
            'shipping_state' => $package->shipping_state,
            'package_location' => $package->package_location,
            'details' => 'قام ' . $request->user()->fname . ' ' . $request->user()->lname . ' بأعادة شحن الطرد',
        ]);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $package,
        ];
        return response()->json($arr);
    });
    Route::post('/packages/toowner', function (Request $request) {
        $package = Package::find($request->package_id);
        $package->update([
            'is_back_to_owner' => Carbon::now(),
        ]);
        PackageLog::create([
            'user' => $request->user()->fname . ' ' . $request->user()->lname,
            'package_id' => $package->id,
            'shipping_state' => $package->shipping_state,
            'package_location' => $package->package_location,
            'details' => 'أرجاع الطرد للمرسل',
        ]);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $package,
        ];
        return response()->json($arr);
    });
    Route::post('/transactions', function (Request $request) {
        $transactions = Transaction::where('user_id', $request->user()->id)->get();
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $transactions,
        ];
        return response()->json($arr);
    });
    Route::post('reset-password', function (Request $request) {
        $user = User::find($request->user_id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $user,
        ];
        return response()->json($arr);
    });
    Route::post('/fbtoken', function (Request $request) {
        $user = User::find($request->user_id);
        $user->update([
            'fb_token' => $request->fb_token,
        ]);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $user,
        ];
        return response()->json($arr);
    });
    Route::post('/cashout', function (Request $request) {
        $driver = User::find($request->id);
        $office = $request->user()->office;
        // $driver_name = $driver->fname . ' ' . $driver->lname;
        // $emp_name = $request->user()->fname . ' ' . $request->user()->lname;
        // $details = 'قام الموظف ' . $emp_name . ' بسحب كل مبلغ حساب السائق' . $driver_name . ' و أضافتها الى مبلغ صندوق مكتب' . $office->name;
        foreach ($driver->packages as $package) {
            if ($package->shipping_state = 'delivered') {
                $package->update([
                    'driver_id' => null
                ]);
            }
        }
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $driver,
        ];
        return response()->json($arr);
    });
    Route::post('/part-withdraw', function (Request $request) {
        $office = $request->user()->office;
        $driver = User::find($request->id);
        $driver->update([
            'budget' => $driver->budget - $request->amount
        ]);
        $office->update([
            'budget' => $office->budget + $request->amount
        ]);
        $office = $request->user()->office;
        $driver_name = $driver->fname . ' ' . $driver->lname;
        $emp_name = $request->user()->fname . ' ' . $request->user()->lname;
        $details = 'قام الموظف ' . $emp_name . ' بسحب مبلغ بقيم ' . $request->amount . ' من حساب السائق ' . $driver_name . ' و أضافتها الى مبلغ صندوق مكتب' . $office->name;
        Transaction::create([
            'user_id' => $request->user()->id,
            'from' => $request->user()->fname . ' ' . $request->user()->lname,
            'to' => $driver->fname . ' ' . $driver->lname,
            'old_budget' => $office->budget,
            'new_budget' => ($office->budget - $request->amount),
            'details' => $details,
        ]);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $driver,
        ];
        return response()->json($arr);
    });
    Route::post('/add-to-driver', function (Request $request) {
        $driver = User::find($request->id);
        $driver->update([
            'budget' => $driver->budget + $request->amount
        ]);
        $office = Office::find($request->user()->office->id);
        $details = 'أضافة مبلغ الى صندوق السائق ' . $driver->fname . ' ' . $driver->lname;
        Transaction::create([
            'user_id' => $request->user()->id,
            'from' => $request->user()->fname . ' ' . $request->user()->lname,
            'to' => $driver->fname . ' ' . $driver->lname,
            'old_budget' => $office->budget,
            'new_budget' => ($office->budget - $request->amount),
            'details' => $details,
        ]);
        $office->update([
            'budget' => $office->budget - $request->amount
        ]);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $driver,
        ];
        return response()->json($arr);
    });
    Route::post('packages/normal/undeliver', function (Request $request) {
        $package = Package::find($request->package_id);
        $package->update([
            'shipping_state' => 'shipped',
            'package_location' => 'مع السائق'
        ]);
        $sender = User::find($package->user_id);
        $driver = User::find($package->driver_id);
        $sender->update([
            'budget' => $sender->budget - ($package->total_cost - ($package->delivery_cost + $package->plus_cost))
        ]);
        $driver->update([
            'budget' => $driver->budget - $package->total_cost
        ]);

        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $package
        ];
        return response()->json($arr);
    });
    Route::post('packages/exchange/undeliver', function (Request $request) {
        $package = Package::find($request->package_id);
        $package->update([
            'shipping_state' => 'shipped',
            'package_location' => 'مع السائق'
        ]);
        $sender = User::find($package->user_id);
        $driver = User::find($package->driver_id);


        $sender->update([
            'budget' => $sender->budget - ($package->total_cost - ($package->delivery_cost + $package->plus_cost))
        ]);
        $driver->update([
            'budget' => $driver->budget - $package->total_cost
        ]);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $package
        ];
        return response()->json($arr);
    });
    Route::post('packages/pay/undeliver', function (Request $request) {
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
            $driver = User::find($package->driver_id);
            $sender = User::find($package->user_id);
            //$package_cost = $package->total_cost - ($package->plus_cost - $package->delivery_cost);
            $driver->update([
                'budget' => $driver->budget - $package->total_cost
            ]);
            $sender->update([
                'budget' => $sender->budget - ($package->total_cost - $package->delivery_cost - $package->plus_cost)
            ]);

            $package->update([
                'shipping_state' => 'shipped',
                'package_location' => 'مع السائق'
            ]);
            $arr = [
                'code' => 200,
                'state' => 'success',
            ];
            return response()->json($arr);
        }
    });
    Route::post('packages/return-buy/undeliver', function (Request $request) {
        $roles = [
            'package_id' => 'required',
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
            $driver = User::find($package->driver_id);
            $sender = User::find($package->user_id);
            $driver->update([
                'budget' => $driver->budget - $package->total_cost
            ]);
            $sender->update([
                'budget' => $sender->budget - ($package->total_cost - $package->delivery_cost - $package->plus_cost)
            ]);
            $package->update([
                'shipping_state' => 'shipped',
                'package_location' => 'مع السائق'
            ]);
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $package
            ];
            return response()->json($arr);
        }
    });
});
