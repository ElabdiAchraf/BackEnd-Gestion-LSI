<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function SendResponse($result, $message)
    {
        $response = [
            "data" => $result,
            "message" => $message,
            'success' => true
        ];
        return response()->json($response, 200);
    }
    public function SendError($error, $errorMessage = [])
    {
        $response = [
            "data" => $error,
            "success" => false,
        ];
        if (!empty($errorMessage)) {
            $response["data"] = $errorMessage;
        }
        return response()->json($response, 401);
    }
}
