<?php

declare(strict_types=1);

namespace N7\SymfonyValidatorsBundle\Validator;

use Symfony\Component\Validator\Constraints\Optional as BaseOptional;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
final class Optional extends BaseOptional
{
}
