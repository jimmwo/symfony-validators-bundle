<?php

namespace N7\SymfonyValidatorsBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NestedObjects extends Constraint
{
    public string $class;

    public function getDefaultOption(): string
    {
        return 'class';
    }
}
