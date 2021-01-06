<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\Tests\MotherObject;

use Chaos\Monkey\Symfony\Settings;

class SettingsMother
{
    public static function withActiveLatency(int $minMs, int $maxMs): Settings
    {
        $settings = new Settings();
        $settings->setLatencyActive(true);
        $settings->setLatencyMinMs($minMs);
        $settings->setLatencyMaxMs($maxMs);

        return $settings;
    }

    public static function withExceptionActive(string $exceptionClass): Settings
    {
        $settings = new Settings();
        $settings->setExceptionActive(true);
        $settings->setExceptionClass($exceptionClass);

        return $settings;
    }

    public static function withKillAppActive(): Settings
    {
        $settings = new Settings();
        $settings->setKillAppActive(true);

        return $settings;
    }

    public static function withMemoryActive(float $memoryFillTargetFraction): Settings
    {
        $settings = new Settings();
        $settings->setMemoryActive(true);
        $settings->setMemoryFillTargetFraction($memoryFillTargetFraction);

        return $settings;
    }
}
