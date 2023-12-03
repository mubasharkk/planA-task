<?php
namespace App\Models\DirectEmissionsOwned\Electricity;

use Illuminate\Database\Eloquent\Model;

class CoffeeMachines extends Model {

    const TABLE_NAME = 'coffee_machines';

    public function getTableName(): string {

        return self::TABLE_NAME;
    }
}