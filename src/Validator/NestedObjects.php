<?php

declare(strict_types=1);

namespace N7\SymfonyValidatorsBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class NestedObjects extends Constraint
{
    public string $class;

    public function getDefaultOption(): string
    {
        return 'class';
    }
}
