<?php

namespace App\Exceptions;

use Exception;

class ApiDataException extends Exception
{
    public function render($request)
    {
        return response()->view('errors.api_data_error', ['exception' => $this], 500);
    }
}
