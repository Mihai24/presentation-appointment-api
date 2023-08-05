<?php

declare(strict_types=1);

namespace App\Tests;

use ReflectionClass;
use ReflectionException;

trait PropertyAccessTrait
{
    /**
     * @throws ReflectionException
     */
    public function setProperty(object $entity, mixed $value, string $propertyName): void
    {
        $class = new ReflectionClass($entity);

        $property = $class->getProperty($propertyName);
        $property->setValue($entity, $value);
    }
}
