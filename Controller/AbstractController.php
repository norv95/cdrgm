<?php
namespace App\Controller;

use App\Http\Response;

class AbstractController
{
    /**
     * Common method to make response object
     * @param string $postsBody
     * @param int $statusCode
     * @param int $contentType
     * @return Response
     */
    public function makeResponse(string $postsBody, int $statusCode, string $contentType, array $headers = [])
    {
        //todo implement setting headers to response
        return new Response($postsBody, $statusCode, $contentType);
    }
}
