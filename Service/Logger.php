<?php

namespace App\Service;

class Logger
{
    public function log(string $message): void
    {
        //todo implement saving massage to log file or any other transport (ELK, RabbitMQ, etc)
        print_r($message);
    }
}
