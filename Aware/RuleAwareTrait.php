<?php

namespace Raducorp\ValidatorBundle\Aware;

use Raducorp\ValidatorBundle\Rule\AbstractRule;

trait RuleAwareTrait
{
    /**
     * @var AbstractRule[]
     */
    private $rules = [];

    /**
     * @param AbstractRule $rule
     */
    public function addRule(AbstractRule $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * @return \Generator
     */
    public function getRules()
    {
        foreach ($this->rules as $rule) {
            // Not necessary...I know, but what's coding w/o a little fun!?
            yield $rule;
        }
    }

    /**
     * @param  int $id
     * @return AbstractRule
     */
    public function getRule($id)
    {
        // just in case sameone tries to pass in apples
        $id = intval($id);
        // just in case someone tries to get the service infinity+1
        if ($id >= count($this->rules)) {
            throw new \OutOfBoundsException("You tried to get an unexisting rule!");
        }
        return $this->rules[$id];
    }
}
