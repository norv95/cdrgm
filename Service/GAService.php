<?php

namespace App\Service;

use App\DataGateway\GAGateway;
use App\Serializer\SerializerFactory;

/**
 * Class to perform business logic operations with Google Analytics API
 */
class GAService
{
    public function __construct(
        private GAGateway $dataGateway
    ) {
    }

    /**
     * Get analytics data from Google Analytics API
     * @param array $params
     * @return array
     */
    public function getAnalytics(array $params): array
    {
        $params = $this->setRequestParams($params);
        $analyticsData = $this->dataGateway->getAnalytics($params);

        return $analyticsData;
    }

    private function setRequestParams(array $params)
    {
        //todo implement logic for preparing request conditions to GA
        return $params;
    }

}
