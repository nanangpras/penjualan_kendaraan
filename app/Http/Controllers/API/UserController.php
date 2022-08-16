<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return ResponseFormatter::error($validator->errors()->first());
            exit;
        }
        $credentials = $request(['email', 'password']);

        try {
            if (!$token = auth()->attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ],'Invalid Credentials', 400);
            }
        } catch (\JWTException $th) {
            //throw $th;
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ],'Could not create token', 500);
        }

        return ResponseFormatter::success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Carbon::now()->addDays(30)->timestamp
            ],'Authenticated'
        );
    }
}
