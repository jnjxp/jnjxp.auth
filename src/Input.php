<?php

declare(strict_types=1);

namespace Jnjxp\Auth;

use Psr\Http\Message\ServerRequestInterface;
use Aura\Auth\Auth;

class Input
{
    public function __invoke(ServerRequestInterface $request) : array
    {
        return [
            $request->getAttribute(Auth::class),
            $request->getParsedBody()
        ];
    }
}
