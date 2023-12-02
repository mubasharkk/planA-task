<?php

namespace Tests\Unit;

use App\Exceptions\InvalidModelParams;
use App\Exceptions\ModelAlreadyExist;
use App\Services\DataModel;
use PHPUnit\Framework\TestCase;

class DataModelTest extends TestCase
{
    public function testModelCreation()
    {
        $generator = new DataModel(
            ['indirect-emmissions-owned','electricity'],
            'meeting-rooms'
        );

        $generator->generate();

        $this->assertFileExists(__DIR__ . '/../../app/Models/IndirectEmmissionsOwned/Electricity/MeetingRooms.php');
    }

    public function testModelClassAlreadyExist()
    {
        $this->assertTrue(
            class_exists(\App\Models\IndirectEmmissionsOwned\Electricity\MeetingRooms::class)
        );

        $generator = new DataModel(
            ['indirect-emmissions-owned','electricity'],
            'meeting-rooms'
        );

        $this->expectException(ModelAlreadyExist::class);

        $generator->generate();
    }

    public function testInvalidNamespace()
    {
        $this->expectException(InvalidModelParams::class);
        $this->expectExceptionMessage("Invalid namespace or class name `test.php`");

        new DataModel(
            ['indirect-emmissions-owned','electricity', 'test.php'],
            'meeting-rooms'
        );
    }

    public function testInvalidClassname()
    {

        $this->expectException(InvalidModelParams::class);
        $this->expectExceptionMessage("Invalid namespace or class name `123meeting-rooms`");

        new DataModel(
            ['indirect-emmissions-owned','electricity'],
            '123meeting-rooms'
        );
    }
}