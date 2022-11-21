<?php

namespace App\Service;

use App\DataGateway\PostGateway;

/**
 * Class to perform business logic operations with posts
 */
class PostService
{
    public function __construct(private PostGateway $dataGateway)
    {
    }

    public function getPosts(array $params): array
    {
        return $posts = $this->dataGateway->getPosts($params);
    }
}
