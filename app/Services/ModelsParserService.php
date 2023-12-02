<?php

namespace App\Services;

class ModelsParserService
{
    /** @var String */
    private $modelClasses;

    public function __construct(array $modelData)
    {
        $this->modelClasses = array_map(function ($data){
                return new DataModelGenerator($data['scope'], $data['string']);
        }, $modelData);
    }
}