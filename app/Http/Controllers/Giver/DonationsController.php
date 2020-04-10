<?php

namespace App\Http\Controllers\Giver;
use Gate;
use App\Donation;
use App\Item;
use App\Subject;
use App\Reservation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DonationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     /**
     * cette fonctions traja3lék tous les donts éli 3ana
     */

    public function index()
    {
        $donations = Donation::all();
        return view('giver.donations.index')->with('donations', $donations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * fonction avec la quelle on crée él dont ba3d ma5rtarna dont bté3na tébé3 ana sujet
     */

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $items = DB::table('items')->where('subject_id', '=', $_POST['subject'])->get();
            return view('giver.donations.create')->with('items', $items);
        }

        if ($request->isMethod('get')) {
            if ($request->session()->has('errors') && $request->session()->has('items')) {
                $errors = $request->session()->get('errors');  
                $items = $request->session()->get('items');
                $request->session()->forget(['errors', 'items']);
                return view('giver.donations.create')->with([
                    'errors' => $errors,
                    'items' => $items
                ]);
            }
            else
            {
                return redirect()->route('home')->with('error', 'Unauthorized Page, Your not allowed to perform this action');
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    /**
     * sauvgarde des données fél base + vérification de données mél formulaire avec le validateur 
     */
    public function store(Request $request)
    {   

        $validator = Validator::make($request->all(), [ 
            'item' => 'required',
            'qty' => 'required',
            'followed' => 'required',
        ]);

        if ($validator->fails()) {
            $item = Item::find($request->item);
            $items = Item::where('subject_id', $item->subject_id)->get();
            $messages = $validator->messages();
            
            $request->session()->put('errors', $messages);
            $request->session()->put('items', $items);
            return redirect()->route('giver.donations.create');
        }
        
        
        $donation = new Donation;

        $donation->item_id = $request->input('item');
        $donation->user_id = auth()->user()->id;
        $donation->description = $request->input('descreption');
        $donation->qty = $request->input('qty');
        $donation->location = $request->input('location');
        $donation->availability = $request->input('availability');
        $donation->followed = $request->input('followed');

        $donation->save();

        return redirect()->route('giver.donations.index')->with('success', 'Donation Created successfuly');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    
    /**
     * cette fonction traja3lék un dont spécifique 
     */

    public function show(Donation $donation)
    {
        if(Gate::allows('applicant-role'))
        {
            $demands = DB::table('demands')->where([
                ['item_id', '=', $donation->item_id],
                ['user_id', '=', auth()->user()->id],
            ])->get();


            $reservations = Reservation::where('donation_id', $donation->id)->get();
            $ext = 0;
            foreach ($reservations as $reservation) {
                if($reservation->demand->user_id == auth()->user()->id)
                {
                    $ext = 1;
                }
            }


            $data = array(
                'demands' => $demands,
                'donation' => $donation,
                'ext' => $ext
            );

            return view('giver.donations.show')->with($data);
        }
        else
        {
            return view('giver.donations.show')->with('donation', $donation);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    
    /**
     * héti él fonction éli najmou on edit béha les donts 
     */

    public function edit(Request $request, Donation $donation)
    {
        if(Gate::allows('giver-role') && auth()->user()->id == $donation->user_id)
        {
            $items = DB::table('items')->where('subject_id', '=', $donation->item->subject_id)->get();
            
            if ($request->session()->has('errors')) {
                $errors = $request->session()->get('errors'); 
                $request->session()->forget('errors');
                return view('giver.donations.edit')->with([
                    'donation' => $donation,
                    'items' => $items,
                    'errors' => $errors
                ]); 
            }
            else
            {
                return view('giver.donations.edit')->with([
                    'donation' => $donation,
                    'items' => $items
                ]);
            }
        }
        else
        {
            return redirect()->route('giver.donations.index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');
        }
            
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    
    /**
     * houniya on vérifie les infos que 3malnélhom edit
     */

    public function update(Request $request, Donation $donation)
    {
        $validator = Validator::make($request->all(), [ 
            'item' => 'required',
            'qty' => 'required',
            'followed' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            $request->session()->put('errors', $messages);
            return redirect()->route('giver.donations.edit', $donation);
        }
        
        
        $donation->item_id = $request->input('item');
        $donation->description = $request->input('descreption');
        $donation->qty = $request->input('qty');
        $donation->location = $request->input('location');
        $donation->availability = $request->input('availability');
        $donation->followed = $request->input('followed');

        if($donation->save())
        {
            $request->session()->flash('success', $donation->user->name . ' ,Your donation has been updated');
        }
        else
        {
            $request->session()->flash('error', 'There was an error updating the donation');
        }
            

        return redirect()->route('giver.donations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    
    /**
     * cette fonction t5alina nfas5ou un dont plus famma sécurité avec les gate expm : matnajamche tfasa5 él dont bta3 8irék 
     */

    public function destroy(Request $request, Donation $donation)
    {
        if(Gate::allows('giver-role') && auth()->user()->id == $donation->user_id)
        {
            if($donation->delete())
            {
                $request->session()->flash('success', auth()->user()->name . ' ,Your donation has been deleted');
            }
            else
            {
                $request->session()->flash('error', 'There was an error deleting the donation');
            }

            return redirect()->route('giver.donations.index');
        }
        else
        {
            return redirect()->route('giver.donations.index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');
        }
            
    }

    /**
     * cette fonction nous permet mél choix de sujet éli ba3d bch na3mlou lou la création du dont 
     */
    
    public function subject_choice()
    {
        if(Gate::allows('giver-role'))
        {
            $subjects = Subject::all();
            return view('giver.donations.subject_choice')->with('subjects', $subjects);
        }
        else
        {
            return redirect()->route('index')->with('error', 'Unauthorized Page, You should be a giver to access this page');
        }
    }
}
