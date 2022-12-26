<?php

namespace App\Traits;

trait ResponseTrait
{
    private function jsonResponse($msg, $status_code = 200, array $data = []){
        return response()->json(
            [
                "message" => $msg,
                "data" => $data
            ],
            $status_code,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }
}