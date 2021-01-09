<?php

namespace N7\SymfonyValidators\Helpers;

use Phalcon\Di;
use Symfony\Component\Validator\Mapping\PropertyMetadataInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints;

trait ConstrainsExtractionTrait
{
    protected function extractConstrainsFromClass(string $class): Constraints\Collection
    {
        // Extracting class metadata
        $meta = $this->getValidator()->getMetadataFor($class);

        // Collecting constraints
        $constraints = array_map(
            fn (PropertyMetadataInterface $property): array => $property->getConstraints(),
            $meta->properties
        );

        return new Constraints\Collection($constraints);
    }

    private function getValidator(): ValidatorInterface
    {
        return Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
    }
}