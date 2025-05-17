<?php

namespace App\Http\Controllers\API;

use App\ApiResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ApiResponse;
    public function login(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email',
                'password' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $credentials = $request->only(['email', 'password']);
            $token = Auth::guard("api")->attempt($credentials);

            if (!$token) {
//
                return $this->notfoundResponse(null, 'Invalid Credentials', 401);
            }

            $user = Auth::guard("api")->user();

//
            return $this->successResponse($user, 'login successful..', 200, ['token' => $token]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'msg' => 'حدث خطأ أثناء تسجيل الدخول'
                // 'error' => $e->getMessage() // ممكن تفعله وقت التطوير فقط
            ], 500);
        }
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'=>'user',
        ]);

        if ($user) {
            return $this->successResponse($user, 'registered successful..', 200);
        }
return $this->notfoundResponse(null,'register failed',400);
    }

    public function logout(Request $request)
    {
        try {
            // الحصول على التوكن من الهيدر
            $token = JWTAuth::getToken();

            // التأكد إن التوكن موجود
            if (!$token) {
                return response()->json(['status' => false, 'msg' => 'التوكن غير موجود'], 400);
            }

            // إبطال التوكن
            JWTAuth::invalidate($token);

            return response()->json(['status' => true, 'msg' => 'تم تسجيل الخروج بنجاح']);

        } catch (JWTException $e) {
            return response()->json(['status' => false, 'msg' => 'فشل في تسجيل الخروج: ' . $e->getMessage()], 500);
        }
    }
    public function refresh(Request $request)
    {
        $new_token =  JWTAuth::refresh($request->token);
        if($new_token){
            return response()->json(['msg'=>$new_token]);
        }
        return response()->json(['msg'=>'something went wrong']);
    }
}
