<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiException extends Exception
{
    protected $status;
    protected $data;

    public function __construct($data = null, string $message = "", int $status = 400)
    {
        parent::__construct($message);
        $this->status = $status;
        $this->data = $data;
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'data' => $this->data
        ], $this->status);
    }
}
