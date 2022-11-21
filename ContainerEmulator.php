<?php

namespace App;

use App\Exception\ServiceNotFoundException;
use App\Serializer\JsonSerializer;
use App\Serializer\SerializerFactory;
use App\Service\PostService;

/**
 * Emulator of Dependency Injection container
 */
class ContainerEmulator
{
    /**
     * Get service from container
     * @param string $className
     * @return mixed
     * @throws ServiceNotFoundException
     */
    public static function getService(string $className): object
    {
        $object = match ($className) {
            PostService::class => new $className(),
            JsonSerializer::class => new $className(),
            SerializerFactory::class => new $className(),
            'default' => null
        };

        if ($object == null) {
            throw new ServiceNotFoundException('Requested service {$className} not found');
        }

        return $object;
    }

}
