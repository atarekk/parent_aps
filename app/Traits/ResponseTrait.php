<?php


namespace App\Traits;


use Illuminate\Http\Response;

trait ResponseTrait
{
    public function sendSuccessResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return Response
     */
    public function sendErrorResponse(array $errorMessages, int $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $errorMessages,
        ];


        return response()->json($response, $code);
    }
}
