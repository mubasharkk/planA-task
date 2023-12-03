<?php
namespace App\Models\CarbonFuel\Super;

use Illuminate\Database\Eloquent\Model;

class ConsumptionLevels extends Model {

    const TABLE_NAME = 'consumption_levels';

    public function getTableName(): string {

        return self::TABLE_NAME;
    }
}