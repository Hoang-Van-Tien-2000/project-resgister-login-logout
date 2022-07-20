<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UserService;
use App\Models\User;
use App\Helpers\Helper;


class AuthController extends Controller
{
  
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function logout()
    {
        try {
            $this->userService->userLogout();
            
            return Helper::responseOkAPI(
                Response::HTTP_OK,
                'Logout out successfully'
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