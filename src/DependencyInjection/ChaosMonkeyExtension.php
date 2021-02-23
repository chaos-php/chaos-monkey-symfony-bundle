<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class ChaosMonkeyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->setChaosMonkeySettings($container, $config);
        $this->enableWatchers($container, $config);
    }

    private function setChaosMonkeySettings(ContainerBuilder $container, array $config): void
    {
        $definition = $container->getDefinition('chaos_monkey.settings');
        $definition->addMethodCall('setEnabled', [$config['enabled']]);
        $definition->addMethodCall('setProbability', [$config['probability']]);

        $definition->addMethodCall('setLatencyActive', [$config['assaults']['latency']['active']]);
        $definition->addMethodCall('setLatencyMinMs', [$config['assaults']['latency']['minimum']]);
        $definition->addMethodCall('setLatencyMaxMs', [$config['assaults']['latency']['maximum']]);

        $definition->addMethodCall('setMemoryActive', [$config['assaults']['memory']['active']]);
        $definition->addMethodCall('setMemoryFillTargetFraction', [$config['assaults']['memory']['fill_fraction']]);

        $definition->addMethodCall('setExceptionActive', [$config['assaults']['exception']['active']]);
        $definition->addMethodCall('setExceptionClass', [$config['assaults']['exception']['class']]);

        $definition->addMethodCall('setKillAppActive', [$config['assaults']['kill_app']['active']]);
    }

    private function enableWatchers(ContainerBuilder $container, array $config): void
    {
        if ($config['watchers']['request']['enabled'] === true) {
            $requestWatcher = $container->getDefinition('chaos_monkey.watcher.request');
            $requestWatcher->addTag('kernel.event_listener', [
                'event' => 'kernel.request',
                'priority' => $config['watchers']['request']['priority'],
            ]);
        }
    }
}
