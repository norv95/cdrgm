<?php

namespace App\Exception;

class PublicException extends \Exception
{
    private string $publicMessage;

    /**
     * @param string $publicMessage
     */
    public function __construct(
        string $publicMessage,
        string $message,
        int $statusCode = 0,
        ?\Throwable $previous = null)
    {
        $this->publicMessage = $publicMessage;
        parent::__construct($message, $statusCode, $previous);
    }

    /**
     * @return string
     */
    public function getPublicMessage(): string
    {
        return $this->publicMessage;
    }

    /**
     * @param string $publicMessage
     */
    public function setPublicMessage(string $publicMessage): void
    {
        $this->publicMessage = $publicMessage;
    }

}
