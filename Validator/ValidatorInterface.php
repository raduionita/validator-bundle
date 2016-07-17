<?php

namespace Raducorp\ValidatorBundle\Validator;

interface ValidatorInterface
{
    /**
     * @param  $what
     * @return bool
     */
    public function validate($what);
}
