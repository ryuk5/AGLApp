<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Gate;
use App\Reservation;
use App\Delivery;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Gate::allows('admin-role'))
        {
            $reservations = DB::table('reservations')
                        ->join('donations', 'donation_id', '=', 'donations.id')
                        ->join('demands', 'demand_id', '=', 'demands.id')
                        ->where('followed', '=', 0)
                        ->where('state', '=', 0)
                        ->select('demands.created_at as demand_created_at', 'demands.id as demand_id', 'donations.id as donation_id', 'reservations.id as reservation_id')
                        ->get();

            $accepted_reservations = DB::table('reservations')
                        ->join('donations', 'donation_id', '=', 'donations.id')
                        ->join('demands', 'demand_id', '=', 'demands.id')
                        ->where('followed', '=', 0)
                        ->where('state', '=', 1)
                        ->select('reservations.created_at as reservation_created_at', 'reservations.updated_at as updated_at', 'demands.id as demand_id', 'reservations.id as reservation_id', 'reservations.giver_delivery_man as giver_delivery_man', 'reservations.applicant_delivery_man as applicant_delivery_man') 
                        ->get();                
        }
        
        if(Gate::allows('giver-role'))
        {
            $reservations = DB::table('reservations')
                        ->join('donations', 'donation_id', '=', 'donations.id')
                        ->join('demands', 'demand_id', '=', 'demands.id')
                        ->where('followed', '=', 1)
                        ->where('state', '=', 0)
                        ->where('donations.user_id', '=', auth()->user()->id)
                        ->select('demands.created_at as demand_created_at', 'demands.id as demand_id', 'donations.id as donation_id', 'reservations.id as reservation_id')
                        ->get();

            $accepted_reservations = DB::table('reservations')
                        ->join('donations', 'donation_id', '=', 'donations.id')
                        ->join('demands', 'demand_id', '=', 'demands.id')
                        ->where('followed', '=', 1)
                        ->where('state', '=', 1)
                        ->where('donations.user_id', '=', auth()->user()->id)
                        ->select('reservations.created_at as reservation_created_at', 'reservations.updated_at as updated_at', 'demands.id as demand_id', 'reservations.id as reservation_id', 'reservations.giver_delivery_man as giver_delivery_man', 'reservations.applicant_delivery_man as applicant_delivery_man') 
                        ->get();                
        }

        if(Gate::allows('applicant-role'))
        {
            $reservations = DB::table('reservations')
                        ->join('donations', 'donation_id', '=', 'donations.id')
                        ->join('demands', 'demand_id', '=', 'demands.id')
                        ->where('demands.user_id', '=', auth()->user()->id)
                        ->where('state', '=', 0)
                        ->select('demands.created_at as demand_created_at', 'demands.id as demand_id', 'donations.id as donation_id', 'reservations.id as reservation_id')
                        ->get();

            $accepted_reservations = DB::table('reservations')
                        ->join('donations', 'donation_id', '=', 'donations.id')
                        ->join('demands', 'demand_id', '=', 'demands.id')
                        ->where('demands.user_id', '=', auth()->user()->id)
                        ->where('state', '=', 1)
                        ->select('reservations.created_at as reservation_created_at', 'reservations.updated_at as updated_at', 'demands.id as demand_id', 'reservations.id as reservation_id', 'reservations.giver_delivery_man as giver_delivery_man', 'reservations.applicant_delivery_man as applicant_delivery_man') 
                        ->get();
        }

       
        $data = array(
            'reservations' => $reservations,
            'accepted_reservations' => $accepted_reservations
        );
            
            
        return view('home')->with($data);
         
    }
}
