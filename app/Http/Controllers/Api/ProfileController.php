<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Area;
use App\Models\Village;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        $area_name = Area::find($user->area_id)->area_name;
        $village_name = Village::find($user->village_id)->village_name;
        $user['area_name'] = $area_name;
        $user['village_name'] = $village_name;
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $request->user(),
        ];
        return response()->json($arr);
    }
    public function update(Request $request)
    {
        $user = $request->user();
        $input = $request->all();
        $user->update($input);
        $arr = [
            'code' => 200,
            'state' => 'success',
            'data' => $user,
        ];
        return response()->json($arr);
    }
}
