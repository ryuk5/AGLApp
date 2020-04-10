<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Delivery;
use Gate;

class DeliveryManController extends Controller
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
     * une fonction t5réj les deliveries d'un livreur et ta3méll une redirection lél dashboard bta3 livreur
     */
    public function index()
    {
        if(Gate::allows('delivery-man-role'))
        {
            $deliveries = Delivery::where('delivery_man_id', auth()->user()->id)->get();
            return view('contact.delivery_man.index')->with('deliveries', $deliveries);
        } 
        else
        {
            return redirect()->route('index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');
        }
            
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
        //cette fonction na7itha
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $delivery = Delivery::find($id);
        if($delivery != null)
        {
            if(Gate::allows('delivery-man-role') && $delivery->delivery_man_id == auth()->user()->id)
            {
                return view('contact.deliveries.interior_delivery')->with('delivery', $delivery);
            }
            else
            {
                return redirect()->route('index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');
            }
        }
        else
        {
            return redirect()->route('index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');
        }
            
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->route('index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //cette fonction na7itha
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //cette fonction na7itha
    }
}
