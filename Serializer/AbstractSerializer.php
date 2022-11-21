<?php

namespace App\Serializer;

class AbstractSerializer
{
    protected function ObjectToArray(object $object): array
    {
        //todo implement properties filter logic based on object attributes
        $reflectionClass = new \ReflectionClass(get_class($object));
        $properties = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $properties[$property->getName()] = $property->getValue($object);
            $property->setAccessible(false);
        }
        return $properties;
    }
}
