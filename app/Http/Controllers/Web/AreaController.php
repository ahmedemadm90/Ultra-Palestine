<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::get();
        return view('areas.index', compact('areas'));
    }
    public function create()
    {
        return view('areas.create');
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'area_name' => 'required|unique:areas,area_name'
        ]);
        Area::Create($input);
        return redirect(route('areas.index'))->with(['success' => 'Area Created Successfully']);
    }
    public function edit(Request $request, $id)
    {
        $area = Area::find($id);
        if ($area) {
            return view('areas.edit', compact('area'));
        } else {
            return redirect(route('areas.index'))->with(['error' => 'Invalid Area']);
        }
    }
    public function update(Request $request, $id)
    {
        $area = Area::find($id);
        if ($area) {
            $request->validate([
                'area_name' => 'required|unique:areas,area_name,' . $id
            ]);
            $area->update([
                'area_name' => $request->area_name,
            ]);
            return redirect(route('areas.index'))->with(['success' => 'Area Information Updated Successfully']);
        } else {
            return redirect(route('areas.index'))->with(['error' => 'Invalid Area']);
        }
    }
    public function show($id)
    {
        $area = Area::find($id);
        if ($area) {
            return view('areas.show', compact('area'));
        } else {
            return redirect(route('areas.index'))->with(['error' => 'Invalid Area']);
        }

    }
}
