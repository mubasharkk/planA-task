<?php
namespace App\Models\IndirectEmissionsOwned\Gas;

use Illuminate\Database\Eloquent\Model;

class ConferenceRooms extends Model {

    const TABLE_NAME = 'conference_rooms';

    public function getTableName(): string {

        return self::TABLE_NAME;
    }
}