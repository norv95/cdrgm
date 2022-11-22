<?php

namespace App\Service;

use App\DataGateway\PostGateway;
use App\Model\PostModel;

/**
 * Class to perform validation operations
 */
class ValidatorService
{
    /**
     * Validate data params against class fields
     * @param array $data
     * @return void
     */
    public function validate(array $data, string $className ): array
    {
        $errors = [];
        //todo implement validation of data elements against properties from className
        return $errors;
    }
}
