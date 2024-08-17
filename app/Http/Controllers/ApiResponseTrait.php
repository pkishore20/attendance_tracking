<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Send a success response.
     *
     * @param string $message
     * @param mixed $data
     * @param int|null $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendSuccessResponse($message, $data = null, $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $data ?? [],
        ], $statusCode);
    }

    /**
     * Send an error response.
     *
     * @param string $message
     * @param int|null $statusCode
     * @param array $errors
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendErrorResponse($message, $statusCode = 500, $errors = []): JsonResponse
    {
        $response = [
            'status' => 'error',
            'status_code' => $statusCode,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Send a not found response.
     *
     * @param string $message
     * @param int|null $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendNotFoundResponse($message = 'Not Found', $statusCode = 404): JsonResponse
    {
        return $this->sendErrorResponse($message, $statusCode);
    }

    /**
     * Send a response with metadata.
     *
     * @param string $status
     * @param string $message
     * @param mixed $data
     * @param int|null $statusCode
     * @param array $metadata
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendResponseWithMetadata($status, $message, $data = null, $statusCode = 200, $metadata = []): JsonResponse
    {
        $response = [
            'status' => $status,
            'status_code' => $statusCode,
            'message' => $message,
            'data' => $data,
            'metadata' => $metadata,
             // Include status_code in response with metadata
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * Send a response with pagination metadata.
     *
     * @param string $status
     * @param string $message
     * @param mixed $data
     * @param int $total
     * @param int $perPage
     * @param int $currentPage
     * @param int|null $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendPaginatedResponse($status, $message, $data, $total, $perPage, $currentPage, $statusCode = 200): JsonResponse
    {
        $pagination = [
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $currentPage,
            'last_page' => ceil($total / $perPage),

        ];

        return $this->sendResponseWithMetadata($status, $message, $data, $statusCode, ['pagination' => $pagination]);
    }
}
