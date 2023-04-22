<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::all();
        $arr = [
            'code' => 200,
            'state' => 'Success',
            'data' => $addresses,
        ];
        return response()->json($arr);
    }
    public function create(Request $request)
    {
        $request->validate([
            'address' => 'nullable',
            'delivery_price' => 'nullable|string',
            'parent_city' => 'nullable|string',
        ]);
        $input = $request->all();
        $address = Address::create($input);
        $arr = [
            'code' => 200,
            'state' => 'Success',
            'data' => $address,
        ];
        return response()->json($arr);
    }
    public function edit(Request $request, $id)
    {
        $address = Address::findOrFail($id);
        if ($address) {
            $input = $request->all();
            $address->update($input);
            $arr = [
                'code' => 200,
                'state' => 'Success',
                'data' => $address,
            ];
            return response()->json($arr);
        } else {
            $arr = [
                'code' => 302,
                'state' => 'False',
                'data' => null,
            ];
            return response()->json($arr);
        }
    }
    public function show($id)
    {
        $address = Address::findOrFail($id);
        if ($address) {
            $arr = [
                'code' => 200,
                'state' => 'Success',
                'data' => $address,
            ];
            return response()->json($arr);
        } else {
            $arr = [
                'code' => 302,
                'state' => 'False',
                'data' => null,
            ];
            return response()->json($arr);
        }
    }
}
