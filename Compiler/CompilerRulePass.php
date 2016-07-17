<?php

namespace Raducorp\ValidatorBundle\Compiler;

use Raducorp\ValidatorBundle\Exception\NotImplementedException;
use Raducorp\ValidatorBundle\Rule\AbstractRule;
use Raducorp\ValidatorBundle\Rule\RegexRule;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class CompilerRulePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $config = $container->getParameter('raducorp.validator');

        foreach ($config as $validator => $settings) {
            $serviceid = $validator.'.validator';
            if ($container->hasDefinition($serviceid)) {
                $vdef = $container->getDefinition($serviceid);
                if (isset($settings['options'])) {
                    $vdef->addMethodCall('setOptions', [$settings['options']]);
                }
                if (isset($settings['rules'])) {
                    foreach ($settings['rules'] as $i => $data) {
                        $rule  = null;
                        $value = null;
                        $error = isset($data['error']) ? $data['error'] : null;

                        // @todo Move $allowed to a more configurable location
                        $allowed = [AbstractRule::REGEX_RULE, AbstractRule::CLASS_RULE, AbstractRule::SERVICE_RULE];
                        foreach ($allowed as $key) {
                            if (isset($data[$key])) {
                                $rule  = $key;
                                $value = $data[$key];
                            }
                        }

                        switch ($rule) {
                            case AbstractRule::REGEX_RULE:
                                $rdef = new Definition(RegexRule::class);
                                $rdef->addMethodCall('setRegex', [$value]);
                                $rdef->addMethodCall('setError', [$error]);
                                $rdef->setPublic(false);
                            break;
                            case AbstractRule::CLASS_RULE:
                                $rdef = new Definition($value);
                                $rdef->addMethodCall('setError', [$error]);
                            break;
                            default:
                            case AbstractRule::SERVICE_RULE:
                                // @todo need container
                                throw new NotImplementedException("Rule building using a service({$value}) not available, yet!");
                            break;
                        }

                        $container->setDefinition('password.rule.'.$rule, $rdef);

                        $vdef->addMethodCall('addRule', [$rdef]);
                    }
                }
            }
        }

    }
}
