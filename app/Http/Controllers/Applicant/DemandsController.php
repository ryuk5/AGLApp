<?php

namespace App\Http\Controllers\Applicant;
use Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Demand;
use App\Subject;
use App\User;
use App\Item;
use App\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DemandsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    
    /**
     * fonction avec la quelle on vérifie kén famma une résérvation accepter
     * pour cette demande passer en paramétre 
     */

    public function verif(Demand $demand)
    {
        $ext = 0;
        $reservations = Reservation::where('demand_id', $demand->id)->get();
        foreach ($reservations as $reservation) {
            if($reservation->state == 1)
            {
                $ext = 1;
            }
            break;
            }
        return $ext;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /** 
     * fonction twarik tous les demandes et tab3athom lél view applicant.demands.index
    */
    public function index()
    {
        $demands = Demand::all();
        return view('applicant.demands.index')->with('demands', $demands);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * fonction avec la quelle on crée la demande
     */
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $items = DB::table('items')->where('subject_id', '=', $_POST['subject'])->get(); //houni néjbéd fél les objets corrésspendant lél sujet choisie
            return view('applicant.demands.create')->with('items', $items); //n3adihom to the view        
        }

        if ($request->isMethod('get')) {
            if ($request->session()->has('errors') && $request->session()->has('items')) {
                $errors = $request->session()->get('errors');  
                $items = $request->session()->get('items');
                $request->session()->forget(['errors', 'items']);
                return view('applicant.demands.create')->with([
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
     * récupération des infrmations + tasjil fél base él demande + control de saisie (validator)  
     */ 
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'item' => 'required',
            'qty' => 'required',
            'urgent' => 'required',
        ]);

        if ($validator->fails()) {
            $item = Item::find($request->item);
            $items = Item::where('subject_id', $item->subject_id)->get();
            $messages = $validator->messages();
            
            $request->session()->put('errors', $messages);
            $request->session()->put('items', $items);
            return redirect()->route('applicant.demands.create');
        }
        
        $demand = new Demand;

        $demand->item_id = $request->input('item');
        $demand->user_id = auth()->user()->id;
        $demand->description = $request->input('descreption');
        $demand->qty = $request->input('qty');
        $demand->dl = $request->input('dl');
        $demand->urgent = $request->input('urgent');

        $demand->save();

        return redirect()->route('applicant.demands.index')->with('success', 'Demand Created successfuly');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Demand  $demand
     * @return \Illuminate\Http\Response
     */
    
    /**
     * fonction twarik une demande spécifique
     */

    public function show(Demand $demand)
    {
        $acc_dem = $this->verif($demand);
      
        $data = array(
            'demand' => $demand,
            'acc_dem' => $acc_dem
        );
        return view('applicant.demands.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Demand  $demand
     * @return \Illuminate\Http\Response
     */
    
    /**
     * fonction éli nmodifi féha une demande + sécurité avec les gate
     */

    public function edit(Request $request, Demand $demand)
    {
        if(Gate::allows('applicant-role') && auth()->user()->id == $demand->user_id && $this->verif($demand) == 0)
        {
            $items = DB::table('items')->where('subject_id', '=', $demand->item->subject_id)->get();
            
            if ($request->session()->has('errors')) {
                $errors = $request->session()->get('errors'); 
                $request->session()->forget('errors');
                return view('applicant.demands.edit')->with([
                    'demand' => $demand,
                    'items' => $items,
                    'errors' => $errors
                ]); 
            }
            else
            {
                return view('applicant.demands.edit')->with([
                    'demand' => $demand,
                    'items' => $items
                ]); 
            }
            
        }
        else
        {
            return redirect()->route('applicant.demands.index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');
        }
        
            
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Demand  $demand
     * @return \Illuminate\Http\Response
     */

    /**
     * fonction éli isir béha él update fél base + validation des informations éli jén mél view edit
     */

    public function update(Request $request, Demand $demand)
    {
        $validator = Validator::make($request->all(), [ 
            'item' => 'required',
            'qty' => 'required',
            'urgent' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            $request->session()->put('errors', $messages);
            return redirect()->route('applicant.demands.edit', $demand);
        }
        

        $demand->item_id = $request->input('item');
        $demand->description = $request->input('descreption');
        $demand->qty = $request->input('qty');
        $demand->dl = $request->input('dl');
        $demand->urgent = $request->input('urgent');

        if($demand->save())
        {
            $request->session()->flash('success', $demand->user->name . ' ,Your demand has been updated');
        }
        else
        {
            $request->session()->flash('error', 'There was an error updating the demand');
        }
            

        return redirect()->route('applicant.demands.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Demand  $demand
     * @return \Illuminate\Http\Response
     */
    
    /**
     * fonction éli nfassa5 béha une demande + sécurité avec les gate
     */

    public function destroy(Request $request, Demand $demand)
    {
        if(Gate::allows('applicant-role') && auth()->user()->id == $demand->user_id)
        {
            if($demand->delete())
            {
                $request->session()->flash('success', auth()->user()->name . ' ,Your demand has been deleted');
            }
            else
            {
                $request->session()->flash('error', 'There was an error deleting the demand');
            }

            return redirect()->route('applicant.demands.index');
        }
        else
        {
            return redirect()->route('applicant.demands.index')->with('error', 'Unauthorized Page, Your not allowed to perform this action');
        }
            
    }

    /**
     * fonction éli léhiya bél choix de sujet et le passage vers la création de la demande
     */
    public function subject_choice()
    {
        if(Gate::allows('applicant-role'))
        {
            $subjects = Subject::all();
            return view('applicant.demands.subject_choice')->with('subjects', $subjects);
        }
        else
        {
            return redirect()->route('index')->with('error', 'Unauthorized Page, You should be an applicant to access this page');
        }
            
    }
}
