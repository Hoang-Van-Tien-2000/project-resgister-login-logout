<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class Helper
{
    const SUCCESS_OK = 0;
    const SUCCESS_FALSE = 1;

    public static function responseOkAPI($code, $data = [])
    {
        $output = [
            'success' => self::SUCCESS_OK,
            'data' => $data,
            'errors' => []
        ];
        return response()->json([
            $output, $code
        ]);
    }

    public static function responseErrorAPI($code, $errorCode, $message, $data = [])
    {
        $output = [
            'success' => self::SUCCESS_FALSE,
            'data' => $data,
            'errors' => [
                'error_code' => $errorCode,
                'error_message' => $message
            ]
        ];
        return response()->json([
            $output, $code
        ]);
    }
}
