<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\Watcher;

use Chaos\Monkey\ChaosMonkey;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestWatcher
{
    private ChaosMonkey $chaosMonkey;

    public function __construct(ChaosMonkey $chaosMonkey)
    {
        $this->chaosMonkey = $chaosMonkey;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $this->chaosMonkey->call();
    }
}
