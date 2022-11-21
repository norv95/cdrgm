<?php

namespace App\DataGateway;

use App\DataGateway\Client\PostClient;
use App\Model\PostModel;
use App\Serializer\FormatType;
use App\Serializer\SerializerFactory;

class PostGateway
{
    public function __construct(private PostClient $client, private SerializerFactory $serializerFactory)
    {
    }

    /**
     * Get posts as the list of PostModel items
     * @param array $params
     * @return array
     */
    public function getPosts(array $params) : array
    {
        $postsData = $this->client->getPostsData($params);
        $serializer = $this->serializerFactory->create(FormatType::JSON);
        return $serializer->deserialize($postsData, PostModel::class );
    }
}
