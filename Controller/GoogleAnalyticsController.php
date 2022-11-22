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
use App\Service\GAService;

#[ControllerPath('/ganalytics')]
class GoogleAnalyticsController extends AbstractController
{
    /**
     * Getting list of posts
     * @param Request $request
     * @return Response
     * @throws \App\Exception\ServiceNotFoundException
     */
    #[Route('', ['GET'])]
    public function getGAnalytics(Request $request)
    {
        /** @var GAService $gaService */
        $gaService = ContainerEmulator::getService(GAService::class);

        ['startDate' => $startDate, 'endDate' => $endDate] = $request->getFilteredQueryParams([
            'startDate' => \DateTimeImmutable::createFromFormat('d.m.Y', '01.01.2000')->format('d.m.Y'),
            'endDate' => (new \DateTimeImmutable())->format('d.m.Y')
        ]);

        $params = [];
        $params['startDate'] = \DateTimeImmutable::createFromFormat('d.m.Y', $startDate);
        $params['endDate'] = \DateTimeImmutable::createFromFormat('d.m.Y', $endDate);

        $analyticsData = $gaService->getAnalytics($params);

        /** @var SerializerFactory $serializerFactory */
        $serializerFactory = ContainerEmulator::getService(SerializerFactory::class);
        $serializer = $serializerFactory->create(FormatType::JSON);

        return $this->makeResponse($analyticsData, StatusCode::HTTP_OK, ContentType::JSON_UTF, $serializer);
    }

}
