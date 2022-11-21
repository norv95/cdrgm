<?php

namespace App;

use App\DataGateway\Client\PostClient;
use App\DataGateway\PostGateway;
use App\Exception\ServiceNotFoundException;
use App\Serializer\JsonSerializer;
use App\Serializer\SerializerFactory;
use App\Service\Logger;
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
            PostService::class => new $className(self::getService(PostGateway::class),),
            JsonSerializer::class => new $className(),
            SerializerFactory::class => new $className(),
            PostClient::class => new $className(),
            PostGateway::class => new $className(
                self::getService(PostClient::class),
                self::getService(SerializerFactory::class)
            ),
            Logger::class => new Logger(),
            default => null
        };

        if ($object == null) {
            throw new ServiceNotFoundException('Requested service {$className} not found');
        }

        return $object;
    }

}
