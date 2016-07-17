<?php

namespace Raducorp\ValidatorBundle\Command;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Raducorp\ValidatorBundle\Validator\AbstractValidator;
use Raducorp\ValidatorBundle\Validator\PasswordValidator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PasswordValidatorValidateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('raducorp:password.valdator:validate')
            ->setDescription('Run validation service')
            ->addArgument('what', InputArgument::REQUIRED, 'What to validate? [string|db]?')
            ->addArgument('value', InputArgument::OPTIONAL, 'Password to validate or table of passwords.')
            //->addOption('force', null, InputOption::VALUE_NONE, 'Force db update...')
        ;
    }

    // raducorp:password.valdator:validate db [dbname]
    // raducorp:password.valdator:validate string [password]

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $what  = $input->getArgument('what');
        $value = $input->getArgument('value');

        // if ($input->getOption('option')) { }

        try {
            /** @var AbstractValidator $validator */
            $validator = $this->getContainer()->get(PasswordValidator::ID);
            switch ($what) {
                case 'db': // validate db
                    /** @var Connection $conn */
                    $table = empty($value) ? 'passwords' : $value;
                    $conn = $this->getContainer()->get('doctrine')->getManager()->getConnection();
                    // Not very secure, I know, but this is for testing purposes anyway...
                    $stmt = $conn->prepare("SELECT * FROM {$table}");
                    $stmt->execute();
                    $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                    foreach ($rows as $i => $row) {
                        $password = isset($row['password']) ? $row['password'] : null;
                        $result   = $validator->validate($password);
                        // just making sure I don't do any unnecessary updates :)
                        if (isset($row['valid']) && isset($row['id']) && $row['valid'] != $result) {
                            $stmt = $conn->prepare("UPDATE {$table} SET `valid` = ".($result ? 1 : 0)." WHERE `id` = {$row['id']}");
                            $stmt->execute();
                        }
                        $output->writeln($i .') '. $password .($result ? " [PASSED] " : " [FAILED] "). implode(" ", $validator->getMessages()));
                    }
                break;
                default:
                case 'string': // validate a single password
                    $password = $value;
                    // @todo space-separated passwords
                    //       $value = explode(' ', $value);
                    //       foreach($value as $password) {
                    $result = $validator->validate($password);
                    $output->writeln("Your password ($password) ". ($result ? "PASSED" : "FAILED") ." the validation!");
                    $result || $output->writeln(implode("\n", $validator->getMessages()));
                    // }
                break;
            }
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
        }
    }
}
