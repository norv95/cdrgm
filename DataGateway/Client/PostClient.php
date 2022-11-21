<?php

namespace App\DataGateway\Client;

class PostClient
{
    const URL = 'https://jsonplaceholder.typicode.com/posts';

    public function getPostsData(array $filters)
    {
        $sslContext = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ]
        ];

        $filterString = implode('=', $filters);
        $postsContent = file_get_contents(
            self::URL . '?' .  $filterString, false,
            context: stream_context_create($sslContext)
        );

        return $postsContent;
    }
}
