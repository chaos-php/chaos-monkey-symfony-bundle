<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\Assault;

use Chaos\Monkey\Symfony\Assault;
use Chaos\Monkey\Symfony\Settings;

class KillAppAssault implements Assault
{
    private Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function isActive(): bool
    {
        return $this->settings->killAppActive();
    }

    public function attack(): void
    {
        // cheers :D
        exit();
    }
}
