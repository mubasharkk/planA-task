<?php

namespace Tests\Unit;

use App\Exceptions\InvalidModelParams;
use PHPUnit\Framework\TestCase;
use TypeError;

class CSVModelServiceTest extends TestCase
{

    const MODEL_DIR = __DIR__.'/../../app/Models/';

    public function testModelGenerationFromCSVFile()
    {
        (new \App\Services\ModelsParserService())
            ->fromCSVFile(__DIR__.'/../../dataModels.csv')
            ->generate(true);

        $modelFiles = [
            'DirectEmissionsOwned/Electricity/CoffeeMachines.php',
            'IndirectEmissionsOwned/Gas/ConferenceRooms.php',
            'CarbonFuel/Super/ConsumptionLevels.php',
        ];

        foreach ($modelFiles as $file) {
            $this->assertFileExists(self::MODEL_DIR.$file);
        }
    }

    public function testModelGenerationFromArray()
    {
        (new \App\Services\ModelsParserService())
            ->fromData([
                ['name'  => 'charlie-chaplen', 'scope' => ['actors', 'comedy-films']],
                ['name'  => 'brad-pit', 'scope' => ['actors', 'action-films']],
                ['name'  => 'robin_williams', 'scope' => ['actors', 'comedy-films']],
                ['name'  => 'JacKSparrow', 'scope' => ['actors']],
            ])
            ->generate(false);

        spl_autoload_register(function (){

        });

        $this->assertFileExists(self::MODEL_DIR . 'Actors/ComedyFilms/CharlieChaplen.php');
        $this->assertFileExists(self::MODEL_DIR . 'Actors/ActionFilms/BradPit.php');
        $this->assertFileExists(self::MODEL_DIR . 'Actors/ComedyFilms/Robin_williams.php');
        $this->assertFileExists(self::MODEL_DIR . 'Actors/Jacksparrow.php');
    }

    public function testIncorrectClassnameData()
    {
        $this->expectException(InvalidModelParams::class);
        $this->expectExceptionMessage(
            "Invalid namespace or class name `123charlie-chaplen`"
        );

        (new \App\Services\ModelsParserService())
            ->fromData([
                ['name'  => '123charlie-chaplen', 'scope' => ['actors', 'comedy-films']],
            ])
            ->generate();
    }

    public function testIncorrectScope()
    {
        $this->expectException(TypeError::class);

        (new \App\Services\ModelsParserService())
            ->fromData([
                ['name'  => '123charlie-chaplen', 'scope' => 'actors'],
            ])
            ->generate();
    }

    /**
     * This can be avoided by mocking the generate function
     * I skipped it to have a real test result
     */
    protected function tearDown(): void
    {
        $this->rrmdir(__DIR__.'/../../app/Models');
    }

    /**
     * Source:
     * https://stackoverflow.com/questions/11613840/remove-all-files-folders-and-their-subfolders-with-php
     */
    private function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") {
                        $this->rrmdir($dir."/".$object);
                    } else {
                        unlink($dir."/".$object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}