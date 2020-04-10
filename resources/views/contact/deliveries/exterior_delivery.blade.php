@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        
        <div class="card text-center">
            <div class="card-header">
              Delevery 
            </div>
            <div class="card-body">
              <h5 class="card-title">Delevery from {{ $reservation->donation->user->name }} to {{ $reservation->demand->user->name }}</h5>
              <p class="card-text">{{ $reservation->demand->descreption }}</p>
              <p class="card-text">Giver Email : {{ $reservation->donation->user->email }}</p>
              <p class="card-text">Applicant Email : {{ $reservation->demand->user->email }}</p>
            
            @can('applicant-role')
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                    Validate Delevery
                </button>    
            @endcan
            

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <div class="modal-body">
                            <div class="alert alert-danger" role="alert">
                                The click on this button will<br> 
                                1- Verify the delevery <br>
                                2- Delete your demand <br>
                                3- Delete all your reservations that belongs to that demand
                                
                            </div>

                            <form action="{{ route('contact.delivery.destroy', $reservation->id) }}" method="POST">
                                @csrf
                                {{method_field('DELETE')}}
                                <center><button type="submit" class="btn btn-lg btn-primary">Delete</button></center>
                            </form>    
                              
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="card-footer text-muted">
                Availability : {{ $reservation->donation->availability }}
              </div>
          </div>
        
        
    </div>

    
@endsection