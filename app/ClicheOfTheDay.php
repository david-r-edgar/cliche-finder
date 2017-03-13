<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClicheOfTheDay extends Model
{
    //
    protected $fillable = ['cliche_id', 'date', 'note'];

    public function cliche()
    {
        return $this->belongsTo(Cliche::class);
    }
}
