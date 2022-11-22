<?php
namespace App\Controller;

use App\ContainerEmulator;
use App\Http\Response;
use App\Serializer\FormatType;
use App\Serializer\SerializerDeserializerInterface;
use App\Serializer\SerializerFactory;

class AbstractController
{
    /**
     * Common method to make response object
     * @param string $responseData
     * @param int $statusCode
     * @param int $contentType
     * @return Response
     */
    public function makeResponse(
        object|array $responseData,
        int $statusCode,
        string $contentType,
        SerializerDeserializerInterface $serializer,
        array $headers = [],
    ) {
        $responseData = $serializer->serialize([
            'error' => '',
            'message' => '',
            'data' => $responseData
        ]);

        //todo implement setting headers to response
        return new Response($responseData, $statusCode, $contentType);
    }
}
