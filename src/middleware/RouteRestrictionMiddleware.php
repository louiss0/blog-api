<?php


namespace Src\Middleware;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\UnencryptedToken;
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

final class RouteRestrictionMiddleware implements MiddlewareInterface
{

    public function __construct(
        private ContainerInterface $container,
        private $role_restrictions = ["admin"]
    ) {
    }

    function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $token = $request->getAttribute("token");

        $lcobucci_config = $this->container->get(DependencyStrings::LCOBUCCI_CONFIG);


        $lcobucci_config_is_not_a_configuration =
            !$lcobucci_config instanceof Configuration;


        throw_error_if_expression_is_true(
            $lcobucci_config_is_not_a_configuration,
            new HttpException($request, "Something went wrong", CommonHTTPStatusCodes::SERVER_ERROR)
        );

        $token = $lcobucci_config
            ->parser()
            ->parse($token);


        $this->checkIfUserHasTheRightRole($request, $token);


        $response = $handler->handle($request);



        return $response;
    }



    private function checkIfUserHasTheRightRole(
        ServerRequestInterface $request,
        UnencryptedToken $parsed_token
    ) {

        $role = $parsed_token->claims()->get("role");

        $role_is_not_one_of_the_role_restrictions =
            !array_search(
                needle: $role,
                haystack: $this->role_restrictions,
                strict: true
            );

        $roles = implode(" ", " ", $this->role_restrictions);

        $message = "You are not allowed here you must be one of these {$roles}";

        throw_error_if_expression_is_true(
            expression: $role_is_not_one_of_the_role_restrictions,
            error: new HttpUnauthorizedException($request, $message)
        );
    }
}
