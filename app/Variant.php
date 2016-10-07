<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    //
    protected $fillable = ['natural', 'pat_lang', 'pattern'];

    public function cliche()
    {
        return $this->belongsTo(Cliche::class);
    }
}
