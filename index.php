<?php

declare(strict_types=1);

//todo remove after the development is finished
ini_set('display_errors', 'true');
error_reporting(E_ALL);

spl_autoload_register(function($class) {
    $rootNamespace = 'App\\';

    $class_path = str_replace([$rootNamespace, '\\'], ['', '/'], $class);
    require $class_path . ".php";
});

$request = \App\Http\RequestBuilder::build($_SERVER, $_POST);

set_exception_handler(function (Throwable $exception) use ($request) {
    ExceptionHandler::handleException($exception, $request);
});

$router = new \App\Router(controllers: (new \App\Service\FilesService())->getNamespaceClasses('App\Controller'));

list($controllerClassName, $methodName) = $router->getRequestHandler($request);
if (!$controllerClassName || !$methodName) {
    throw new \App\Exception\RequestHandlerNotFoundException(message: "No controller found for the request");
}
$controller = new $controllerClassName();
/** @var \App\Http\Response $response */
$response = $controller->$methodName($request);

header('Content-type:' . $response->getContentType());
http_response_code($response->getCode());
echo $response->getBody();

