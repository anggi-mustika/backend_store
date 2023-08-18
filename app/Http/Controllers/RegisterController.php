<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nm_akhir_user' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'tgl_lhr' => 'required',
            'gender' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'ada kesalahan!',
                'data' => $validator->errors()
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        //$success['token'] =  $user->createToken('auth_token')->plainTextToken;
        $success['email'] =  $user->email;

        return response()->json([
            'success' => true,
            'message' => 'anda berhasil mendaftarkan akun',
            'data' => $success
        ]);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::user();
            $success['token'] =  $auth->createToken('auth_token')->plainTextToken;
            $success['name'] = $auth->name;

            return response()->json([
                'success' => true,
                'message' => 'anda berhasil melakukan login',
                'data' => $success
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'periksa kembali email dan password anda!',
                'data' => null
            ]);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'You have successfully logged out'
        ];
    }
}
