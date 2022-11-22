<?php

namespace App\Service;

use App\DataGateway\MySQLGateway;
use App\DataGateway\PostGateway;

/**
 * Class to perform business logic operations with users
 */
class UserService
{
    public function __construct(private MySQLGateway $dataGateway)
    {
    }

    public function getRegisteredUsers(\DateTimeImmutable $startDate, \DateTimeImmutable $endDate): array
    {
        return $posts = $this->dataGateway->getUserRegistered($startDate, $endDate);
    }
}
