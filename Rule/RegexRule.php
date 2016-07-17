<?php

namespace Raducorp\ValidatorBundle\Rule;

class RegexRule extends AbstractRule
{
    /**
     * @var string
     */
    protected $regex;

    /**
     * @return string
     */
    public function getRegex()
    {
        return $this->regex;
    }

    /**
     * @param string $regex
     */
    public function setRegex($regex)
    {
        $this->regex = $regex;
    }

    /**
     * @todo This method could possibly take other stuff besides strings
     * {@inheritdoc}
     */
    public function apply($what)
    {
        // I want this evaluation to stop as fast as possible, but...
        // @todo Implement string formating on the error message...%s...using captured sequences
        return !empty($this->regex) && is_string($what) && preg_match('/'.$this->regex.'/', $what) === 1;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->regex;
    }
}
