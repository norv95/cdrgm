<?php

namespace App\Serializer;

use App\Exception\SerializationException;

class JsonSerializer extends AbstractSerializer implements SerializerDeserializerInterface
{
    /**
     * Create JSON from object|array
     * @param array|object $item
     * @return mixed
     * @throws SerializationException
     */
    public function serialize(array|object $item): mixed
    {
        if (is_array($item)) {
            $data = $this->convertArrayObjects($item);
        }

        if (is_object($item)) {
            $data = $this->ObjectToArray($item);
        }

        $serializedData = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );

        if (!$serializedData) {
            throw new SerializationException(
                'Cannot serialize to JSON format the following object' . print_r($data, true)
            );
        }
        return $serializedData;
    }

    /**
     * Deserialize JSON to object or array of objects
     * @param string $data
     * @param string $className
     * @return object|array
     */
    public function deserialize(string $data, string $className = ''): object|array
    {
        $items = json_decode($data, true);

        if (!isset($items[0])) {
            $items = [$items];
        }

        if (empty($className)) {
            return $items;
        }
        $deserialized = [];
        foreach ($items as $item) {
            $object = new $className();
            $this->setObjectProperties($object, $item);

            $deserialized[] = $object;
        }

        return $deserialized;
    }
}
