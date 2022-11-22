<?php

namespace App\Model;

class PostModel
{
    /**
     * @param int $id
     * @param int $userId
     * @param string $title
     * @param string $body
     */
    public function __construct(
        private ?int $id = null,
        private ?int $userId = null,
        private ?string $title = null,
        private ?string $body = null
    ){
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

}
