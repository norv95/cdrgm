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

    /**
     * Get posts as the list of PostModel items
     * @param array $params
     * @return array
     */
    public function getPost(int $id) : ?PostModel
    {
        $params = ['id' => $id];
        $postData = $this->client->getPostsData($params);
        $serializer = $this->serializerFactory->create(FormatType::JSON);
        return $serializer->deserialize($postData, PostModel::class)[0];
    }

    /**
     * Create post using API methods
     * @param array $params
     * @return array
     */
    public function createPost(PostModel $model) : ?PostModel
    {
        $serializer = $this->serializerFactory->create(FormatType::JSON);
        $content = $serializer->serialize($model);
        $postData = $this->client->createPostsData($content);
        if (!$postData) {
            return null;
        }
        return $serializer->deserialize($postData, PostModel::class)[0];
    }

    /**
     * Update post using API methods
     * @param array $params
     * @return array
     */
    public function updatePost(PostModel $model) : ?PostModel
    {
        $serializer = $this->serializerFactory->create(FormatType::JSON);
        $content = $serializer->serialize($model);
        $postData = $this->client->updatePostsData($model->getId(), $content);
        if (!$postData) {
            return null;
        }
        return $serializer->deserialize($postData, PostModel::class)[0];
    }

    /**
     * Delete post using API methods
     * @param array $params
     * @return array
     */
    public function deletePost(PostModel $model) : ?PostModel
    {
        $serializer = $this->serializerFactory->create(FormatType::JSON);

        $postData = $this->client->deletePost($model->getId());
        if (!$postData) {
            return null;
        }
        return $serializer->deserialize($postData, PostModel::class)[0];
    }


}
