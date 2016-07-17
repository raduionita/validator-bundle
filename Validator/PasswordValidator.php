<?php

namespace Raducorp\ValidatorBundle\Validator;

use Raducorp\ValidatorBundle\Aware\RuleAwareInterface;
use Raducorp\ValidatorBundle\Aware\RuleAwareTrait;
use Raducorp\ValidatorBundle\Rule\AbstractRule;

/**
 * @todo Analyze: Should AbstractValidator + RuleAwareInterface become RuleAwareValidator!?
 * Class PasswordValidator
 * @package Raducorp\ValidatorBundle\Validator
 */
class PasswordValidator extends AbstractValidator implements RuleAwareInterface
{
    use RuleAwareTrait; // RuleAwareTrait::addRule()

    const ID = 'password.validator';

    /**
     * Validate password
     * {@inheritdoc}
     */
    public function validate($password)
    {
        // @todo Need a better reset
        $this->setMessages([]); // reset

        $output   = true;
        $fastfail = $this->getOption(AbstractValidator::FASTFAIL_OPTION);
        foreach ($this->getRules() as $rule) {
            /** @var AbstractRule $rule */
            $result = $rule->apply($password);
            if ($result === false) {
                $this->addMessage($rule->getError());
                if ($fastfail === true) {
                    return false;
                }
            }
            $output = $output && $result;
        }
        return $output;
    }
}
