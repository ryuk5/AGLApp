@extends('layouts.app')

@section('content')
    <h1>Listes des Donts</h1>
    @if (count($donations) > 0)
        @foreach($donations as $donation)
          <div class="card mb-5">
            <div class="card-header">
              {{ $donation->item->subject->name }}
            </div>
            <div class="card-body">
              <h5 class="card-title">Item: {{ $donation->item->name }}</h5>
              <p class="card-text">Availability: {{ $donation->availability }}</p>
              <hr>
    
              <a href="{{ route('giver.donations.show', $donation) }}" class="btn btn-primary">Check this donation</a>
            </div>
          </div>
        @endforeach
      
    @else
        <h2 class="text-center">Aucune demande a traiter</h2>
    @endif
@endsection