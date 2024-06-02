<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\Tests\Activator;

use Chaos\Monkey\Symfony\Activator\QueryParamActivator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class QueryParamActivatorTest extends TestCase
{
    public function testItIsInChaosIfDisabled(): void
    {
        $activator = new QueryParamActivator();

        self::assertTrue($activator->inChaos(new Request()));
    }

    public function testItIsNoInChaosIfEnabledAndParamMissing(): void
    {
        $activator = new QueryParamActivator(true);

        self::assertFalse($activator->inChaos(new Request()));
    }

    public function testItIsInChaosIfEnabledAndParamExists(): void
    {
        $activator = new QueryParamActivator(true, 'bye');

        self::assertTrue($activator->inChaos(new Request(['bye' => true])));
    }
}
