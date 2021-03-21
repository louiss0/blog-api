<?php



namespace Src\Routes;

use Slim\Routing\RouteCollectorProxy;
use Src\Controllers\AuthController;
use Src\Enums\Paths;

function auth_router(RouteCollectorProxy $group)
{
    # code...



    $group->post(
        Paths::SIGN_IN,
        [AuthController::class, AuthController::SIGN_IN]
    )->setName(Paths::SIGN_IN);
    $group->post(
        Paths::SIGN_UP,
        [AuthController::class, AuthController::SIGN_UP]
    )->setName(Paths::SIGN_UP);

    $group->post(
        Paths::FORGOT_PASSWORD,
        [AuthController::class, AuthController::FORGOT_PASSWORD]
    )->setName(Paths::FORGOT_PASSWORD);

    $group->patch(
        Paths::RESET_PASSWORD,
        [AuthController::class, AuthController::RESET_PASSWORD]
    )->setName(Paths::RESET_PASSWORD);

    $group->patch(
        Paths::UPDATE_MY_PASSWORD,
        [AuthController::class, AuthController::UPDATE_MY_PASSWORD]
    )->setName(Paths::UPDATE_MY_PASSWORD);
}
