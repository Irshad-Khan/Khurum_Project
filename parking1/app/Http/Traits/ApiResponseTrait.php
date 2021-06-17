<?php


namespace App\Http\Traits;


use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * @param $status
     * @param null $message
     * @param null $data
     * @param int $statusCode
     * @return JsonResponse
     */
    public function responseWithSuccess($status, $message=null, $data=null, $statusCode=200)
    {
        return response()->json(
            [
                'status' => $status,
                'message' => $message,
                'data' => $data
            ], $statusCode
        );
    }

    /**
     * @param $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function responseWithError($message, $statusCode=200)
    {
        return response()->json(
            [
                'status' => false,
                'message' => $message,
            ], $statusCode
        );
    }
}
