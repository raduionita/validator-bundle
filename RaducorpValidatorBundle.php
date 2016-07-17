<?php

namespace Raducorp\ValidatorBundle;

use Raducorp\ValidatorBundle\Compiler\CompilerRulePass;
use Raducorp\ValidatorBundle\DependencyInjection\RaducorpValidatorExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RaducorpValidatorBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        // @todo This is ugly, create a RaduCorpValidatorBundle schema!
        if ($this->extension === null) {
            $this->extension = new RaducorpValidatorExtension();
        }
        return $this->extension;
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CompilerRulePass());
    }
}
