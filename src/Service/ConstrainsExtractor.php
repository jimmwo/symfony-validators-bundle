<?php

declare(strict_types=1);

namespace N7\SymfonyValidatorsBundle\Service;

use Symfony\Component\Validator\Mapping\PropertyMetadataInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ConstrainsExtractor
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function extract(string $class): Collection
    {
        // Extracting class metadata
        $meta = $this->validator->getMetadataFor($class);

        // Collecting constraints
        $constraints = array_map(
            fn (PropertyMetadataInterface $property): array => $property->getConstraints(),
            $meta->properties
        );

        return new Collection($constraints);
    }
}