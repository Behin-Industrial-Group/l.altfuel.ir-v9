<?php

namespace App\Traits;

trait ResponseTrait
{
    private function jsonResponse($msg, $status_code = 200, array $data = [], $msg_code = null){
        return response()->json(
            [
                "status_code" => $msg_code,
                "message" => $msg,
                "data" => $data
            ],
            $status_code,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}