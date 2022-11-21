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

        /** @var SerializerFactory $serializerFactory */
        $serializerFactory = ContainerEmulator::getService(SerializerFactory::class);
        $serializer = $serializerFactory->create(FormatType::JSON);
        $postsBody = $serializer->serialize($posts);

        return $this->makeResponse($postsBody, StatusCode::HTTP_OK, ContentType::JSON_UTF);
    }
}
