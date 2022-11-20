<?php

namespace App\Service;

class FilesService
{
    public function getNamespaceClasses(string $namespace): array
    {
        $path = $this->namespaceToPath($namespace);

        $files = scandir($path);
        $files = array_filter($files, function ($file) {
            if (!str_contains($file, '.php')) {
                return false;
            }
            return true;
        });
        $classes = array_map(function($file) use ($namespace){
            return $namespace . '\\' . str_replace('.php', '', $file);
        }, $files);

        return($classes);
    }

    private function namespaceToPath(string $namespace)
    {
        //should be implemented logic for getting directory from namespace
        return __DIR__ . '/../Controller';
    }
}
