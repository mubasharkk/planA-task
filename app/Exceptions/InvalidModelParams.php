<?php

namespace App\Exceptions;

class InvalidModelParams extends \Exception
{

    public function __construct($paramName)
    {
        parent::__construct("Invalid namespace or class name `{$paramName}`");
    }
}