<?php

namespace App\Exceptions;

class ModelAlreadyExist extends \Exception
{
    public function __construct(string $modelClass) {
        parent::__construct("Class {$modelClass} already exist.");
    }
}