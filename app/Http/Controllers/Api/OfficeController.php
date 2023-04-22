<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::all();
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $offices
        ];
        return response()->json($arr);
    }
    public function create(Request $request)
    {
        $input = $request->all();
        $roles = [
            'office_name' => 'required|string|max:50|unique:offices,office_name',
        ];
        $validator = Validator::make($input, $roles);
        if ($validator->fails()) {
            $arr = [
                'code' => 302,
                'state' => 'false',
                'data' => null
            ];
            return response()->json($arr);
        } else {
            $office = Office::create($input);
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $office
            ];
            return response()->json($arr);
        }
    }
}
