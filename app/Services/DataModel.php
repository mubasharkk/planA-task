<?php

namespace App\Services;

class DataModel
{

    /** @var string  */
    private $template = __DIR__.'Templates/Model.tpl';

    /**
     * @var string[]
     */
    private array $scope;

    /** @var string */
    private string $name;

    /**
     * @param  string[]  $scope
     * @param  string    $name
     */
    public function __construct(
        array   $scope,
        string  $name,
        ?string $template = null
    ) {
        $this->scope = $scope;
        $this->name = $name;
        $this->template = $template ? __DIR__."Templates/{$template}.txt": $this->template;
    }

    private function prepareNamespace(array $scope)
    {

    }

    public function generate()
    {

    }
}