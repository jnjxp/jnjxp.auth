<?php

declare(strict_types=1);

namespace Jnjxp\Auth\Domain;

use Aura\Auth\Auth;
use Aura\Auth\Service\LogoutService;

class Logout
{
    protected $logout;

    public function __construct(LogoutService $logout)
    {
        $this->logout = $logout;
    }

    public function __invoke(Auth $auth, array $params) : void
    {
        $this->logout->logout($auth, $params);
    }
}
