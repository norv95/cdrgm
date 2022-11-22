<?php

namespace App\Service;

use App\DataGateway\PostGateway;
use App\Exception\InvalidRequestParamsException;
use App\Exception\RemoteApiException;
use App\Exception\ResourceNotFoundException;
use App\Http\StatusCode;
use App\Model\PostModel;
use App\Serializer\FormatType;
use App\Serializer\SerializerFactory;

/**
 * Class to perform business logic operations with posts
 */
class PostService
{
    public function __construct(
        private PostGateway $dataGateway,
        private ValidatorService $validator,
        private SerializerFactory $serializerFactory
    ) {
    }

    /**
     * Get list of posts
     * @param array $params
     * @return array
     */
    public function getPosts(array $params): array
    {
        return $posts = $this->dataGateway->getPosts($params);
    }

    /**
     * Get post by id
     * @param int $postId
     * @return PostModel
     */
    public function getPost(int $postId): PostModel
    {
        return $posts = $this->dataGateway->getPost($postId);
    }

    /**
     * Create post
     * @return void
     * @throws InvalidRequestParamsException
     */
    public function createPost(array $params): ?PostModel
    {
        $errors = $this->validator->validate($params, PostModel::class);
        if (count($errors) > 0) {
            throw new InvalidRequestParamsException(
                'Invalid request parameters' . print_r($errors, true),
                'Invalid request parameters' . print_r($errors, true),
                StatusCode::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        $json = $this->serializerFactory->create(FormatType::JSON)->serialize($params);
        $model = $this->serializerFactory->create(FormatType::JSON)
            ->deserialize($json, PostModel::class);
        $result = $this->dataGateway->createPost($model[0]);

        if (is_null($result)) {
            throw new RemoteApiException('Cannot create post with posts API');
        }
        return $result;
    }

    /**
     * Update post
     * @return void
     * @throws InvalidRequestParamsException
     */
    public function updatePost(int $id, array $params): ?PostModel
    {
        $errors = $this->validator->validate($params, PostModel::class);
        if (count($errors) > 0) {
            throw new InvalidRequestParamsException(
                'Invalid request parameters' . print_r($errors, true),
                'Invalid request parameters' . print_r($errors, true),
                StatusCode::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        $json = $this->serializerFactory->create(FormatType::JSON)->serialize($params);

        /** @var PostModel $model */
        $model = $this->serializerFactory->create(FormatType::JSON)
            ->deserialize($json, PostModel::class)[0];

        $originalModel = $this->dataGateway->getPost($id);
        if (empty($originalModel)) {
            throw new ResourceNotFoundException(
                'Post not found',
                'Post not found',
                StatusCode::HTTP_NOT_FOUND
            );
        }

        $reflectionClass = new \ReflectionClass(get_class($model));
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            if (empty($property->getValue($model))) {
                continue;
            }
            $property->setValue($originalModel, $property->getValue($model));
            $property->setAccessible(false);
        }
        $result = $this->dataGateway->updatePost($originalModel);

        if (is_null($result)) {
            throw new RemoteApiException('Cannot update post with posts API');
        }

        return $result;
    }

    /**
     * Delete post
     * @return void
     * @throws InvalidRequestParamsException
     */
    public function deletePost(int $id): array
    {
        $model = $this->dataGateway->getPost($id);

        if (empty($model)) {
            throw new ResourceNotFoundException(
                'Post not found',
                'Post not found',
                StatusCode::HTTP_NOT_FOUND
            );
        }

        $result = $this->dataGateway->deletePost($model);
        if (is_null($result)) {
            throw new RemoteApiException('Cannot delete post with posts API');
        }

        return [];
    }
}
