<?php

declare(strict_types=1);

namespace N7\SymfonyValidatorsBundle\Service;

use Doctrine\Common\Annotations\Reader;
use N7\SymfonyValidatorsBundle\Options\AllowExtraFields;
use N7\SymfonyValidatorsBundle\Options\AllowMissingFields;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\PropertyMetadataInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ConstrainsExtractor
{
    private const VALIDATIOR_ALLOW_EXTRA_FIELDS = 'allowExtraFields';
    private const VALIDATIOR_ALLOW_MISSING_FIELDS = 'allowMissingFields';
    private const VALIDATIOR_FIELDS = 'fields';

    private ValidatorInterface $validator;
    private Reader $annotationsReader;

    public function __construct(ValidatorInterface $validator, Reader $reader)
    {
        $this->validator = $validator;
        $this->annotationsReader = $reader;
    }

    public function extract(string $class): Collection
    {
        /** @var ClassMetadata $meta */
        $meta = $this->validator->getMetadataFor($class);

        // Collecting constraints
        $constraints = array_map(
            fn (PropertyMetadataInterface $property): array => $property->getConstraints(),
            $meta->properties
        );

        return new Collection([
            self::VALIDATIOR_ALLOW_EXTRA_FIELDS => (bool) $this->getProperty($meta, AllowExtraFields::class),
            self::VALIDATIOR_ALLOW_MISSING_FIELDS => (bool) $this->getProperty($meta, AllowMissingFields::class),
            self::VALIDATIOR_FIELDS => $constraints,
        ]);
    }

    private function getProperty(ClassMetadata $meta, string $annotation)
    {
        return $this->annotationsReader->getClassAnnotation($meta->getReflectionClass(), $annotation);
    }
}