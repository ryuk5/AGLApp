@extends('layouts.app')

@section('content')
    <h1>Listes des Demandes</h1>
    @if (count($demands) > 0)
        @foreach($demands as $demand)
          <div class="card mb-5">
            <div class="card-header">
              {{ $demand->item->subject->name }}
        

            </div>
            <div class="card-body">
              <h5 class="card-title">Item: {{ $demand->item->name }}</h5>
              <p class="card-text">Dead Line: {{ $demand->dl }}</p>
              <hr>
    
              <a href="{{ route('applicant.demands.show', $demand) }}" class="btn btn-primary">Check this demand</a>
            </div>
          </div>
        @endforeach
      
    @else
        <h2 class="text-center">Aucune demande a traiter</h2>
    @endif
@endsection