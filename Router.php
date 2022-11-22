<?php

namespace App;

use \App\Http\Request;
use App\Route\ControllerPath;
use App\Route\Route;

/**
 * Class that implements the logic of working with routes
 */
class Router
{
    public function __construct(array $controllers, private array $routes = [])
    {
        $this->registerControllerRoutes($controllers);
    }

    /**
     * Get controller and method by request data
     * @param Request $request
     * @return array|null[]
     */
    public function getRequestHandler(Request $request)
    {
        $searchPath = $request->getUrl();
        $searchPath = preg_replace('/\/[0-9]+($|\/)/', '/{id}', $searchPath);

        foreach ($this->routes as $route) {
            if (!in_array($request->getMethod(), $route['methods'])) {
                continue;
            }

            if (strcmp($route['path'], $searchPath) == 0) {
                return [$route['controller'], $route['method']];
            }
        }

        return [null, null];
    }

    /**
     * Collect information for routes from controllers and their methods attributes
     * @param array $controllers
     * @return void
     * @throws \ReflectionException
     */
    public function registerControllerRoutes(array $controllers)
    {
        foreach ($controllers as $controller) {

            $basePath = '';
            $reflectionController = new \ReflectionClass($controller);
            $controllerAttributes = $reflectionController->getAttributes(ControllerPath::class);

            foreach ($controllerAttributes as $controllerAttribute) {
                $path = $controllerAttribute->newInstance();
                $basePath = $path->path;
            }

            foreach ($reflectionController->getMethods() as $method) {

                $methodAttributes = $method->getAttributes(Route::class);

                foreach ($methodAttributes as $methodAttribute) {
                    $route = $methodAttribute->newInstance();

                    $this->routes[] = [
                        'path' => empty($basePath)
                            ? $route->path
                            : (empty($route->path) ? $basePath : $basePath . '/' . $route->path),
                        'methods' => $route->methods,
                        'controller' => $controller,
                        'method' => $method->getName()
                    ];
                }
            }
        }
    }
}
