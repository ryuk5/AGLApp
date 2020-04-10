<?php

namespace App\Http\Controllers\Contact;

use Gate;
use App\Reservation;
use App\Delivery;
use App\Role;
use App\User;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveriesController extends Controller
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
     * redirection pour la sécurité
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
        return redirect()->route('index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //finding the reservations infos
        $reservation = Reservation::find($request->input('reservation_id'));  

        $ext = DB::table('deliveries')->where('reservation_id', '=', $reservation->id)->get();  
        if(count($ext) > 0)
        {
            $delivery = Delivery::find($ext[0]->id);
            return view('contact.deliveries.interior_delivery')->with('delivery', $delivery);
        }
        else
        {
            //Finding the id of the role
            $role_id = (Role::where('name', 'delivery-man')->first())->id; //echo $role_id;
       
            //Finding the appropriate delevey man
            $user = DB::table('users')
            ->where([
                ['role_id', '=', $role_id],
                ['region', '=',  $reservation->donation->user->region],
            ])
            ->inRandomOrder()
            ->limit(1)
            ->get();
            //echo $reservation->donation->user->region;
            //echo 'the user = > '.$user; 
            //Creating the new delevery
            $delivery = new Delivery;
            $delivery->reservation_id = $reservation->id;
            $delivery->delivery_man_id = $user[0]->id;
            $delivery->delivery_check = 0;
            $delivery->applicant_check = 0;
            
            $delivery->save();
            //redirect to interor delevery
            return view('contact.deliveries.interior_delivery')->with('delivery', $delivery);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservation::find($id);
        if($reservation != null)
        {
            if( (Gate::allows('applicant-role') && auth()->user()->id == $reservation->demand->user_id && ($reservation->giver_delivery_man == 1 || $reservation->applicant_delivery_man == 1) ) ||
                (Gate::allows('giver-role') && auth()->user()->id == $reservation->donation->user_id && ($reservation->giver_delivery_man == 1 || $reservation->applicant_delivery_man == 1) ) ||
                (Gate::allows('admin-role') && $reservation->donation->followed == 0 && ($reservation->giver_delivery_man == 1 || $reservation->applicant_delivery_man == 1) )
            )
            {
                return view('contact.deliveries.exterior_delivery')->with('reservation', $reservation);
            }
            else
            {
                return redirect()->route('index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');
            }
        }    
        else
        {
            return redirect()->route('index')->with('error', '404 Not Found');
        }
            
            
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {
        return redirect()->route('index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int
     * @return \Illuminate\Http\Response
     */
    
    //updating the giver delevery man and the applicant delevery man attribute in the reservations table 
    
    public function update(Request $request, $id)
    {
        $reservation = Reservation::find($id);

        
        if(Gate::allows('giver-role') || Gate::allows('admin-role'))
        {
            $reservation->giver_delivery_man = $request->input('giver_delivery_man');
        }

        if(Gate::allows('applicant-role'))
        {
            $reservation->applicant_delivery_man = $request->input('applicant_delivery_man');
        }

        if($reservation->save())
        {
            if(Gate::allows('admin-role'))
            {
                $request->session()->flash('success', auth()->user()->name . ' ,Your delevery info has been updated');
            }
            else
            {
                $request->session()->flash('success', $reservation->donation->user->name . ' ,Your delevery info has been updated');
            }
        }
        else
        {
            $request->session()->flash('error', 'There was an error updating the demand');
        }

        return redirect()->route('home');    

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    
    /**
     * suppression de la livraison extérrieure
     */
    public function destroy(Request $request, $id)
    {
        if(Gate::allows('applicant-role'))
        {
            $reservation = Reservation::find($id);
            $demand = $reservation->demand;
            $donation = $reservation->donation;

            if($reservation->delete() && $demand->delete())
            {
                if($donation->qty == 0)
                {
                    if($donation->delete())
                    {
                        $ver = 1;
                    }
                    else
                    {
                        $ver = 0;
                    }
                    
                }
                else
                {
                    $ver = 2;
                }

                if($ver == 1)
                {
                    $request->session()->flash('success', auth()->user()->name . ' ,Your Delevery wéslét, reservation tfasa5t, demand tfasa5t, dont tfasa5');
                }
                else if($ver == 2)
                {
                    $request->session()->flash('success', auth()->user()->name . ' ,Your Delevery wéslét, reservation tfasa5t, demand tfasa5t, dont updated');
                }
                else
                {
                    $request->session()->flash('error', 'Error occured try again mél dont');
                }
            }
            else
            {
                $request->session()->flash('error', 'There was an error deleting the delevery');
            }

            return redirect()->route('home');
        }
    }

    /**
     * cette méthode té5ou a put request
     * wa9téli él livreuer ivalidi él livraison bté3ou ou wa9téli él demandeur valide él livrasion bté3ou
     * la livrasion tétfasa5 / la résérvation tétfasa5 / él demande éli saret béha él résérvation tétfasa5 / él ddont kén él quantité wallet fih 0 iétfasa5
     */
    public function handleChaking(Request $request, Delivery $delivery)
    {
        if(Gate::allows('applicant-role'))
        {
            $delivery->applicant_check = 1;
        }

        if(Gate::allows('admin-role') || Gate::allows('delivery-man-role'))
        {
            $delivery->delivery_check = 1;
        }

        //personalize the messsage after updating or deleting a delivery
        if($delivery->applicant_check == 1 && $delivery->delivery_check == 1)
        {
            $reservation = $delivery->reservation;
            $demand = $delivery->reservation->demand;
            $donation = $delivery->reservation->donation;
            
            if($delivery->delete() && $reservation->delete() && $demand->delete())
            {
                if($donation->qty == 0)
                {
                    if($donation->delete())
                    {
                        $ver = 1;
                    }
                    else
                    {
                        $ver = 0;
                    }
                    
                }
                else
                {
                    $ver = 2;
                }

                if($ver == 1)
                {
                    $request->session()->flash('success', auth()->user()->name . ' ,Your Delevery wéslét, reservation tfasa5t, demand tfasa5t, dont tfasa5');
                }
                else if($ver == 2)
                {
                    $request->session()->flash('success', auth()->user()->name . ' ,Your Delevery wéslét, reservation tfasa5t, demand tfasa5t, dont updated');
                }
                else
                {
                    $request->session()->flash('error', 'Error occured try again mél dont');
                }
                
            }
            else
            {
                $request->session()->flash('error', 'Error occured try again');
            }
        }
        else
        {
            if($delivery->save())
            {
                $request->session()->flash('success', auth()->user()->name . ' ,Your delevery info has been updated');
            }
            else
            {
                $request->session()->flash('error', auth()->user()->name . ' ,Error occured try again');
            }
        }

        if(Gate::allows('delivery-man-role'))
        {
            return redirect()->route('contact.delivery-man.index');
        }
        else
        {
            return redirect()->route('home');
        }

    }


}
