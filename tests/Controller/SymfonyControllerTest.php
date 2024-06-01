<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\Tests\Controller;

use Chaos\Monkey\Settings;
use Chaos\Monkey\Symfony\ChaosMonkeyBundle;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Stopwatch\Stopwatch;

class SymfonyControllerTest extends TestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = new KernelBrowser($kernel = new SymfonyControllerKernel('test', false));
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

class SymfonyControllerKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new ChaosMonkeyBundle(),
        ];
    }

    protected function configureContainer(ContainerConfigurator $c): void
    {
        $c->extension('framework', [
            'secret' => 'S0ME_SECRET',
        ]);

        $c->services()->set('logger', NullLogger::class);
    }

    protected function configureRoutes(RoutingConfigurator $routes)
    {
        $routes->add('home', '/hello')->controller([$this, 'hello']);
    }

    public function hello(): Response
    {
        return new Response('Hello world');
    }
}
