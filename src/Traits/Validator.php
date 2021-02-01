<?php

namespace App\Traits;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait Validator
{
    /**
     * Get symfony validator.
     *
     * @return RecursiveValidator|ValidatorInterface
     */
    private function getValidator()
    {
        return Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();
    }

}