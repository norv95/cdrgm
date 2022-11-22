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

        $id = isset($filters['id']) ? '/' . $filters['id'] : '';
        $filterString = implode('=', $filters);
        $postsContent = file_get_contents(
            self::URL . $id . '?' .  $filterString, false,
            context: stream_context_create($sslContext)
        );

        return $postsContent;
    }

    /**
     * Create post with posts API
     * @param string $content
     * @return false|string
     */
    public function createPostsData(string $content)
    {
        $context = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
            'http' => [
                'header'  => "Content-type: application/json",
                'method'  => 'POST',
                'content' => $content
            ]
        ];

        $postsContent = file_get_contents(
            self::URL, false,
            context: stream_context_create($context)
        );

        return $postsContent;
    }

    /**
     * Update post with posts API
     * @param int $id
     * @param string $content
     * @return false|string
     */
    public function updatePostsData(int $id, string $content)
    {
        $context = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
            'http' => [
                'header'  => "Content-type: application/json",
                'method'  => 'PUT',
                'content' => $content
            ]
        ];

        $postsContent = file_get_contents(
            self::URL . '/' . $id, false,
            context: stream_context_create($context)
        );

        return $postsContent;
    }

    /**
     * Delete post with posts API
     * @param int $id
     * @return false|string
     */
    public function deletePost(int $id)
    {
        $context = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
            'http' => [
                'header'  => "Content-type: application/json",
                'method'  => 'DELETE',
                'content' => ''
            ]
        ];

        $postsContent = file_get_contents(
            self::URL . '/' . $id, false,
            context: stream_context_create($context)
        );

        return $postsContent;
    }
}
