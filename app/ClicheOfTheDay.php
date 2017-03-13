<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClicheOfTheDay extends Model
{
    //
    protected $table = 'cliche_of_the_day';
    protected $fillable = ['cliche_id', 'date', 'note'];

    public function cliche()
    {
        return $this->belongsTo(Cliche::class);
    }
}
