<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Api\Area;
use App\Models\Api\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'area_id' => 'required|numeric|exists:areas,id',
            'city_name' => 'required|string|max:50|unique:cities,city_name',
        ]);
        $input = $request->all();
        $city = City::create($input);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $city,
        ];
        return response()->json($arr);
    }
    public function edit(Request $request)
    {
        $city = City::find($request->city_id);
        $request->validate([
            'area_id' => 'required|numeric|exists:areas,id',
            'city_name' => 'required|string|max:50|unique:cities,city_name,'. $request->city_name,
        ]);
        $input = $request->all();
        $city->update($input);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $city,
        ];
        return response()->json($arr);
    }
    public function areascities(Request $request)
    {
        $area = Area::find($request->area_id);
        if($area){
            $cities = $area->cities;
            $arr = [
                'code'=>200,
                'state'=>'success',
                'data'=>$cities,
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
