<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //un sujet fih plusieures objets
    public function Donations()
    {
        return $this->hasMany('App\Item');
    }
}
