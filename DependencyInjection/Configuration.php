<?php

namespace Raducorp\ValidatorBundle\DependencyInjection;

use Raducorp\ValidatorBundle\Rule\AbstractRule;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Raducorp master config
     * raducorp:
     *     validator:
     *         password:
     *             options:
     *                 fastfail: true # validator will return false after the first failed rule
     *             strategies:
     *                 - { regex: "^(.){5,}$", error: "Password MUST be at least 5 characters long." }
     *                 - { class: "\Something\Something" }
     *                 - { service: "@something" }
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('raducorp')
            ->children()
                ->arrayNode('validator')
                    ->children()
                        ->arrayNode('password')
                            ->children()
                                ->arrayNode('options')
                                    ->children()
                                        ->scalarNode('fastfail')->defaultFalse()
                                        ->end()
                                    ->end()
                                ->end()
                                ->arrayNode('rules')
                                    ->requiresAtLeastOneElement()
                                    ->beforeNormalization()
                                        ->ifArray()
                                        ->then(function ($rules) {
                                            $output = [];
                                            // @todo Move $allowed to a more configurable location
                                            $allowed = [AbstractRule::REGEX_RULE, AbstractRule::CLASS_RULE, AbstractRule::SERVICE_RULE];
                                            foreach ($rules as $i => $rule) {
                                                foreach ($allowed as $key) {
                                                    if (isset($rule[$key])) {
                                                        $output[$i][$key] = $rule[$key];
                                                        if (isset($rule['error'])) {
                                                            $output[$i]['error'] = $rule['error'];
                                                        }
                                                        break;
                                                    }
                                                }
                                            }
                                            return $output;
                                        })
                                        ->end()
                                        ->prototype('array')
                                        ->children()
                                            ->scalarNode('regex')->cannotBeEmpty()->end()
                                            ->scalarNode('class')->cannotBeEmpty()->end()
                                            ->scalarNode('service')->cannotBeEmpty()->end()
                                            ->scalarNode('error')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
        return $treeBuilder;
    }
}
