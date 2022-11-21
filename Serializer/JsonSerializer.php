<?php

namespace App\Serializer;

use App\Exception\SerializationException;

class JsonSerializer extends AbstractSerializer implements SerializerDeserializerInterface
{
    public function serialize(array|object $item): mixed
    {
        print_r($item);
        $data = is_array($item) ? $item : $this->ObjectToArray($item);
        $serializedData = json_encode($data, JSON_UNESCAPED_UNICODE);

        if (!$serializedData) {
            throw new SerializationException(
                'Cannot serialize to JSON format the following object' . print_r($data, true)
            );
        }
        return $serializedData;
    }

    public function deserialize(mixed $item): object|array
    {
        // TODO: Implement deserialize() method.
        return [];
    }
}
