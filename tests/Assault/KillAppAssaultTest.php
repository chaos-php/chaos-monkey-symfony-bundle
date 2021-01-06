<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\Tests\Assault;

use Chaos\Monkey\Symfony\Assault\KillAppAssault;
use Chaos\Monkey\Symfony\Tests\MotherObject\SettingsMother;
use PHPUnit\Framework\TestCase;

class KillAppAssaultTest extends TestCase
{
    public function testKillAppAssaultActive(): void
    {
        $assault = new KillAppAssault(SettingsMother::withKillAppActive());

        self::assertTrue($assault->isActive());
    }
}
