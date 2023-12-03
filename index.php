<?php

require_once 'vendor/autoload.php';

try {
    (new \App\Services\ModelsParserService())
        ->fromCSVFile(__DIR__.'/dataModels.csv')
        ->generate();
} catch (\Exception $ex) {
    echo $ex->getMessage()."\n";
}


// test code
//echo (new \App\Models\CarbonFuel\E32\OriginCountry())->getTableName();