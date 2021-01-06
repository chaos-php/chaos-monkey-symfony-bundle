<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony;

class Settings
{
    private bool $enabled;
    private int $probability;

    private bool $latencyActive;
    private int $latencyMinMs;
    private int $latencyMaxMs;

    private bool $exceptionActive;
    private string $exceptionClass;

    private bool $killAppActive;

    private bool $memoryActive;
    private float $memoryFillTargetFraction;

    public function __construct()
    {
        $this->enabled = false;
        $this->probability = 20;
        $this->latencyActive = false;
        $this->latencyMinMs = 1000;
        $this->latencyMaxMs = 3000;
        $this->exceptionActive = false;
        $this->exceptionClass = \RuntimeException::class;
        $this->killAppActive = false;
        $this->memoryActive = false;
        $this->memoryFillTargetFraction = 0.95;
    }

    public function setLatencyActive(bool $latencyActive): void
    {
        $this->latencyActive = $latencyActive;
    }

    public function setLatencyMinMs(int $latencyMinMs): void
    {
        if ($latencyMinMs <= 0 || $latencyMinMs > $this->latencyMaxMs) {
            throw new \InvalidArgumentException('Minimum latency must be greater than zero and below maximum latency');
        }

        $this->latencyMinMs = $latencyMinMs;
    }

    public function setLatencyMaxMs(int $latencyMaxMs): void
    {
        if ($this->latencyMinMs > $latencyMaxMs) {
            throw new \InvalidArgumentException('Maximum latency must be greater than minimum latency');
        }

        $this->latencyMaxMs = $latencyMaxMs;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function setProbability(int $probability): void
    {
        if ($probability > 100 || $probability < 0) {
            throw new \InvalidArgumentException('Probability must be between 100 and 0');
        }
        $this->probability = $probability;
    }

    public function setExceptionActive(bool $exceptionActive): void
    {
        $this->exceptionActive = $exceptionActive;
    }

    public function setExceptionClass(string $exceptionClass): void
    {
        $this->exceptionClass = $exceptionClass;
    }

    public function setKillAppActive(bool $killAppActive): void
    {
        $this->killAppActive = $killAppActive;
    }

    public function setMemoryActive(bool $memoryActive): void
    {
        $this->memoryActive = $memoryActive;
    }

    public function setMemoryFillTargetFraction(float $memoryFillTargetFraction): void
    {
        $this->memoryFillTargetFraction = $memoryFillTargetFraction;
    }

    public function enabled(): bool
    {
        return $this->enabled;
    }

    public function probability(): int
    {
        return $this->probability;
    }

    public function latencyActive(): bool
    {
        return $this->latencyActive;
    }

    public function latencyMinMs(): int
    {
        return $this->latencyMinMs;
    }

    public function latencyMaxMs(): int
    {
        return $this->latencyMaxMs;
    }

    public function exceptionActive(): bool
    {
        return $this->exceptionActive;
    }

    public function exceptionClass(): string
    {
        return $this->exceptionClass;
    }

    public function killAppActive(): bool
    {
        return $this->killAppActive;
    }

    public function memoryActive(): bool
    {
        return $this->memoryActive;
    }

    public function memoryFillTargetFraction(): float
    {
        return $this->memoryFillTargetFraction;
    }
}
