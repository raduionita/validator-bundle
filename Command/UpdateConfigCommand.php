<?php

namespace Raducorp\ValidatorBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateConfigCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('raducorp:validator:update.config')
            ->setDescription('Run validator bundle config update. Try to append default settings into config.yml.')
        ;
    }

    // @todo See composer.json scripts.post-install-cmd, and insert...
    //       app/console raducorp:validator:config:update

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configpath = $this->getContainer()->get('kernel')->getRootDir() .'/config/config.yml';
        echo file_get_contents($configpath);
    }
}

