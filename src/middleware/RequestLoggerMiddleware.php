<?php

namespace Src\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Monolog\Logger;

class RequestLoggerMiddleware  implements MiddlewareInterface
{


    public function __construct(
        private Logger $request_logger
    ) {
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {


        $method = $request->getMethod();

        $protocolVersion = $request->getProtocolVersion();

        $uri = $request->getUri();

        $uri->getUserInfo();
        $host = $uri->getHost();

        $port = $uri->getPort();

        $message = "Request received with 
            {$protocolVersion}://{$host}{$port}
            Method {$method}
        ";

        $this->request_logger->debug(
            $message,
            compact(
                "host",
                "method",
                "protocolVersion",
                "port",
            )
        );


        $response = $handler->handle($request);



        return $response;
    }
}
