<?php

namespace App\Http;

class RequestBuilder
{
    public static function build(array $serverInfo, $postInfo): Request
    {
        $method = $serverInfo['REQUEST_METHOD'];
        $url = preg_replace('/\?.*$/', '', $serverInfo['REQUEST_URI']);

        $params = explode(';', filter_var($serverInfo['QUERY_STRING'],FILTER_SANITIZE_SPECIAL_CHARS));
        $queryParams = [];
        foreach ($params as $param) {
            if (empty($param)) {
                continue;
            }
            list($key, $value) = explode('=', $param);
            if (!empty($key)) {
                $queryParams[$key] = $value;
            }
        }

        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';

        $body = [];
        if ($contentType == ContentType::FORM_ENCODED) {
            foreach ($postInfo as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($contentType == ContentType::JSON) {
            $body = json_decode(file_get_contents('php://input'),true);
        }

        return new Request($method, $url, $queryParams, $body, $contentType);
    }
}
