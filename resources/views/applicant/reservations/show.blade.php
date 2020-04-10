@extends('layouts.app')

@section('content')
    <a href="{{ route('home') }}" class="btn btn-danger">Go Back</a>
    
    <h1>{{ $reservation->donation->item->name }}</h1>
    <h4>By : {{ $reservation->demand->user->name }}</h4>
    <div>
        <p>{!!$reservation->demand->description!!}</p>
        <p>Quantity : {{ $reservation->demand->qty }}</p>
    </div>
    <hr>


        <!-- Button trigger modal -->
        <center><button type="button" class="btn btn-lg btn-outline-dark mt-2" data-toggle="modal" data-target="#staticBackdrop">
            Verify Delevery
        </button></center> 

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            
            <div class="modal-dialog" role="document">
                
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Proccessing delevey info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        
                        @canany(['giver-role', 'admin-role'])
                            @if ($reservation->giver_delivery_man == -1)
                                <form method="POST" action="{{ route('contact.delivery.update', $reservation->id) }}">
                                    @csrf
                                    {{ method_field('PUT') }}

                                    <div class="form-row">
                                    <div class="col">
                                        <fieldset disabled>
                                            <input type="text" name="availability" class="form-control" value="{{ $reservation->donation->availability }}">
                                        </fieldset>
                                    </div>
                                    <div class="col">
                                            <fieldset disabled>
                                                <input type="text" class="form-control" name="location" value="{{ $reservation->donation->location }}">
                                            </fieldset>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline1" value="1" name="giver_delivery_man" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline1">You have delevery man</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline2" value="0" name="giver_delivery_man" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline2">You don't have delevery man</label>
                                        </div>
                                    </div>

                                    <center> <button type="submit" class="btn btn-outline-dark mt-4">Send</button> </center> 
                                </form>    
                            @else
                                @if ($reservation->giver_delivery_man == 0)
                                    <center> 
                                        <div class="spinner-grow" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>  
                                        
                                        <h3>Wating for Applicant to fill Delevery info</h3>
                                    </center>   
                                @endif
                                
                            @endif

                            
                        @endcanany

                        @can('applicant-role')
                            @if ($reservation->giver_delivery_man == -1)
                                <center> 
                                    <div class="spinner-grow" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>  
                                    
                                    <h3>Wating for Giver to fill Delevery info</h3>
                                </center>
                            @else
                                @if ($reservation->giver_delivery_man == 0)
                                    <form method="POST" action="{{ route('contact.delivery.update', $reservation) }}">
                                        @csrf
                                        {{ method_field('PUT') }}
                                        
                                        <div class="mt-3">
                                            
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline1" value="1" name="applicant_delivery_man" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadioInline1">You have delevery man</label>
                                            </div>
                                            
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="customRadioInline2" value="0" name="applicant_delivery_man" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadioInline2">You don't have delevery man</label>
                                            </div>

                                        </div>
        
                                        <center> <button type="submit" class="btn btn-outline-dark mt-4">Send</button> </center> 
                                    </form>
                                @endif
                            @endif
                        @endcan


                          
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>

            </div>

        </div>
            
       
    
    
   
@endsection