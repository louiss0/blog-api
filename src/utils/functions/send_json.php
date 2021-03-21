<?php

namespace Src\Utils\Functions;

use Psr\Http\Message\ResponseInterface as Response;
use Src\Enums\CommonHTTPStatusCodes;

function send_json(
    Response $response,
    string $message,
    array| null $data = null,
    string | null $token = null,
    $status_code = CommonHTTPStatusCodes::OK
): Response {
    # code...

    $response
        ->withStatus($status_code)
        ->getBody()
        ->write(json_encode(
            [
                "status" => "success",
                "message" => $message,
                "data" => $data,
                "token" => $token
            ],
            JSON_PRETTY_PRINT
        ));


    return $response;
}
