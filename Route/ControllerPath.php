<?php

namespace App\Route;

#[\Attribute(\Attribute::TARGET_CLASS)]
class ControllerPath
{
    public function __construct(public string $path = '')
    {

    }
}
