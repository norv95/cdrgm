<?php

namespace App\DataGateway;

use App\DataGateway\Client\GAClient;
use App\Model\GAItemModel;
use App\Model\PostModel;
use App\Serializer\FormatType;
use App\Serializer\SerializerFactory;

class GAGateway
{
    public function __construct(private GAClient $client, private SerializerFactory $serializerFactory)
    {
    }

    /**
     * Get posts as the list of PostModel items
     * @param array $params
     * @return array
     */
    public function getAnalytics(array $params) : ?array
    {
        $params = $this->buildParams($params);
        $params['authToken'] = $this->client->getAuthToken($params);
        $analyticsData = $this->client->getAnalytics($params);
        if (!$analyticsData) {
            return null;
        }

        $analyticsData = json_decode($analyticsData, true);
        $analyticsData = json_encode($analyticsData['data'], JSON_UNESCAPED_UNICODE);

        $serializer = $this->serializerFactory->create(FormatType::JSON);
        return $serializer->deserialize($analyticsData, GAItemModel::class );
    }

    /**
     * Format GA request filter parameters
     * @param array $params
     * @return array
     */
    private function buildParams(array $params): array
    {
        //todo implement request params formatting according to GA request conditions specification
        if (isset($params['startDate'])) {
            $params['startDate'] = $params['startDate']->format('d.m.Y H:i:s');
        }
        if (isset($params['endDate'])) {
            $params['endDate'] = $params['endDate']->format('d.m.Y H:i:s');
        }

        return $params;
    }
}
