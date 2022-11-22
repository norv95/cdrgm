<?php

namespace App;

use App\DataGateway\Client\GAClient;
use App\DataGateway\Client\MySQLDBClient;
use App\DataGateway\Client\PostClient;
use App\DataGateway\GAGateway;
use App\DataGateway\MySQLGateway;
use App\DataGateway\PostGateway;
use App\Exception\ServiceNotFoundException;
use App\Serializer\JsonSerializer;
use App\Serializer\SerializerFactory;
use App\Service\GAService;
use App\Service\Logger;
use App\Service\PostService;
use App\Service\UserService;
use App\Service\ValidatorService;

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
            PostService::class => new $className(
                self::getService(PostGateway::class),
                self::getService(ValidatorService::class),
                self::getService(SerializerFactory::class)
            ),
            UserService::class => new $className(self::getService(MySQLGateway::class)),
            GAService::class => new $className(
                self::getService(GAGateway::class)
            ),

            JsonSerializer::class => new $className(),
            SerializerFactory::class => new $className(),
            PostClient::class => new $className(),
            GAClient::class => new $className(),
            MySQLDBClient::class => new $className(),
            PostGateway::class => new $className(
                self::getService(PostClient::class),
                self::getService(SerializerFactory::class)
            ),
            MySQLGateway::class => new $className(
                self::getService(MySQLDBClient::class),
                self::getService(SerializerFactory::class)
            ),
            GAGateway::class => new $className(
                self::getService(GAClient::class),
                self::getService(SerializerFactory::class)
            ),
            ValidatorService::class => new $className(),

            Logger::class => new Logger(),
            default => null
        };

        if ($object == null) {
            throw new ServiceNotFoundException("Requested service {$className} not found");
        }

        return $object;
    }

}
