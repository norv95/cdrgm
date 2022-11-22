<?php

namespace App\Controller;

use App\ContainerEmulator;
use App\Http\ContentType;
use App\Http\Request;
use App\Http\Response;
use App\Http\StatusCode;
use App\Route\ControllerPath;
use App\Route\Route;
use App\Serializer\FormatType;
use App\Serializer\SerializerFactory;
use App\Service\PostService;


#[ControllerPath('/posts')]
class PostController extends AbstractController
{
    /**
     * Getting list of posts
     * @param Request $request
     * @return Response
     * @throws \App\Exception\ServiceNotFoundException
     */
    #[Route('', ['GET'])]
    public function getPosts(Request $request)
    {
        $postsService = ContainerEmulator::getService(PostService::class);
        $posts = $postsService->getPosts($request->getQueryParams());

        $serializer = (ContainerEmulator::getService(SerializerFactory::class))->create(FormatType::JSON);

        return $this->makeResponse($posts, StatusCode::HTTP_OK, ContentType::JSON_UTF, $serializer);
    }

    /**
     * Getting list of posts
     * @param Request $request
     * @return Response
     * @throws \App\Exception\ServiceNotFoundException
     */
    #[Route('{id}', ['GET'])]
    public function getPost(Request $request)
    {
        $postsService = ContainerEmulator::getService(PostService::class);
        $urlParams = $request->getUrlParams();

        $post = $postsService->getPost($urlParams[0]);

        $serializer = (ContainerEmulator::getService(SerializerFactory::class))->create(FormatType::JSON);

        return $this->makeResponse($post, StatusCode::HTTP_OK, ContentType::JSON_UTF, $serializer);
    }

    /**
     * Create post entity
     * @param Request $request
     * @return Response
     * @throws \App\Exception\ServiceNotFoundException
     */
    #[Route('', ['POST'])]
    public function createPost(Request $request)
    {
        $postsService = ContainerEmulator::getService(PostService::class);
        $post = $postsService->createPost($request->getBody());

        $serializer = (ContainerEmulator::getService(SerializerFactory::class))->create(FormatType::JSON);

        return $this->makeResponse($post, StatusCode::HTTP_CREATED, ContentType::JSON_UTF, $serializer);
    }

    /**
     * Update post entity
     * @param Request $request
     * @return Response
     * @throws \App\Exception\ServiceNotFoundException
     */
    #[Route('{id}', ['PUT','PATCH'])]
    public function updatePost(Request $request)
    {
        /** @var PostService $postsService */
        $postsService = ContainerEmulator::getService(PostService::class);
        $urlParams = $request->getUrlParams();
        $post = $postsService->updatePost($urlParams[0], $request->getBody());

        $serializer = (ContainerEmulator::getService(SerializerFactory::class))->create(FormatType::JSON);

        return $this->makeResponse($post, StatusCode::HTTP_OK, ContentType::JSON_UTF, $serializer);
    }

    /**
     * Delete post entity
     * @param Request $request
     * @return Response
     * @throws \App\Exception\ServiceNotFoundException
     */
    #[Route('{id}', ['DELETE'])]
    public function deletePost(Request $request)
    {
        /** @var PostService $postsService */
        $postsService = ContainerEmulator::getService(PostService::class);
        $urlParams = $request->getUrlParams();
        $post = $postsService->deletePost($urlParams[0]);

        $serializer = (ContainerEmulator::getService(SerializerFactory::class))->create(FormatType::JSON);

        return $this->makeResponse($post, StatusCode::HTTP_OK, ContentType::JSON_UTF, $serializer);
    }
}
