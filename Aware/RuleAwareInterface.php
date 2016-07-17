<?php

namespace Raducorp\ValidatorBundle\Aware;

use Raducorp\ValidatorBundle\Rule\AbstractRule;

interface RuleAwareInterface
{
    /**
     * @param AbstractRule $rule
     */
    public function addRule(AbstractRule $rule);

    /**
     * @return \Generator
     */
    public function getRules();

    /**
     * @param  int $id
     * @return AbstractRule
     */
    public function getRule($id);
}
