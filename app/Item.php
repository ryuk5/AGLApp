<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //un objet isirou 3lih plusieres dont
    public function donations()
    {
        return $this->hasMany('App\Donation');
    }

    ////un objet isirou 3lih plusieres demandes
    public function demands()
    {
        return $this->hasMany('App\Demand');
    }

    //l'objet appartient a un sujet
    public function subject()
    {
        return $this->belongsTo('App\subject');
    }
}
