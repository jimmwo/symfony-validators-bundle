<?php

declare(strict_types=1);

namespace N7\SymfonyValidatorsBundle\Validator;

use N7\SymfonyValidatorsBundle\Helpers\ConstrainsExtractionTrait;
use N7\SymfonyValidatorsBundle\Service\ConstrainsExtractor;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraints;

class NestedObjectsValidator extends ConstraintValidator
{
    private ConstrainsExtractor $extractor;

    public function __construct(ConstrainsExtractor $extractor)
    {
        $this->extractor = $extractor;
    }

    /**
     * @param mixed $value
     * @param NestedObjects $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (null === $value) {
            return;
        }

        $nestedConstrains = $this->extractor->extract($constraint->class);

        $this->context
            ->getValidator()
            ->inContext($this->context)
            ->validate($value, new Constraints\All($nestedConstrains), $this->context->getGroup());
    }
}
