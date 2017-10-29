<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string start
 * @property string end
 * @property int day_id
 * @property int user_id
 */
class Slot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start', 'end', 'user_id', 'day_id',
    ];


    /**
     * @return array
     */
    public function getPrettyHours() {
        return [
            substr($this->start, 0, -3),
            substr($this->end, 0, -3),
        ];
    }
}
