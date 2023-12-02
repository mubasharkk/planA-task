<?php

namespace Tests\Unit;

use App\Exceptions\InvalidModelParams;
use App\Exceptions\ModelAlreadyExist;
use App\Services\DataModelGenerator;
use PHPUnit\Framework\TestCase;

class DataModelTest extends TestCase
{

    const TEST_CLASS = __DIR__.'/../../app/Models/IndirectEmmissionsOwned/Electricity/MeetingRooms.php';

    public function testModelCreation()
    {
        $generator = new DataModelGenerator(
            ['indirect-emmissions-owned', 'electricity'],
            'meeting-rooms'
        );

        $generator->generate();

        $this->assertFileExists(self::TEST_CLASS);
    }

    public function testModelClassAlreadyExist()
    {
        $generator = new DataModelGenerator(
            ['indirect-emmissions-owned', 'electricity'],
            'meeting-rooms'
        );
        $generator->generate();

        $this->expectException(ModelAlreadyExist::class);

        // should throw an error on regeneration
        $generator->generate();
    }

    public function testInvalidNamespace()
    {
        $this->expectException(InvalidModelParams::class);
        $this->expectExceptionMessage(
            "Invalid namespace or class name `test.php`"
        );

        new DataModelGenerator(
            ['indirect-emmissions-owned', 'electricity', 'test.php'],
            'meeting-rooms'
        );
    }

    public function testInvalidClassname()
    {
        $this->expectException(InvalidModelParams::class);
        $this->expectExceptionMessage(
            "Invalid namespace or class name `123meeting-rooms`"
        );

        new DataModelGenerator(
            ['indirect-emmissions-owned', 'electricity'],
            '123meeting-rooms'
        );
    }

    protected function tearDown(): void
    {
        @unlink(self::TEST_CLASS);
    }
}