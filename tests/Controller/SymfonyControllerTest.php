<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\Tests\Controller;

use Chaos\Monkey\Settings;
use Chaos\Monkey\Symfony\Tests\Symfony\Kernel;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Stopwatch\Stopwatch;

class SymfonyControllerTest extends TestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = new KernelBrowser($kernel = new Kernel('test', true));
        $this->client->disableReboot();
        $kernel->boot();
    }

    public function testRequestLatencyAttack(): void
    {
        $stopwatch = new Stopwatch();

        $stopwatch->start('latency-disable');
        $this->client->request('GET', '/hello');
        $stopwatch->stop('latency-disable');

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertLessThan(100, $stopwatch->getEvent('latency-disable')->getDuration());

        $this->enableLatencyAssault();

        $stopwatch->start('latency-enabled');
        $this->client->request('GET', '/hello');
        $stopwatch->stop('latency-enabled');

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertGreaterThan(1000, $stopwatch->getEvent('latency-enabled')->getDuration());

        $this->disableLatencyAssault();
    }

    public function testRequestExceptionAttack(): void
    {
        $this->enableExceptionAssault();
        $this->client->request('GET', '/hello');

        self::assertEquals(500, $this->client->getResponse()->getStatusCode());

        $this->disableExceptionAssault();
    }

    private function enableExceptionAssault(): void
    {
        $this->chaosMonkeySettings()->setEnabled(true);
        $this->chaosMonkeySettings()->setExceptionActive(true);
        $this->chaosMonkeySettings()->setProbability(100);
    }

    private function disableExceptionAssault(): void
    {
        $this->chaosMonkeySettings()->setEnabled(false);
        $this->chaosMonkeySettings()->setExceptionActive(false);
    }

    private function enableLatencyAssault(): void
    {
        $this->chaosMonkeySettings()->setEnabled(true);
        $this->chaosMonkeySettings()->setLatencyActive(true);
        $this->chaosMonkeySettings()->setProbability(100);
    }

    private function disableLatencyAssault(): void
    {
        $this->chaosMonkeySettings()->setEnabled(false);
        $this->chaosMonkeySettings()->setLatencyActive(false);
    }

    private function chaosMonkeySettings(): Settings
    {
        return $this->client->getContainer()->get('chaos_monkey')->settings();
    }
}
