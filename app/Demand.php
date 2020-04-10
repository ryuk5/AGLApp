<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    //demande appartient a un objet
    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    //demande appartient a un user
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //une demande na3mllou béha plusieures résérvations
    public function reservations()
    {
        return $this->hasMany('App\Reservation');
    }
}
