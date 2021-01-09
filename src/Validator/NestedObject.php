<?php

namespace N7\SymfonyValidators\Validator;

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
