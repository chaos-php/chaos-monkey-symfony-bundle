<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\Watcher;

use Chaos\Monkey\ChaosMonkey;
use Chaos\Monkey\Symfony\Activator\QueryParamActivator;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class RequestWatcher
{
    public function __construct(
        private readonly ChaosMonkey $chaosMonkey,
        private readonly QueryParamActivator $queryParamActivator
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        if ($this->queryParamActivator->inChaos($event->getRequest())) {
            $this->chaosMonkey->call();
        }
    }
}
