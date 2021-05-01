<?php


namespace App\Traits;


use Illuminate\Http\JsonResponse;

trait ApiResponse
{

    /**
     * Returns a success JSON response
     *
     * @param array $data
     * @param string|null $message
     * @param int $statusCode
     * @return JsonResponse
     */
    private function success(array $data, string $message = null, int $statusCode = 200 ) : JsonResponse{
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }


    /**
     * Return an error JSON response
     *
     * @param string $message
     * @param int $statusCode
     * @param array|null $data
     * @return JsonResponse
     */
    private function error(string $message, int $statusCode, array $data = null) : JsonResponse {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
}
