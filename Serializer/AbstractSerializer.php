<?php

namespace App\Serializer;

use App\Model\AddressModel;

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
            if (is_object($property->getValue($object))) {
                switch (get_class($property->getValue($object))) {
                    case \DateTimeImmutable::class:
                        $properties[$property->getName()] = $property->getValue($object)->format('d.m.Y H:s');
                        break;
                    default:
                        $properties[$property->getName()] = $this->ObjectToArray($property->getValue($object));
                }
            } else {
                $properties[$property->getName()] = $property->getValue($object);
            }

            $property->setAccessible(false);
        }
        return $properties;
    }

    /**
     * Converting of all nested objects in array to array elements
     * @param array $items
     * @return array
     */
    protected function convertArrayObjects(array $items)
    {
        foreach ($items as $key => $item) {
            if (is_object($item)) {
                $items[$key] = $this->ObjectToArray($item);
            }
            if (is_array($item)) {
                $items[$key] = $this->convertArrayObjects($item);
            }
        }

        return $items;
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

            if (!in_array($property->getName(), array_keys($item))) {
                continue;
            }

            if (!$property->getType()->isBuiltin()) {

                $className = $property->getType()->getName();
                switch ($property->getType()->getName()) {
                    case \DateTimeImmutable::class:
                        $value = \DateTimeImmutable::createFromFormat('d.m.Y H:i', $item[$property->getName()]);
                        $property->setValue($object, $value);
                        break;
                    default:
                        $propertyObject = new $className();
                        $this->setObjectProperties($propertyObject, $item[$property->getName()]);
                        $property->setValue($object, $propertyObject);
                        break;
                }
            } else {
                $property->setValue($object, $item[$property->getName()]);
            }

            $property->setAccessible(false);
        }
    }
}
