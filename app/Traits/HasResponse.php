<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HasResponse
{
    /**
     * Default structure to prepare any json response
     *
     * @param string $message
     * @param int $code
     * @return array
     */
    public function defaultStructure($code = JsonResponse::HTTP_OK, $message = 'OK', $success = true)
    {
        return [
            'status' => [
                'code' => $code,
                'message' => $message,
            ],
            'success' => $success,
            'message' => $message,
        ];
    }

    /**
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function defaultResponse($message = 'OK', $code = JsonResponse::HTTP_NO_CONTENT)
    {
        $structure = $this->defaultStructure($code, $message);

        return response()->json($structure, $code);
    }

    /**
     * @param $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $message = 'OK', $code = JsonResponse::HTTP_OK)
    {
        $structure = $this->defaultStructure($code, $message);
        $structure['data'] = $data;

        return response()->json($structure, $code);
    }
    public function customizeMessage($message, $code = JsonResponse::HTTP_OK)
    {
        $structure = $this->defaultStructure($code, $message);

        return response()->json($structure, $code);
    }

    /**
     * @param $errors
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($errors, $message, $code)
    {
        $errorsIsArray = is_array($errors);
        $success = false;

        $structure = $this->defaultStructure($code, $message, $success);
        $structure['errors'] = !$errorsIsArray || ($errorsIsArray && count($errors) > 0) ? $errors : null;

        return response()->json($structure, $code);
    }
}
