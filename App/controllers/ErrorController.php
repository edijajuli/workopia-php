<?php

namespace App\Controllers;

class ErrorController
{
    public static function notFound($message = 'Resource not found')
    {
        http_response_code(404);

        loadView('error', [
            'status' => '404',
            'message' => $message
        ]);
    }
    public static function unauthorized($message = 'Your are not authorized to access this resource')
    {
        http_response_code(403);

        loadView('error', [
            'status' => '403',
            'message' => $message
        ]);
    }
}
