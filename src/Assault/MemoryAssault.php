<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\Assault;

use Akondas\Runtime;
use Chaos\Monkey\Symfony\Assault;
use Chaos\Monkey\Symfony\Settings;

class MemoryAssault implements Assault
{
    private Settings $settings;
    private int $totalMemory;

    /**
     * @var mixed[]
     */
    private array $memoryVector;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
        $this->totalMemory = (new Runtime())->totalMemory();
    }

    public function isActive(): bool
    {
        return $this->settings->memoryActive();
    }

    public function attack(): void
    {
        while ($this->fillFraction() < $this->settings->memoryFillTargetFraction()) {
            $this->memoryVector[] = $this->getOneMegabyte();
        }
    }

    private function fillFraction(): float
    {
        return memory_get_usage(true) / $this->totalMemory;
    }

    /**
     * @return int[]
     */
    private function getOneMegabyte(): array
    {
        $data = [];
        for ($i = 0; $i < 16385; ++$i) {
            $data[] = $i;
        }

        return $data;
    }
}
