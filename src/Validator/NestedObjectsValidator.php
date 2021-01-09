<?php

namespace N7\SymfonyValidators\Validator;

use N7\SymfonyValidators\Helpers\ConstrainsExtractionTrait;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraints;

class NestedObjectsValidator extends ConstraintValidator
{
    use ConstrainsExtractionTrait;

    /**
     * @param mixed $value
     * @param NestedObjects $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (null === $value) {
            return;
        }

        $nestedConstrains = $this->extractConstrainsFromClass($constraint->class);

        $this->context
            ->getValidator()
            ->inContext($this->context)
            ->validate($value, new Constraints\All($nestedConstrains), $this->context->getGroup());
    }
}
