<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserService;
use App\Models\User;
use App\Helpers\Helper;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function login(LoginRequest $request)
    {
        try {
            
            $token = $this->userService->loginUser($request->all());
            
            if (!$token ) {
                return Helper::responseErrorAPI(
                    Response::HTTP_UNAUTHORIZED,
                    User::ERR_LOGIN_FAILED,
                    'Login failed'
                );
            }
            if (!Auth::user()->hasVerifiedEmail()) { 
                return Helper::responseErrorAPI(
                    Response::HTTP_OK,
                    User::ERR_EMAIL_ALREADY_VERIFIED,
                    'Email  not verified'
                );
            }
            
            $result = [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60,
                'user' => auth()->user()
            ];
            
            return Helper::responseOkAPI(
                Response::HTTP_OK,
                $result);
                
            } catch (\Exception $e) {
                return Helper::responseErrorAPI(
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    User::ERR_INTERNAL_SERVER_ERROR,
                    $e->getMessage()
                );
            }    
        }
}