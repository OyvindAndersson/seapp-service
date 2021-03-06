<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiResponseController extends Controller
{
    public function sendResponse($response)
    {
        return response()->json($response, 200);
    }


    public function sendError($error, $code = 404)
    {
    	$response = [
            'error' => $error,
        ];
        return response()->json($response, $code);
    }
}
