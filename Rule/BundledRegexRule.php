<?php

namespace Raducorp\ValidatorBundle\Rule;

class BundledRegexRule extends AbstractRule
{
    /**
     * @var array
     */
    protected $regexes = [];

    /**
     * @return array
     */
    public function getRegexes()
    {
        return $this->regexes;
    }

    /**
     * @param array $regexes
     */
    public function setRegexes(array $regexes)
    {
        $this->regexes = $regexes;
    }

    /**
     * @param string $regex
     */
    public function addRegex($regex)
    {
        if (is_array($regex)) {
            $this->regexes = array_merge($regex, $this->regexes);
        } else {
            $this->regexes[] = $regex;
        }
    }
}