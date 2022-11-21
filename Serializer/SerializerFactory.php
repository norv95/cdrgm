<?php

namespace App\Serializer;

class SerializerFactory
{
    public function create(int $formatType) : SerializerDeserializerInterface
    {
        $serializer = match ($formatType) {
            FormatType::JSON => new JsonSerializer()
        };

        return $serializer;
    }

}
