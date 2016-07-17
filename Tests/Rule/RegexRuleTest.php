<?php

namespace Raducorp\ValidatorBundle\Tests\Rule;

use Raducorp\ValidatorBundle\Rule\RegexRule;

class RegexRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            ['^(?:.){5,}$',     'hfshasfg',  true ],
            ['(?:\d)+',         'das',       false ],
            ['^(?!.*(.)\1{2})', 'A9gggda/-', false ],
        ];
    }

    public function testIntegrity()
    {
        $this->assertTrue(true === true);
        $this->assertFalse(false === true);
    }

    public function testRegexRuleRegex()
    {
        $regex = '^(?:.){5,}$';
        $rule = new RegexRule();
        $rule->setRegex($regex);
        $this->assertTrue($regex === $rule->getRegex());
    }

    public function testRegexRuleError()
    {
        $error = 'Your password failed!';
        $rule = new RegexRule();
        $rule->setError($error);
        $this->assertTrue($error === $rule->getError());
    }

    /**
     * @dataProvider dataProvider
     * @param string $regex
     * @param string $string
     * @param bool   $expected
     */
    public function testRegexRuleApply($regex, $string, $expected)
    {
        $rule = new RegexRule();
        $rule->setRegex($regex);
        $rule->setError('Rule failed!');
        $result = $rule->apply($string);
        $this->assertTrue($result === $expected);
    }
}
