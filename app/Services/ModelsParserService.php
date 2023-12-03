<?php

namespace App\Services;

class ModelsParserService
{

    /** @var \App\Services\DataModelGenerator[] */
    private array $modelClasses = [];

    public function fromCSVFile(
        string $filename,
        bool   $hasHeader = true
    ): self {
        $rows = array_map('str_getcsv', file($filename));
        $header = $hasHeader ? array_shift($rows) : ['scope', 'name'];
        $csv = [];
        foreach ($rows as $row) {
            $csv[] = [
                $header[0] => explode('|', $row[0]),
                $header[1] => $row[1],
            ];
        }

        return $this->fromData($csv);
    }

    public function fromData(array $data): self
    {
        $this->modelClasses = array_map(function ($data) {
            // An exception can be thrown here if there is problem with CSV data
            return new DataModelGenerator($data['scope'], $data['name']);
        }, $data);

        return $this;
    }

    public function generate(bool $log = true)
    {
        foreach ($this->modelClasses as $model) {
            if ($model->generate() && $log) {
                echo "Generated model {$model->getClassName()} successfully.\n";
            }
        }
    }
}