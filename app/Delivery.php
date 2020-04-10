<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    //Une livraison appartient a une résérvation dans le cas éli éli le demandeur et le donneur ma3andhomche livreur
    public function reservation()
    {
        return $this->belongsTo('App\Reservation');
    }

    //Une livraison appartient a un utilisateur éli houa él livreure
    public function user()
    {
        return $this->belongsTo('App\User', 'delivery_man_id', 'id');
    }

}
