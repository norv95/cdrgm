<?php

namespace App\Http;

class Request
{
    public function __construct(
        private string $method,
        private string $url,
        private array $queryParams,
        private array $body,
        private string $contentType
    )
    {
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    public function getBody()
    {
        if (!in_array($this->method, ['POST','PUT','PATCH'])) {
            return '';
        }

        return $this->body;
    }

    public function getFilteredQueryParams(array $filteredParams)
    {
        $params = [];
        foreach ($filteredParams as $key => $param) {
            $params[$key] = $this->queryParams[$key] ?? $param;
        }

        return $params;
    }

    public function getUrlParams()
    {
        $matches = [];
        preg_match('/(?<=\/)[0-9]+($|(?=\/))/', $this->getUrl(), $matches);

        return $matches;
    }
}
