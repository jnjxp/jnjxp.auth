<?php

declare(strict_types=1);

namespace Jnjxp\Auth;

use Psr\Container\NotFoundExceptionInterface;

class ServiceNotFoundException extends \Exception implements NotFoundExceptionInterface
{
}
