<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\Activator;

use Symfony\Component\HttpFoundation\Request;

final class QueryParamActivator
{
    public function __construct(private readonly bool $enabled = false, private readonly string $paramName = 'chaos')
    {
    }

    public function inChaos(Request $request): bool
    {
        if (!$this->enabled) {
            return true;
        }

        return $request->query->has($this->paramName);
    }
}
