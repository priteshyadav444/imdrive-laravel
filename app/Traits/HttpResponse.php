<?php

namespace App\Traits;

trait HttpResponse
{
    /**
     * success Payload with status code, messages and Data
     *
     * @param  mixed $data
     * @param  mixed $message
     * @param  mixed $status
     * @return void
     */
    protected function success($data = [], $message = null, $status = 200)
    {
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $data
        ];
        if ($message == null) unset($response['message']);

        return Response($response, $status);
    }


    /**
     * error Payload with status code, messages and Data
     *
     * @param  mixed $data
     * @param  mixed $message
     * @param  mixed $status
     * @return void
     */
    protected function error($data = null, $message = null, $status = 400)
    {
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $data
        ];

        if ($data == null) unset($response['data']);
        if ($message == null) unset($response['message']);

        return Response($response, $status);
    }
}
