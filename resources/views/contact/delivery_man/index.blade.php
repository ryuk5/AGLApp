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
                    
                    
                    <nav aria-label="breadcrumb" class="mt-2">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item active" aria-current="page">Deliveries Ready</li>
                        </ol>
                    </nav>
                    
                    
                    <table class="table mt-2">
                        <thead>
                            <tr>
                                <th scope="col">Delivery Date</th>
                                <th scope="col">Start Location</th>
                                <th scope="col">Destination</th>
                                <th scope="col">Verify Delivery</th>
                            </tr>
                        </thead>
                        <tbody>
                                
                            @foreach ($deliveries as $delivery)
                                                            
                                <tr>
                                    <td>{{ $delivery->reservation->donation->availability }}</td>
                                        
                                    <td>{{ $delivery->reservation->donation->user->region }}</td>
                                        
                                    <td>{{ $delivery->reservation->demand->user->region }}</td>
                                        
                                    <td><a href="{{ route('contact.delivery-man.show', $delivery->id) }}" class="btn btn-lg btn-primary"></a></td>
                              </tr>
                            @endforeach
                                
                        </tbody>
                    </table>   
                    
                </div>
            </div>
        </div>
        
    </div>

@endsection