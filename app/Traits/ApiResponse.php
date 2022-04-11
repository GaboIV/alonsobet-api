<?php

namespace App\Traits;

use stdClass;

trait ApiResponse {
	protected function successResponse($data, $code, $message = "Success") {
		return response()->json($data ?? new stdClass(), $code);
	}

	protected function errorResponse($message, $code, $data = null) {
		return response()->json([
            'message' => $message,
            'code' => $code,
            'data' => $data ?? new stdClass()
        ], $code);
	}
}
