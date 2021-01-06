<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\Assault;

use Chaos\Monkey\Symfony\Assault;
use Chaos\Monkey\Symfony\Settings;

class ExceptionAssault implements Assault
{
    private Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function isActive(): bool
    {
        return $this->settings->exceptionActive();
    }

    public function attack(): void
    {
        $exceptionClass = $this->settings->exceptionClass();
        throw new $exceptionClass();
    }
}
