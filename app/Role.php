<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //un role fih plusieures users admis famma barcha users avec le role admin et etc pour les autres roles
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
