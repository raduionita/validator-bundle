<?php
/**
 * Created by PhpStorm.
 * User: radu
 * Date: 17.07.2016
 * Time: 16:45
 */

namespace Raducorp\ValidatorBundle\Validator;

/**
 * @todo Find an elegant solution for returning validation results from all sub-validators.
 * Validator composed out of multiple sub-validators
 * Class AbstractCompositeValidator
 * @package Raducorp\ValidatorBundle\Validator
 */
abstract class AbstractCompositeValidator extends AbstractValidator
{
    /**
     * @var AbstractValidator[]
     */
    private $validators;

    /**
     * @todo These should probably be moved to a trait
     * @param AbstractValidator $validator
     */
    public function addValidator(AbstractValidator $validator)
    {
        $this->validators[] = $validator;
    }

    /**
     * @return \Generator
     */
    public function getValidators()
    {
        foreach ($this->validators as $validator) {
            yield $validator;
        }
    }

    /**
     * @param  int $id
     * @return AbstractValidator
     */
    public function getValidator($id)
    {
        $id = intval($id);
        if ($id >= count($this->validators)) {
            throw new \OutOfBoundsException("You tried to get an unexisting validator!");
        }
        return $this->validators[$id];
    }
}
