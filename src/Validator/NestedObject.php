<?php

namespace N7\SymfonyValidatorsBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NestedObject extends Constraint
{
    public string $class;

    public function getDefaultOption(): string
    {
        return 'class';
    }
}
