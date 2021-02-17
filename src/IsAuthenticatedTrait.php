<?php

declare(strict_types=1);

namespace Jnjxp\Auth;

use Psr\Http\Message\ServerRequestInterface;
use Aura\Auth\Auth;

trait IsAuthenticatedTrait
{
    protected function isAuthenticated(ServerRequestInterface $request) : bool
    {
        $auth = $request->getAttribute(Auth::class);
        if (! $auth) {
            throw new \Exception('Auth not avilable!');
        }
        return $auth->isValid();
    }
}
