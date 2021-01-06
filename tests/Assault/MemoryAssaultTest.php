<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\Tests\Assault;

use Akondas\Runtime;
use Chaos\Monkey\Symfony\Assault\MemoryAssault;
use Chaos\Monkey\Symfony\Tests\MotherObject\SettingsMother;
use PHPUnit\Framework\TestCase;

class MemoryAssaultTest extends TestCase
{
    public function testMemoryAssault(): void
    {
        ini_set('memory_limit', '128M');
        $runtime = new Runtime();
        $targetFraction = 0.75;

        $assault = new MemoryAssault(SettingsMother::withMemoryActive($targetFraction));
        $assault->attack();

        $usedMemoryFraction = memory_get_usage(true) / $runtime->totalMemory();
        $delta = 0.01;

        self::assertGreaterThanOrEqual($targetFraction, $usedMemoryFraction);
        self::assertLessThanOrEqual($targetFraction + $delta, $usedMemoryFraction);
    }
}
