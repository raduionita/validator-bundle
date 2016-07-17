<?php

namespace Raducorp\ValidatorBundle\Rule;

abstract class AbstractRule
{
    const REGEX_RULE   = 'regex';
    const CLASS_RULE   = 'class';
    const SERVICE_RULE = 'service';

    /**
     * @var string
     */
    protected $error = '';

    /**
     * @param string $error
     */
    public function setError($error)
    {
        if (!empty($error)) {
            $this->error = $error;
        }
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'rule';
    }

    /**
     * @param $what
     * @return bool
     */
    public abstract function apply($what);
}
