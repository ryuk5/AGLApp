<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Reservation;
use App\Demand;
use App\Donation;
use App\Delivery;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\DB;


class ReservationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * juste 3asécurité redirections
     */
    public function index()
    {
        return redirect()->route('index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //no create method sécurisé él index 8ata 3léha 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    /**
     * fonction éli isir béha él sauvgarde de la résérvation fél base de données
     */

    public function store(Request $request)
    {
        $reservation = new Reservation;

        $reservation->donation_id = $request->input('donation_id');
        $reservation->demand_id = $request->input('demand_id');
        $reservation->state = 0;
        $reservation->giver_delivery_man = -1;
        $reservation->applicant_delivery_man = -1;

        $reservation->save();
        return redirect()->route('home')->with('success', 'Reservation Created successfuly');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    
    /**
     * él fonction éli twarik une résérvation spécifique + sécurité des roles
     */

    public function show($id)
    {
        $reservation = Reservation::find($id);

        if($reservation == null)
        {
            return redirect()->route('index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');
        }
        else
        {
            if( ($reservation->giver_delivery_man == -1 && $reservation->applicant_delivery_man == -1) ||
            ($reservation->giver_delivery_man == 0 && $reservation->applicant_delivery_man == -1) )
            {
                
                if( ( (Gate::allows('giver-role') && $reservation->donation->user_id == auth()->user()->id) ||
                    (Gate::allows('applicant-role') && $reservation->demand->user_id == auth()->user()->id) ||
                    (Gate::allows('admin-role') && $reservation->donation->followed == 0) ) && ($reservation->state == 1) )
                {
                    return view('applicant.reservations.show')->with('reservation', $reservation);
                }
                else
                {
                    return redirect()->route('index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');
                }

            }
            else
            {
                //redirect
                 return redirect()->route('index')->with('error', 'Unauthorized Page, déja kamalt ta3mir él delevery');
            }

        }
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //no edit function + sécurisé na7itha mél web.php 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * lorsque une résérvation sera accepter cette méthode s'éxécute
     * state de la résérvation sera 1
     * él quantité bta3 él dont sera modifier (kén wallét 0 elle ne sera pas afficher mais pas supprimer elle sera supprimer kén ba3d maisir él accord bta3 él livraion !!!)
     */

    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        if( (Gate::allows('giver-role') && $reservation->donation->user_id == auth()->user()->id) ||
            (Gate::allows('admin-role') && $reservation->donation->followed == 0))
        {

            //updating the quantity of the donation
            $donation = Donation::find($reservation->donation_id);
            $demand = Demand::find($reservation->demand_id);
            $donation->qty = $donation->qty - $demand->qty;
            

            //update the state of the reservation
            $reservation->state = 1;

            if($reservation->save() && $donation->save())
            {
                $request->session()->flash('success', auth()->user()->name . ' ,Your Reservation is waiting for deleviery and the Donation has been updated , Pleas fill the delevery info !!!');
            }
            else
            {
                $request->session()->flash('error', 'There was an error updating the reservation');
            }

            return redirect()->route('home');

        }
        else
        {
            return redirect()->route('index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * cette fonction tfasa5 une résérvation +sécurité des roles avec les gates
     */

    public function destroy(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        if( (Gate::allows('giver-role') && $reservation->donation->user_id == auth()->user()->id) ||
            (Gate::allows('applicant-role') && $reservation->demand->user_id == auth()->user()->id) ||
            (Gate::allows('admin-role') && $reservation->donation->followed == 0) )
        {
            if($reservation->delete())
            {
                $request->session()->flash('success', auth()->user()->name . ' ,Your reservation has been deleted');
            }
            else
            {
                $request->session()->flash('error', 'There was an error deleting the reservation');
            }

            return redirect()->route('home');
        }
        else
        {
            return redirect()->route('index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');
        }
            
    }
    
}
