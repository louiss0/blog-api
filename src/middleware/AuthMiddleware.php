<?php

namespace Src\Middleware;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Validation\RequiredConstraintsViolated;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpException;
use Slim\Exception\HttpUnauthorizedException;
use Src\Enums\CommonHTTPStatusCodes;
use Src\Enums\DependencyStrings;

use function Src\Utils\Functions\throw_error_if_expression_is_true;

final class AuthMiddleware  implements MiddlewareInterface
{



    public function __construct(
        private ContainerInterface $container
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = null;

        $zero = 0;

        $one = 1;

        $auth_header = $request->getHeader("Authorization");


        $this->checkIfAuthorizationHeaderIsSet($request);

        $bearer_array =  explode(" ", $auth_header[$zero]);


        $this->checkIfAuthorizationHeaderStartsWithBearer($request, $bearer_array[$zero]);


        $token = $bearer_array[$one];


        $this->checkIfThereIsNoToken($request, $token);

        $this->validateToken($request, $token);


        return $handler->handle($request->withAttribute("token", $token));
    }



    private function checkIfAuthorizationHeaderIsSet(ServerRequestInterface $request): void
    {
        # code...

        $no_auth_header = !$request->hasHeader("Authorization");

        throw_error_if_expression_is_true(
            $no_auth_header,
            new HttpUnauthorizedException(
                request: $request,
                message: 'A Bearer Token must be sent Please log in to get access.',
            )
        );
    }

    private  function checkIfAuthorizationHeaderStartsWithBearer(ServerRequestInterface
    $request,  string $bearer_array): void
    {

        $auth_header_does_not_start_with_bearer = !str_starts_with(
            haystack: $bearer_array,
            needle: "Bearer"
        );

        throw_error_if_expression_is_true(
            $auth_header_does_not_start_with_bearer,
            new HttpUnauthorizedException(
                request: $request,
                message: 'You are not logged in! Please log in to get access.',
            )
        );
    }


    private function validateToken(ServerRequestInterface $request, string $token): void
    {
        # code...


        $configuration = $this->container
            ->get(DependencyStrings::LCOBUCCI_CONFIG);

        if (!$configuration instanceof Configuration) {
            # code...

            throw new HttpException(
                $request,
                "Error Processing Request",
                CommonHTTPStatusCodes::SERVER_ERROR
            );
        }


        $parsed_token = $configuration->parser()->parse($token);

        $constraints = $configuration->validationConstraints();

        try {
            //code...
            $configuration->validator()->validate($parsed_token, ...$constraints);
        } catch (RequiredConstraintsViolated $exception) {

            throw new HttpUnauthorizedException(
                $request,
                "Can't access this route please login and try again",
                $exception
            );
        }
    }

    private function checkIfThereIsNoToken(ServerRequestInterface $request, string |null $token): void
    {
        # code...

        $no_token = !$token;

        throw_error_if_expression_is_true(
            $no_token,
            new HttpUnauthorizedException(
                request: $request,
                message: 'You are not logged in! Please log in to get access.',
            )
        );
    }
}
