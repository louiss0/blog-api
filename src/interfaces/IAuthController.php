<?php


namespace Src\Interfaces;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface IAuthController
{

    public const SIGN_UP = "signUp";
    public const SIGN_IN = "signIn";
    public const FORGOT_PASSWORD = "forgotPassword";
    public const RESET_PASSWORD = "resetPassword";
    public const UPDATE_MY_PASSWORD = "updateMyPassword";

    function signUp(Request $request, Response $response): Response;


    function signIn(Request $request, Response $response): Response;

    function forgotPassword(Request $request, Response $response): Response;

    function resetPassword(Request $request, Response $response): Response;

    function updateMyPassword(Request $request, Response $response): Response;
}
