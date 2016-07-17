<?php

namespace Raducorp\ValidatorBundle\Validator;

/**
 * Class AbstractValidator
 * @package Raducorp\ValidatorBundle\Validator
 */
abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * @todo Maybe I should move this to a Constants class, or somewhere more easier to access.
     */
    const FASTFAIL_OPTION = 'fastfail';

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var string[]
     */
    protected $messages = [];

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @param  string $option
     * @return mixed
     */
    public function getOption($option)
    {
        return $this->options[$option];
    }

    /**
     * @param array $messages
     */
    public function setMessages(array $messages)
    {
        $this->messages = $messages;
    }

    /**
     * @param string $message
     */
    public function addMessage($message)
    {
        $this->messages[] = $message;
    }

    /**
     * @return string[]
     */
    public function getMessages()
    {
        return $this->messages;
    }
}
