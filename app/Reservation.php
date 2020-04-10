<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //une réseervation appartient a un dont (a7na on réserve un dont)
    public function donation()
    {
        return $this->belongsTo('App\Donation');
    }

    //une réseervation appartient a un demande (a7na esta3malna une demande pour résérver)
    public function demand()
    {
        return $this->belongsTo('App\Demand');
    }

    //==> él réservation tlemme él demande éli réservia biha et él dont éli réservinéh
    
    //él livraison dans le cas él demander et le donneur ma3andhomche livreur 
    //3andha une et une seule livrasion notre livreur bch ya3méll tawsila wa7da ihez féha él dont lél demandeur
    public function delivery()
    {
        return $this->hasOne('App\Delivery');
    }
}
