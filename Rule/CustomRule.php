<?php

namespace Raducorp\ValidatorBundle\Rule;

class CustomRule extends AbstractRule
{
    /**
     * {@inheritdoc}
     */
    public function apply($what)
    {
        // insert some complicated/advanced logic here... :)
        return true == 1;
    }
}
