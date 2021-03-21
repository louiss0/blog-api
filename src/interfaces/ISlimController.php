<?php


namespace Src\Interfaces;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface ISlimController
{

    public  const GET_ALL = "getAll";
    public  const GET_ONE = "getOne";
    public  const CREATE_ONE = "createOne";
    public  const UPDATE_ONE = "updateOne";
    public  const DELETE_ONE = "deleteOne";

    public function getAll(Request $request,  Response $response);
    public function getOne(Response $response, int $id);
    public function createOne(Response $response);
    public function updateOne(Response $response, int $id);
    public function deleteOne(Response $response, int $id);
}
