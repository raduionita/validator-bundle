<?php

namespace Raducorp\ValidatorBundle\Tests\Validator;

use Raducorp\ValidatorBundle\Validator\PasswordValidator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PasswordValidatorTest extends KernelTestCase
{
    /**
     * @return array
     */
    public function dataProvider()
    {
        return [[
            "mybadpassword", false
        ], [
            "das1A&", true
        ]];
    }

    public function testIntegrity()
    {
        $this->assertTrue(true === true);
        $this->assertFalse(false === true);
    }

    public function testPasswordValidatorOptions()
    {
        $validator = new PasswordValidator();
        $options = ['opt0' => true, 'otp1' => 10, 'otp2' => 'something'];
        $validator->setOptions($options);
        foreach ($options as $option => $value) {
            $this->assertTrue($validator->getOption($option) === $value);
        }
    }

    public function testPasswordValidatorMessages()
    {
        $validator = new PasswordValidator();
        $messages = ["Message 0", "Message 1"];
        $validator->addMessage($messages[0]);
        $validator->addMessage($messages[1]);
        foreach ($validator->getMessages() as $i => $message) {
            $this->assertTrue($message === $messages[$i]);
        }
    }

    /**
     * @dataProvider dataProvider
     * @param string $password
     * @param bool   $expected
     */
    public function testPasswordValidatorValidate($password, $expected)
    {
        try {
            static::bootKernel([]);
            /** @var PasswordValidator $validator */
            $validator = static::$kernel->getContainer()->get(PasswordValidator::ID);
            $result = $validator->validate($password);
            $this->assertTrue($result === $expected);
        } catch (\Exception $e) {
            $this->assertFalse(true, $e->getMessage());
        }
    }
}
