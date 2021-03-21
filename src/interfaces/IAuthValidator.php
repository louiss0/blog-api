<?php


namespace Src\Interfaces;

use Psr\Http\Message\ServerRequestInterface;

interface IAuthValidator
{


    function validateEmailAndPassword(ServerRequestInterface $request): void;
    function validateEmail(ServerRequestInterface $request): void;

    function validateNameEmailAndPassword(ServerRequestInterface $request): void;

    function validatePasswordAndPasswordConfirm(ServerRequestInterface $request): void;

    function validatePasswordCurrentPasswordAndPasswordConfirm(ServerRequestInterface $request): void;
}
