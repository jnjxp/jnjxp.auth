<?php

declare(strict_types=1);

namespace Jnjxp\Auth\Handle;

use Psr\Http\Message\ResponseFactoryInterface;

class NotAuthenticated extends RedirectHandler
{
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        parent::__construct($responseFactory, '/login');
    }
}
