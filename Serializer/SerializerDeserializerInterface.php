<?php

namespace App\Serializer;

interface SerializerDeserializerInterface
{
    public function serialize(array|object $item): mixed;
    public function deserialize(string $data, string $className): array|object;
}
