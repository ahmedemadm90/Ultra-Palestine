<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Invoice;
use App\Models\PackageLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function create(Request $request)
    {
        $user = $request->user();
        $packages_ids = [];
        $invoice_cost = 0;
        $packages = Package::where('user_id', $user->id)->where('invoice_id', null)->where('shipping_state', 'delivered')->get();
        foreach ($packages as $package) {
            array_push($packages_ids, $package->id);
        }
        foreach ($packages as $package) {
            if ($package->shipping_state == 'delivered') {
                $package_cost = $package->total_cost - $package->delivery_cost;
                $invoice_cost = $invoice_cost + $package_cost;
            }
            if ($package->shipping_state == 'returns') {
                array_push($packages_ids, $package->id);
                if ($user->returns_cost) {
                    $returns_cost = $package->delivery_cost * ($user->returns_cost / 100);
                    $invoice_cost = $invoice_cost - $returns_cost;
                }
            }
        }
        if (count($packages_ids) > 0) {
            $invoice = Invoice::create([
                'user_id' => $user->id,
                'packages_ids' => $packages_ids,
                'invoice_cost' => $invoice_cost,
                'invoice_state' => 'unpaid',
            ]);
            foreach ($packages as $package) {
                $package->update([
                    'invoice_id' => $invoice->id
                ]);
                PackageLog::create([
                    'user_id' => $invoice->user_id,
                    'package_location' => $package->package_location,
                    'shipping_state' => $package->shipping_state,
                    'details' => 'تم اضافة الطرد رقم ' . $package->id . ' الى فاتورة',
                ]);
            }
            $invoice['packages_ids'] = $packages;
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $invoice,
            ];
            $user->update([
                'budget' => 0
            ]);

            return response()->json($arr);
        } else {
            $arr = [
                'code' => 302,
                'state' => 'false',
                'data' => null,
            ];
            return response()->json($arr);
        }


        // $packages = Package::where('user_id', $user->id)->where('invoice_id', null)->get();
        // foreach ($packages as $package) {
        //     if ($package->state == 'delivered') {
        //         array_push($packages_ids, $package->id);
        //         $invoice_cost = $invoice_cost + ($package->total_cost - $package->delivery_cost);
        //     }
        //     if ($package->state == 'returns') {
        //         array_push($packages_ids, $package->id);
        //         $returns_cost = $package->delivery_cost * ($user->returns_cost / 100);
        //         $invoice_cost = $invoice_cost - $returns_cost;
        //     }
        // }
        // if (count($packages_ids) > 0) {
        //     $invoice = Invoice::create([
        //         'user_id' => $user->id,
        //         'packages' => $packages_ids,
        //         'invoice_cost' => $invoice_cost,
        //         'invoice_state' => 'unpaid',
        //     ]);
        //     foreach ($packages as $package) {
        //         $package->update([
        //             'invoice_id' => $invoice->id
        //         ]);
        //     }
        //     $invoice['packages'] = $packages;
        //     $arr = [
        //         'code' => 200,
        //         'state' => 'success',
        //         'data' => $invoice,
        //     ];
        //     return response()->json($arr);
        // } else {
        //     $arr = [
        //         'code' => 302,
        //         'state' => 'false',
        //         'data' => null,
        //     ];
        //     return response()->json($arr);
        // }
        // $user->update([
        //     'budget' => 0
        // ]);
    }
    public function myInvoices(Request $request)
    {
        $user = $request->user();
        $invoices = $user->invoices;

        foreach ($invoices as $invoice) {
            $packages = [];
            $newtime = strtotime($invoice->created_at);
            $invoice->invoice_create_date = date('d-m-Y', $newtime);
            foreach ($invoice->packages_ids as $id) {
                $package = Package::find($id);
                array_push($packages, $package);
            }
            $invoice['packages'] = $packages;

        }
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $invoices,
            'budget' => $user->budget,
        ];
        return response()->json($arr);
    }
    public function myUnpaidInvoices(Request $request)
    {
        $user = $request->user();
        $invoices = $user->invoices->where('invoice_state', 'unpaid');
        foreach ($invoices as $invoice) {
            $newtime = strtotime($invoice->created_at);
            $invoice->invoice_create_date = date('d-m-Y', $newtime);
            $packages = [];
            foreach ($invoice->packages as $id) {
                $package = Package::find($id);
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
    }
    public function mypaidinvoices(Request $request)
    {
        $user = $request->user();
        $invoices = $user->invoices->where('invoice_state', 'paid');
        foreach ($invoices as $invoice) {
            $newtime = strtotime($invoice->created_at);
            $invoice->invoice_create_date = date('d-m-Y', $newtime);
            $packages = [];
            foreach ($invoice->packages as $id) {
                $package = Package::find($id);
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
    }
    public function allInvoices(Request $request)
    {
        $user = $request->user();
        if ($user->role->role_name == 'admin' || $user->role->role_name == 'employee') {
            $invoices = Invoice::all();
            foreach ($invoices as $invoice) {
                $newtime = strtotime($invoice->created_at);
                $invoice->invoice_create_date = date('d-m-Y', $newtime);
            }
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $invoices
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
    public function allpaidInvoices(Request $request)
    {
        $user = $request->user();
        if ($user->role()->role_name == 'admin' || $user->role()->role_name == 'employee') {
            $invoices = Invoice::where('invoice_state', 'paid')->get();
            foreach ($invoices as $invoice) {
                $newtime = strtotime($invoice->created_at);
                $invoice->invoice_create_date = date('d-m-Y', $newtime);
            }
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $invoices
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
    public function allUnpaidInvoices(Request $request)
    {
        $user = $request->user();
        if ($user->role->role_name == 'admin' || $user->role->role_name == 'employee') {
            $invoices = Invoice::where('invoice_state', 'unpaid')->get();
            foreach ($invoices as $invoice) {
                $newtime = strtotime($invoice->created_at);
                $invoice->invoice_create_date = date('d-m-Y', $newtime);
                $invoice['packages'] = $invoice->packages;
            }
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $invoices,
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

    public function payInvoices(Request $request)
    {
        $invoice = Invoice::find($request->invoice_id);
        if ($invoice->invoice_state != 'paid') {
            $invoice_user = $invoice->user->fname.' ' . $invoice->user->lname;
            $packages = [];
            $invoice->update([
                'invoice_state' => 'paid',
                'pay_date' => Carbon::now()->toDateString(),
                'paid_to'=>$request->paid_to
            ]);
            foreach ($invoice->packages_ids as $id) {
                $package = Package::find($id);
                array_push($packages,$package);
            }
            $invoice['invoice_user'] = $invoice_user;
            $invoice['packages'] = $packages;
            $newtime = strtotime($invoice->created_at);
            $invoice->invoice_create_date = date('d-m-Y', $newtime);

            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $invoice,
            ];
            return response()->json($arr);
        }else{
            $arr = [
                'code' => 302,
                'state' => 'false',
                'data' => 'Already Paid',
            ];
            return response()->json($arr);
        }
    }
}
