<?php

namespace App\Http;

class RequestFactory
{
    public static function build(array $serverInfo, $postInfo): Request
    {
        $method = $serverInfo['REQUEST_METHOD'];
        $url = preg_replace('/\?.*$/', '', $serverInfo['REQUEST_URI']);

        $params = explode(';', filter_var($serverInfo['QUERY_STRING'],FILTER_SANITIZE_SPECIAL_CHARS));
        $queryParams = [];
        foreach ($params as $param) {
            list($key, $value) = explode('=', $param);
            $queryParams[$key] = $value;
        }

        $body = [];
        foreach ($postInfo as $key => $value) {
            $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';

        return new Request($method, $url, $queryParams, $body, $contentType);
    }
}
