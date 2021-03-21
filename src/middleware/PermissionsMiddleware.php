<?php


namespace Src\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteRestrictionMiddleware implements MiddlewareInterface
{


    function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $response = $handler->handle($request);



        return $response;
    }
}
