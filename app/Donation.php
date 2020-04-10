<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    //dont appartient a un objet
    public function item()
    {
        return $this->belongsTo('App\Item');
    }

    //dont appartient a un user
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //un dont isisrou 3lih plusieures résérvations
    public function reservations()
    {
        return $this->hasMany('App\Reservation');
    }
}
