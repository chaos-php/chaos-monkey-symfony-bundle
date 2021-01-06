<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\Tests\Assault;

use Chaos\Monkey\Symfony\Assault\ExceptionAssault;
use Chaos\Monkey\Symfony\Tests\MotherObject\SettingsMother;
use PHPUnit\Framework\TestCase;

class ExceptionAssaultTest extends TestCase
{
    public function testExceptionAssault(): void
    {
        $exceptionClass = \LogicException::class;

        $assault = new ExceptionAssault(SettingsMother::withExceptionActive($exceptionClass));

        self::expectException($exceptionClass);
        $assault->attack();
    }
}
