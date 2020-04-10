@extends('layouts.app')

@section('content')
    <!-- This what the users will see -->
    <a href="{{ route('giver.donations.index') }}" class="btn btn-danger">Go Back</a>
    
    <h1>{{ $donation->item->subject->name }}</h1>
    <h4>By : {{ $donation->user->name }}</h4>
    <div>
        {!!$donation->description!!} <br>
        The quantity : {{ $donation->qty }}
    </div>
    <h5>Ce dont sera disponible le : {{ $donation->availability }}</h5>
    <hr>
    <small>Written on {{ $donation->created_at }}</small>
    <hr>
    
    @auth
        @if (Auth::user()->id == $donation->user_id)
            <a href="{{ route('giver.donations.edit', $donation) }}"><button type="button" class="btn btn-success btn-lg float-left">Edit</button></a>
            <form action="{{ route('giver.donations.destroy', $donation) }}" method="POST" class="float-right">
                @csrf
                {{method_field('DELETE')}}
                <button type="submit" class="btn btn-lg btn-secondary">Delete</button>
            </form>
        @endif
    
        
        @can('applicant-role')
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-lg btn-primary ml-3" data-toggle="modal" data-target="#staticBackdrop">
                Reservation
            </button>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Make Reservation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if ($ext == 0)
                                <form action="{{ route('applicant.reservations.store', $donation) }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col">
                                            <!-- the demandes that belogs to the same item in the donation that the applicant did-->
                                            @if (count($demands) > 0)
                                                <select class="form-control" id="demand_id" name="demand_id">
                                                    <option value="none">Select Your Demand</option>
                                                        
                                                        @php
                                                            //init counter
                                                            $n = 0;
                                                        @endphp

                                                        @foreach ($demands as $demand)
                                                            @if ($donation->qty >= $demand->qty)
                                                                
                                                                @php
                                                                //counting the numbers of demands that have an appropriate quantity
                                                                $n++;    
                                                                @endphp
                                                                <option value="{{ $demand->id }}">{{ $demand->created_at }} -- Quantity required {{ $demand->qty }}</option>    
                                                            @endif
                                                        @endforeach
                                                </select>

                                                <div class="col" style="display:none">
                                                    <input type="text" class="form-control" name="donation_id" value="{{ $donation->id }}">
                                                </div>

                                                @if ($n >0 )
                                                    <center><button type="submit" class="btn btn-primary mt-4">Verify Reservation</button></center>    
                                                @else
                                                    <div class="alert alert-danger mt-5" role="alert">
                                                        You don't have any demands with an appropriate quantity
                                                    </div>    
                                                @endif
                                                
                                            @else
                                                <div class="alert alert-danger" role="alert">
                                                    You don't have any demands goes with this donation
                                                </div>                
                                            @endif
                                                
                                        </div>
                                        
                                    </div>
                                        
                                </form>
                            @else
                                <div class="alert alert-danger" role="alert">
                                    You have already sent a reservation request
                                </div>
                            @endif
                                
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    @endauth
@endsection