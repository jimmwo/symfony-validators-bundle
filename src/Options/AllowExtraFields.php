<?php

declare(strict_types=1);

namespace N7\SymfonyValidatorsBundle\Options;

#[\Attribute]
final class AllowExtraFields
{
    public function __construct(private bool $value = true) {}

    public function getValue(): bool
    {
        return $this->value;
    }
}
