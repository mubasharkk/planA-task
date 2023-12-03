<?php
namespace App\Models\CarbonFuel\E32;

use Illuminate\Database\Eloquent\Model;

class OriginCountry extends Model {

    const TABLE_NAME = 'origin_country';

    public function getTableName(): string {

        return self::TABLE_NAME;
    }
}