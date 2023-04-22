<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'area_name' => 'required|unique:areas,area_name|string|max:50'
        ]);
        $area = Area::create([
            'area_name' => $request->area_name,
        ]);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $area,
        ];
        return response()->json($arr);
    }
    public function edit(Request $request)
    {
        $area = Area::find($request->area_id);
        if($area){
            $request->validate([
                'area_name' => 'required|string|max:50|unique:areas,area_name,' . $request->area_id
            ]);
            $area->update([
                'area_name' => $request->area_name
            ]);
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $area,
            ];
            return response()->json($arr);
        }else{
            $arr = [
                'code' => 302,
                'state' => 'false',
                'data' => null,
            ];
            return response()->json($arr);
        }

    }
}
