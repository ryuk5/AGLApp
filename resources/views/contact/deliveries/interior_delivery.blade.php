@extends('layouts.app')

@section('content')
    <div class="card text-center mb-5">
        <div class="card-header">
        Delivery Man
        </div>
        <div class="card-body">
        <h5 class="card-title">Delivery Man Infos</h5>
        <div class="row">
            <div class="col-md-6">
              <p>Name : </p>
              <p>Email : </p>
              <p>Tel : </p>
              <p>Region : </p>
            </div>

            <div class="col-md-6">
              <p>{{ $delivery->user->name }}</p>
              <p>{{ $delivery->user->email }}</p>
              <p>{{ $delivery->user->tel }}</p>
              <p>{{ $delivery->user->region }}</p>
            </div>
        </div>
        @can('delivery-man-role')
            <form method="POST" action="{{ route('contact.delivery.handleChaking', $delivery) }}">
                @csrf
                {{ method_field('PUT') }}
                <button type="submit" class="btn btn-primary">Verify Delivery</button>
            </form>
        @endcan
            
        </div>
        <div class="card-footer text-muted">
        2 days ago
        </div>
    </div>

    <div class="card text-center mb-5">
        <div class="card-header">
          Giver
        </div>
        <div class="card-body">
          <h5 class="card-title">Special title treatment</h5>
          <div class="row">
              <div class="col-md-6">
                <p>Name : </p>
                <p>Email : </p>
                <p>Tel : </p>
                <p>Region : </p>
              </div>

              <div class="col-md-6">
                @if ($delivery->reservation->donation->followed == 1)
                    <p>{{ $delivery->reservation->donation->user->name }}</p>
                    <p>{{ $delivery->reservation->donation->user->email }}</p>
                    <p>{{ $delivery->reservation->donation->user->tel }}</p>
                    <p>{{ $delivery->reservation->donation->user->region }}</p>    
                @else
                <p>Anonymous</p>
                <p>admin@gmail.com</p>
                <p>xx xxx xxx</p>
                <p>anonymous</p>    
                @endif
                
              </div>
          </div>
          
        </div>
        <div class="card-footer text-muted">
          {{ $delivery->created_at }}
        </div>
      </div>

      <div class="card text-center mb-5">
        <div class="card-header">
            Applicant
        </div>
        <div class="card-body">
          <h5 class="card-title">Special title treatment</h5>
          <div class="row">
            <div class="col-md-6">
              <p>Name : </p>
              <p>Email : </p>
              <p>Tel : </p>
              <p>Region : </p>
            </div>

            <div class="col-md-6">
              <p>{{ $delivery->reservation->demand->user->name }}</p>
              <p>{{ $delivery->reservation->demand->user->email }}</p>
              <p>{{ $delivery->reservation->demand->user->tel }}</p>
              <p>{{ $delivery->reservation->demand->user->region }}</p>
            </div>
        </div>
            @can('applicant-role')
                <form method="POST" action="{{ route('contact.delivery.handleChaking', $delivery) }}">
                    @csrf
                    {{ method_field('PUT') }}
                    <button type="submit" class="btn btn-primary">Verify Delivery</button>
                </form>    
            @endcan
            
        </div>
        <div class="card-footer text-muted">
          2 days ago
        </div>
      </div>

    
@endsection