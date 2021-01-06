<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\Assault;

use Chaos\Monkey\Symfony\Assault;
use Chaos\Monkey\Symfony\Settings;

class LatencyAssault implements Assault
{
    private Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function isActive(): bool
    {
        return $this->settings->latencyActive();
    }

    public function attack(): void
    {
        $latencyMs = random_int($this->settings->latencyMinMs(), $this->settings->latencyMaxMs());
        usleep($latencyMs * 1000);
    }
}
