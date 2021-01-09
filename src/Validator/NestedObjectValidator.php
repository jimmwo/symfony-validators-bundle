<?php

namespace N7\SymfonyValidators\Validator;

use DateTime;
use N7\SymfonyValidators\Helpers\ConstrainsExtractionTrait;
use Phalcon\Di;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Mapping\PropertyMetadataInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;
use Symfony\Component\Validator\Constraints;

class NestedObjectValidator extends ConstraintValidator
{
    use ConstrainsExtractionTrait;

    /**
     * @param mixed $value
     * @param NestedObject $constraint
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
            ->validate($value, $nestedConstrains, $this->context->getGroup());
    }
}
