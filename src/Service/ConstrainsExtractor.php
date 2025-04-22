<?php

declare(strict_types=1);

namespace N7\SymfonyValidatorsBundle\Service;

use N7\SymfonyValidatorsBundle\Options\AllowExtraFields;
use N7\SymfonyValidatorsBundle\Options\AllowMissingFields;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\PropertyMetadataInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use ReflectionClass;
use ReflectionProperty;
use ReflectionAttribute;

final class ConstrainsExtractor
{
    private const VALIDATIOR_ALLOW_EXTRA_FIELDS = 'allowExtraFields';
    private const VALIDATIOR_ALLOW_MISSING_FIELDS = 'allowMissingFields';
    private const VALIDATIOR_FIELDS = 'fields';

    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function extract(string $class): Collection
    {
        $reflectionClass = new ReflectionClass($class);
        $meta = $this->validator->getMetadataFor($class);

        // Collecting constraints
        $constraints = array_map(
            fn (PropertyMetadataInterface $property): array => $property->getConstraints(),
            $meta->properties
        );
        foreach ($reflectionClass->getProperties() as $property) {
            $attributes = $property->getAttributes(Constraint::class, ReflectionAttribute::IS_INSTANCEOF);
            $attributes = array_map(fn (ReflectionAttribute $attribute) => $attribute->newInstance(), $attributes);

            if (!empty($attributes) || !isset($constraints[$property->getName()])) {
                $constraints[$property->getName()] = $attributes;
            }
        }

        $allowExtraFields = $reflectionClass->getAttributes(AllowExtraFields::class);
        $allowExtraFields = $allowExtraFields
            ? $allowExtraFields[0]->newInstance()
            : new AllowExtraFields(true);

        $allowMissingFields = $reflectionClass->getAttributes(AllowMissingFields::class);
        $allowMissingFields = $allowMissingFields
            ? $allowMissingFields[0]->newInstance()
            : new AllowMissingFields(false);

        return new Collection([
            self::VALIDATIOR_ALLOW_EXTRA_FIELDS => $allowExtraFields->getValue(),
            self::VALIDATIOR_ALLOW_MISSING_FIELDS => $allowMissingFields->getValue(),
            self::VALIDATIOR_FIELDS => $constraints,
        ]);
    }
}