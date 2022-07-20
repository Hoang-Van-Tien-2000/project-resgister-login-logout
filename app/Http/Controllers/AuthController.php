<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserService;
use App\Models\User;
use App\Helpers\Helper;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function register(RegisterRequest $request) 
    {
        try {

            $user = $this->userService->registerUser($request->all()); 
            $user->sendEmailVerificationNotification();
            
            return Helper::responseOkAPI(
                Response::HTTP_OK,
                [
                    'message' => 'Verification link sent',
                    'user' => $user
                ],
            );
        } catch (\Exception $e){
            return Helper::responseErrorAPI(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                User::ERR_INTERNAL_SERVER_ERROR,
                $e->getMessage()
            );
        }
    }
    
    public function verify(Request $request)
    {
        $user = $this->userService->getUserVerify($request->id);

        try {
        
            if ($user->hasVerifiedEmail()) {
                
                return Helper::responseErrorAPI(
                    Response::HTTP_OK,
                    User::ERR_EMAIL_ALREADY_VERIFIED,
                    'Email already verified'
                );
            }
                $user->markEmailAsverified();
                
                return Helper::responseOkAPI(
                Response::HTTP_OK,
                [
                'message' => 'Email has been verified',
                'user' => $user
                ],
            );
        } catch (\Exception $e) {
                return Helper::responseErrorAPI(
                Response::HTTP_INTERNAL_SERVER_ERROR,
                User::ERR_INTERNAL_SERVER_ERROR,
                $e->getMessage()
        );
        }
    }
}