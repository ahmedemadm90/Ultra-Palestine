<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
    public function create()
    {
        $areas = Area::all();
        return view('users.create', compact('areas'));
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string',
            'area_id' => 'required|exists:areas,id',
            'village_id' => 'required|exists:villages,id',
            'street' => 'required|string',
            'image' => 'file|nullable',
            'returns_cost' => 'numeric|nullable|max:100',
            'delivery_cost_discount' => 'numeric|nullable|max:100',
        ]);
        if ($request->image) {
            $ext = $request->image->extension();
            $imageName = uniqid() . "." . $ext;
            array_push($gallery, $imageName);
            $request->image->move(public_path("media/users/profiles/"), $imageName);
            $input['image'] = $imageName;
        }
        User::create($input);
        return redirect(route('users.index'))->with(['success' => 'Created Successfully']);
    }
    public function edit(Request $request, $id)
    {
        $areas = Area::all();
        $user = User::find($id);
        return view('users.edit', compact('areas', 'user'));
    }
    public function update(Request $request, $id)
    {
        //dd($request->image);
        $input = $request->all();
        $user = User::find($id);
        if ($user) {
            $request->validate([
                'fname' => 'required|string',
                'lname' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'required|unique:users,phone,' . $id,
                'role_id' => 'required|exists:roles,id',
                'area_id' => 'required|exists:areas,id',
                'village_id' => 'required|exists:villages,id',
                'street' => 'required|string',
                'image' => 'file|nullable',
                'returns_cost' => 'numeric|nullable|max:100',
                'delivery_cost_discount' => 'numeric|nullable|max:100',
            ]);
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input['password'] = $user->password;
            }
            if($request->file('image')){
                if($user->image != null){
                    unlink(public_path('media/users/profiles/' . $user->image));
                    $ext = $request->image->extension();
                    $imageName = uniqid() . "." . $ext;
                    $request->image->move(public_path("media/users/profiles/"), $imageName);
                    $input['image'] = $imageName;
                }else{
                    $ext = $request->image->extension();
                    $imageName = uniqid() . "." . $ext;
                    $request->image->move(public_path("media/users/profiles/"), $imageName);
                    $input['image'] = $imageName;
                }

            }else{
                $input['image'] = $user->image;
            }
            $user->update($input);
            return redirect(route('users.index'))->with(['success' => 'Updated Successfully']);
        } else {
            return redirect(route('users.index'))->with(['error' => 'Invaled User']);
        }
    }
    public function show(Request $request, $id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }
    public function freeze(Request $request, $id)
    {
        $user = User::find($id);
        $user->update([
            'active' => 0
        ]);
        return redirect(route('users.index'))->with(['success' => 'User Successfully Freezed']);
    }
    public function unfreeze(Request $request, $id)
    {
        $user = User::find($id);
        $user->update([
            'active' => 1
        ]);
        return redirect(route('users.index'))->with(['success' => 'User Successfully Un-Freezed']);
    }
}
