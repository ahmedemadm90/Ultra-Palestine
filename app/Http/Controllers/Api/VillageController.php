<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'city_id'=>'required|numeric|exists:cities,id',
            'village_name'=>'required|string|max:50|unique:villages,village_name',
            'delivery_cost'=>'required',

        ]);
        $input = $request->all();
        Village::create($input);
    }
    public function edit(Request $request)
    {
        $village = Village::find($request->village_id);
        if($village){
            $request->validate([
                'city_id' => 'required|numeric|exists:cities,id',
                'village_name' => 'required|string|max:50|unique:villages,village_name,' . $request->village_id,
                'delivery_cost' => 'required',
            ]);
            $input = $request->all();
            $village->update($input);
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $village,
            ];
            return response()->json($arr);
        }else{
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => null,
            ];
            return response()->json($arr);
        }
    }
}
