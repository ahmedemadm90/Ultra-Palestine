<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            $role = auth()->user()->role;
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ];
            return response()->json($arr);
        }
        $arr = [
            'code' => 302,
            'state' => 'False',
            'data' => 'Invaled Credintials'
        ];
        return response()->json($arr);
    }
    public function driverlogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            if ($user->role->role_name == 'driver') {
                $arr = [
                    'code' => 200,
                    'state' => 'success',
                    'data' => $user,
                    'token' => $user->createToken('auth_token')->plainTextToken,
                ];
                return response()->json($arr);
            } else {
                $arr = [
                    'code' => 401,
                    'state' => 'false',
                ];
                return response()->json($arr);
            }
        }
        $arr = [
            'code' => 302,
            'state' => 'False',
            'data' => 'Invaled Credintials'
        ];
        return response()->json($arr);
    }
    public function employeelogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            if ($user->role->role_name == 'employee') {
                $arr = [
                    'code' => 200,
                    'state' => 'success',
                    'data' => $user,
                    'token' => $user->createToken('auth_token')->plainTextToken,
                ];
                return response()->json($arr);
            } else {
                $arr = [
                    'code' => 401,
                    'state' => 'false',
                ];
                return response()->json($arr);
            }
        }
        $arr = [
            'code' => 302,
            'state' => 'False',
            'data' => 'Invaled Credintials'
        ];
        return response()->json($arr);
    }
    public function adminlogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = auth()->user();
            if ($user->role->role_name == 'admin') {
                $arr = [
                    'code' => 200,
                    'state' => 'success',
                    'data' => $user,
                    'token' => $user->createToken('auth_token')->plainTextToken,
                ];
                return response()->json($arr);
            } else {
                $arr = [
                    'code' => 401,
                    'state' => 'false',
                ];
                return response()->json($arr);
            }
        }
        $arr = [
            'code' => 302,
            'state' => 'False',
            'data' => 'Invaled Credintials'
        ];
        return response()->json($arr);
    }
    public function logout(Request $request)
    {
        $arr = [
            'code' => 200,
            'state' => true,
            'data' => 'Logged Out',
        ];
        return response()->json($arr);
    }
    public function register(Request $request)
    {
        $input = $request->all();
        $roles = [
            'fname' => 'required|string|max:25',
            'lname' => 'required|string|max:25',
            'tm_name' => 'nullable|string|max:50',
            'phone' => 'required|unique:users,phone',
            'email' => 'required|email',
            'password' => 'required',
            'village_id' => 'required|exists:villages,id',
            'street' => 'nullable|string',
            'image' => 'file|mimes:jpg,jpeg,png,gif',
        ];
        $validator = Validator::make($input, $roles);
        $area_id = Village::find($request->village_id)->area->id;
        $input['area_id'] = $area_id;
        $input['role_id'] = Role::where('role_name', 'client')->first()->id;
        $input['password'] = Hash::make($request->password);
        if ($validator->fails()) {
            $arr = [
                'code' => 302,
                'state' => 'false',
                'data' => null,
                'errors' => $validator->errors()
            ];
            return response()->json($arr);
        } else {
            $user = User::create($input);
            $user['role']= Role::find($user->role_id)->role_name;
            $arr = [
                'code' => 200,
                'state' => 'success',
                'data' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ];
            return response()->json($arr);
        }
    }
}
