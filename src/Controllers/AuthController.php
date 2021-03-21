<?php


namespace Src\Controllers;

use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Src\Interfaces\IAuthController;
use Src\Utils\Classes\AuthValidator;
use Laminas\Crypt\BlockCipher;
use Psr\Container\ContainerInterface;
use Slim\Exception\HttpException;
use Slim\Routing\RouteContext;
use Src\Enums\CommonHTTPStatusCodes;
use Src\Enums\DependencyStrings;
use Src\Enums\Paths;

use function Src\Utils\Functions\send_json;
use function Src\Utils\Functions\sign_token;
use function Src\Utils\Functions\throw_error_if_expression_is_true;

final class AuthController implements IAuthController
{


    public function __construct(
        private AuthValidator $authValidator,
        private ContainerInterface $container
    ) {
    }

    public function signIn(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {


        $this->authValidator->validateEmailAndPassword($request);

        $body = $request->getParsedBody();

        $now = new DateTimeImmutable();

        $lcobucci_config = $this->container
            ->get(DependencyStrings::LCOBUCCI_CONFIG);



        $token = sign_token(
            configuration: $lcobucci_config,
            user: array_merge($body, ["id" => "foo", 'role' => "user"]),
            now: $now,
            expires_at: $now->modify("+90 days")
        );


        return send_json(
            $response,
            message: "You are Signed In",
            token: $token,
            data: []
        );
    }

    function signUp(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {


        $this->authValidator
            ->validateNameEmailAndPassword($request);

        $body = $request->getParsedBody();


        $lcobucci_config = $this->container
            ->get(DependencyStrings::LCOBUCCI_CONFIG);


        $lcobucci_config_is_not_a_configuration_class =
            !$lcobucci_config  instanceof Configuration;

        # code..."You are not allowed here"


        throw_error_if_expression_is_true(
            $lcobucci_config_is_not_a_configuration_class,
            new HttpException(
                $request,
                "Something went wrong",
                CommonHTTPStatusCodes::SERVER_ERROR
            )
        );



        $now = new DateTimeImmutable();


        $token = sign_token(
            configuration: $lcobucci_config,
            user: array_merge($body, ["id" => "foo", 'role' => "user"]),
            now: $now,
            expires_at: $now->modify("+90 days")
        );



        return send_json(
            $response,
            message: "You are Signed Up",
            token: $token,
            data: [],
            status_code: CommonHTTPStatusCodes::CREATED
        );
    }

    function forgotPassword(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {

        $this->authValidator->validateEmail($request);



        $block_cipher = $this->container->get(DependencyStrings::BLOCK_CIPHER);

        $block_cipher_is_not_a_block_cipher =
            !$block_cipher instanceof BlockCipher;

        throw_error_if_expression_is_true(
            $block_cipher_is_not_a_block_cipher,
            new HttpException(
                $request,
                "Something went wrong",
                CommonHTTPStatusCodes::SERVER_ERROR
            )
        );

        $resetToken = $block_cipher
            ->encrypt(hash(hash_algos()[5], $_ENV["CRYPTO_PASSPHRASE"]));


        $body = $request->getParsedBody();


        $route_context = RouteContext::fromRequest($request);

        $reset_token_url = $route_context
            ->getRouteParser()
            ->fullUrlFor(
                uri: $request->getUri(),
                routeName: Paths::RESET_PASSWORD,
                data: ["token" => "{$resetToken}"]
            );


        return send_json(
            $response,
            message: "Token sent To  mail",
        );
    }

    function resetPassword(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {


        $this->authValidator->validatePasswordAndPasswordConfirm($request);

        $body = $request->getParsedBody();


        return send_json(
            $response,
            message: "Your password was reset",
        );
    }

    function updateMyPassword(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {


        $this->authValidator
            ->validatePasswordCurrentPasswordAndPasswordConfirm($request);

        $body = $request->getParsedBody();

        return send_json(
            $response,
            message: "Password Updated",
        );
    }
}
