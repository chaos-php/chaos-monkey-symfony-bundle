<?php

declare(strict_types=1);

namespace Chaos\Monkey\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('chaos_monkey');

        $treeBuilder->getRootNode()
        ->children()
            ->booleanNode('enabled')->defaultFalse()->end()
            ->integerNode('probability')
                ->min(0)
                ->max(100)
                ->defaultValue(20)
            ->end()
            ->arrayNode('assaults')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('latency')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->booleanNode('active')->defaultFalse()->end()
                            ->integerNode('minimum')->min(0)->defaultValue(1000)->end()
                            ->integerNode('maximum')->min(1)->defaultValue(3000)->end()
                        ->end()
                    ->end()
                    ->arrayNode('memory')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->booleanNode('active')->defaultFalse()->end()
                            ->floatNode('fill_fraction')->min(0.01)->max(1.00)->defaultValue(0.95)->end()
                        ->end()
                    ->end()
                    ->arrayNode('exception')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->booleanNode('active')->defaultFalse()->end()
                            ->scalarNode('class')->defaultValue(\RuntimeException::class)->end()
                        ->end()
                    ->end()
                    ->arrayNode('kill_app')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->booleanNode('active')->defaultFalse()->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('watchers')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('request')
                        ->canBeDisabled()
                        ->children()
                            ->integerNode('priority')->defaultValue(0)->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
