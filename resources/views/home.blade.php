@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
               <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @can('giver-role')
                        <a href="{{ route('giver.donations.subject_choice') }}" class="btn btn-primary">Create Donation</a> 
                    @endcan
                    
                    @can('applicant-role')
                        <a href="{{ route('applicant.demands.subject_choice') }}" class="btn btn-primary">Create Demand</a>        
                    @endcan
                    
                    
                    <a href="{{ route('giver.donations.subject_choice') }}" class="btn btn-success ml-3 float-right">Check Delevery</a>    
                    
    
                    <nav aria-label="breadcrumb" class="mt-5">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item active" aria-current="page">Reservations</li>
                        </ol>
                    </nav>
                    
                    
                        <table class="table mt-2">
                            <thead>
                                <tr>
                                    <th scope="col">Created at</th>
                                    <th scope="col">Check demand</th>
                                    <th scope="col">Check donation</th>
                                    <th scope="col">Verify Reservation</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach ($reservations as $reservation)
                                                                
                                    <tr>
                                        <td>{{ $reservation->demand_created_at }}</td>
                                        
                                        <td>
                                            <a href="{{ route('applicant.demands.show', $reservation->demand_id) }}"><button type="button" class="btn btn-primary float-left">Check Demand</button></a>    
                                        </td>
                                        
                                        <td>
                                            <a href="{{ route('giver.donations.show', $reservation->donation_id) }}"><button type="button" class="btn btn-primary float-left">Check Donation</button></a>               
                                        </td>
                                        
                                        <td>
                                            @canany(['giver-role', 'admin-role'])
                                                <form action="{{ route('applicant.reservations.update', $reservation->reservation_id) }}" method="POST" class="float-left mr-3">
                                                    @csrf
                                                    {{ method_field('PUT') }}
                                                    <button type="submit" class="btn btn-success">Confirm</button>
                                                </form>
                                            @endcanany
                                                
                                            
                                            <form action="{{ route('applicant.reservations.destroy', $reservation->reservation_id) }}" method="POST" class="float-right">
                                                @csrf
                                                {{method_field('DELETE')}}
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>                                         
                                        </td>
                                    </tr>
                                @endforeach
                                
                            </tbody>
                        </table>   
                    
                    
                   
                    
                </div>
            </div>
        </div>
        
        
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <span style="font-size:24px">Notifications</span> 
                    </div>
                        
                    <div class="card-body">
                        
                        @if (count($accepted_reservations) > 0)
                            @foreach ($accepted_reservations as $accepted_reservation)
                                <div class="card mb-3">
                                    <div class="card-header">
                                    Reservation Created at : {{ $accepted_reservation->reservation_created_at }}
                                    </div>
                                    <div class="card-body">
                                    <blockquote class="blockquote mb-0">
                                        @can('applicant-role')
                                            <p>Your demand has been accepted   <a class="btn btn-dark" href="{{ route('applicant.demands.show', $accepted_reservation->demand_id) }}">Check</a></p>
                                        @endcan

                                        @canany(['giver-role', 'admin-role'])
                                            <p>Your have accepted this demand  <a class="btn btn-dark" href="{{ route('applicant.demands.show', $accepted_reservation->demand_id) }}">Check</a></p>
                                        @endcanany
                                        
                                        @if ( ($accepted_reservation->giver_delivery_man == -1 && $accepted_reservation->applicant_delivery_man == -1) || ($accepted_reservation->giver_delivery_man == 0 && $accepted_reservation->applicant_delivery_man == -1) )
                                            <p>Pleas click here to check the reservation delevery info  <a class="btn btn-dark" href="{{ route('applicant.reservations.show', $accepted_reservation->reservation_id) }}">Check</a></p>    
                                        @else
                                            @if ($accepted_reservation->giver_delivery_man == 1 || $accepted_reservation->applicant_delivery_man == 1)
                                                <p>Your delevery is ready click here for more info <a class="btn btn-dark" href="{{ route('contact.delivery.show', $accepted_reservation->reservation_id) }}">Check</a></p>
                                            @else
                                                @if ($accepted_reservation->giver_delivery_man == 0 && $accepted_reservation->applicant_delivery_man == 0)
                                                    <p>
                                                        We will handle the delevery process click here for more info  
                                                        <form action="{{ route('contact.delivery.store') }}" method="POST">
                                                            @csrf
                                                            <input style="display:none" type="text" class="form-control" name="reservation_id" value="{{ $accepted_reservation->reservation_id }}" required >    
                                                            <button type="submit" class="btn btn-dark">Delevery</button>
                                                        </form>    
                                                    </p>
                                                @endif
                                            @endif
                                        @endif
                                        
                                    <footer class="blockquote-footer">Accepted at <cite title="Source Title">{{ $accepted_reservation->updated_at }}</cite></footer>
                                    </blockquote>
                                    </div>
                                </div>
                            @endforeach    
                        @else
                                <div class="alert alert-primary" role="alert">
                                    No New Notifications
                                </div>
                        
                        @endif
                        
                            
                    </div>
                </div>
            </div>
     
    </div>

@endsection