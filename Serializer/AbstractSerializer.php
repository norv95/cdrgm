<?php

namespace App\Serializer;

class AbstractSerializer
{
    /**
     * Convert object to array considering property attributes
     * @param object $object
     * @return array
     */
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

    /**
     * Set object properties with provided array data
     * @param object $object
     * @param array $item
     * @return void
     */
    protected function setObjectProperties(object $object, array $item):void
    {
        $reflectionClass = new \ReflectionClass(get_class($object));
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            if (!in_array($property->getName(), $item)) {
                $property->setValue($object, $item[$property->getName()]);
            }
            $property->setAccessible(false);
        }
    }
}
