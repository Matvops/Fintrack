<?php

namespace App\Http\Controllers;

use App\Utils\Response;

abstract class Controller
{
    protected function sendResponse(Response $response)
    {
        $content = [
            'status' => $response->getStatus(),
            'message' => $response->getMessage(),
            'data' => $response->getData()
        ];

        $statusCode = (!is_null($response->getCode()) ?  $response->getCode() : $response->getStatus()) ? 200 : 500;  

        return response($content, $statusCode);
    }
}
