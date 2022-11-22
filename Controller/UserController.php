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
use App\Service\UserService;

#[ControllerPath('/users')]
class UserController extends AbstractController
{
    /**
     * Getting list of posts
     * @param Request $request
     * @return Response
     * @throws \App\Exception\ServiceNotFoundException
     */
    #[Route('', ['GET'])]
    public function getRegisteredUsers(Request $request)
    {
        /** @var UserService $usersService */
        $usersService = ContainerEmulator::getService(UserService::class);

        ['startDate' => $startDate, 'endDate' => $endDate] = $request->getFilteredQueryParams([
            'startDate' => \DateTimeImmutable::createFromFormat('d.m.Y', '01.01.2000')->format('d.m.Y'),
            'endDate' => (new \DateTimeImmutable())->format('d.m.Y')
        ]);

        $startDate = \DateTimeImmutable::createFromFormat('d.m.Y', $startDate);
        $endDate = \DateTimeImmutable::createFromFormat('d.m.Y', $endDate);

        $users = $usersService->getRegisteredUsers($startDate, $endDate);

        $serializer = (ContainerEmulator::getService(SerializerFactory::class))->create(FormatType::JSON);

        return $this->makeResponse($users, StatusCode::HTTP_OK, ContentType::JSON_UTF, $serializer);
    }

}
