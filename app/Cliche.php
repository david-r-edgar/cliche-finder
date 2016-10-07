<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliche extends Model
{
    //
    protected $fillable = ['display_name', 'description'];


    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
}
