<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    public function index()
    {
        $villages = Village::get();
        return view('villages.index',compact('villages'));
    }
    public function create(Request $request)
    {
        return view('villages.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'area_id'=>'required|numeric|exists:areas,id',
            'village_name'=>'required|string|unique:villages,village_name',
            'delivery_cost'=>'required|numeric'
        ]);
        Village::create($request->all());
        return redirect(route('villages.index'));
    }
    public function edit(Request $request,$id)
    {
        $village = Village::find($id);
        if($village){
            return view('villages.edit', compact('village'));
        }else{
            return redirect(route('villages.index'))->with(['error'=>'Invalid Village']);
        }

    }
    public function update(Request $request, $id)
    {
        $village = Village::find($id);
        if ($village) {
            $request->validate([
                'area_id' => 'required|numeric|exists:areas,id',
                'village_name' => 'required|string|unique:villages,village_name,' . $id,
                'delivery_cost' => 'required|numeric'
            ]);
            $village->update($request->all());
            return redirect(route('villages.index'))->with(['success' => 'Village Updated Successfully']);
        } else {
            return redirect(route('villages.index'))->with(['error' => 'Invalid Village']);
        }
    }
    public function destroy($id)
    {
        $village = Village::find($id);
        if ($village) {
           try {
                $village->delete();
                return redirect(route('villages.index'))->with(['success' => 'Village Deleted Successfully']);
           } catch (\Throwable $th) {
                return redirect(route('villages.index'))->with(['error' => 'Can\'t Delete THis Village as It Has Related Packages']);
           }
        } else {
            return redirect(route('villages.index'))->with(['error' => 'Invalid Village']);
        }
    }
}
