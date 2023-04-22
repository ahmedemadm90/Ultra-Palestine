<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfficeController extends Controller
{
    public function index()
    {
        return view('offices.index');
    }
    public function create()
    {
        return view('offices.create');
    }
    public function store(Request $request)
    {
        $roles = [
            'office_name'=>'required|string|max:150',
            'office_phone'=>'required|string|max:150',
        ];
        $validator = Validator::make($request->all(),$roles);
        if($validator->fails()){
            return back()->with(['error'=>$validator->errors()]);
        }else{
            Office::create($request->all());
            return redirect(route('offices.index'))->with(['success'=>'تم انشاء المكتب بنجاح']);
        }
    }
    public function edit($id)
    {
        $office = Office::find($id);
        return view('offices.edit',compact('office'));
    }
    public function update(Request $request, $id)
    {
        $office = Office::find($id);
        $request->validate([
            'office_name'=>'required|string|max:150|unique:offices,office_name,'.$id,
            'office_phone'=>'required|string|max:150|unique:offices,office_phone,'.$id,
        ]);
        $office->update($request->all());
        return redirect(route('offices.index'))->with(['success' => 'تم تعديل بيانات المكتب بنجاح']);
    }
}
