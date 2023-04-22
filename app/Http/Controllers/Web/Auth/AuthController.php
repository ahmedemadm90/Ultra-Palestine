<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }
    public function doregister(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|string',
            'area_id' => 'required|exists:areas,id',
            'village_id' => 'required|exists:villages,id',
            'street' => 'required|string',
            'image' => 'file|nullable',
        ]);
        if($request->image){
            $ext = $request->image->extension();
            $imageName = uniqid() . "." . $ext;
            $request->image->move(public_path("media/users/profiles/"), $imageName);
            $input['image']=$imageName;
        }
        if($request->password == $request->confirm_password){
            $input['password'] = Hash::make($request->password);
        }else{
            return redirect(route('register'))->with(['error' => 'Password Dismatched']);
        }
        $input['role_id'] = 2;
        $input['returns_cost'] = 50;
        $input['plus_delivery_cost'] = 0;

        User::create($input);
        return redirect(route('login'))->with(['success'=>'User Created Successfully Plese Login']);
    }
    public function login()
    {
        return view('auth.login');
    }
    public function dologin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect(route('dashboard'));
        } else {
            return redirect(route('login'))->with(['error'=>'Invaled Credentials']);
        }
    }
}
