<?php

declare(strict_types=1);

namespace Jnjxp\Auth\Domain;

use Aura\Auth\Auth;
use Aura\Auth\Exception\PasswordIncorrect;
use Aura\Auth\Exception\PasswordMissing;
use Aura\Auth\Exception\UsernameMissing;
use Aura\Auth\Exception\UsernameNotFound;
use Aura\Auth\Service\LoginService;

class Login
{
    protected $login;

    public function __construct(LoginService $login)
    {
        $this->login = $login;
    }

    public function __invoke(Auth $auth, array $params) : void
    {
        try {
            $this->login->login($auth, $params);
        } catch (UsernameNotFound | UsernameMissing | PasswordMissing | PasswordIncorrect $e) {
        }
    }
}
