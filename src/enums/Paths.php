<?php

namespace Src\Enums;


interface  Paths
{

    public const API_VERSION = "/api/v1";
    public const USERS = "/users";
    public const SIGN_UP = "/sign-up";
    public const SIGN_IN = "/sign-in";
    public const FORGOT_PASSWORD = "/forgot-password";
    public const RESET_PASSWORD = "/reset-password/{token}";
    public const UPDATE_MY_PASSWORD = "/update-my-password";
}
