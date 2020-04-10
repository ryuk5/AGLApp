@extends('layouts.app')

@section('content')
    <a href="{{ route('applicant.demands.index') }}" class="btn btn-danger">Go Back</a>
    
    <h1>{{ $demand->item->subject->name }}</h1>
    <h4>By : {{ $demand->user->name }}</h4>
    <div>
        {!!$demand->description!!}
    </div>
    <h5>Cette demande expire: {{ $demand->dl }}</h5>
    <hr>
    <small>Written on {{ $demand->created_at }}</small>
    <hr>

    @auth
        @if ($acc_dem == 0)
            @if (Auth::user()->id == $demand->user_id)
                <a href="{{ route('applicant.demands.edit', $demand) }}"><button type="button" class="btn btn-success btn-lg float-left">Edit</button></a>
                <form action="{{ route('applicant.demands.destroy', $demand) }}" method="POST" class="float-right">
                    @csrf
                    {{method_field('DELETE')}}
                    <button type="submit" class="btn btn-lg btn-secondary">Delete</button>
                </form>    
            @endif
        @else
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Well done!</h4>
                    @can ("applicant-role")
                        <p>Your demand has been accepted and the reservation that belogs to this demand is ready for delevery !!!.</p>        
                    @else
                        <p>Your accepted this demand and the reservation that belogs to this demand is ready for delevery !!!.</p>        
                    @endcan   
                
                <hr>
                <p class="mb-0">Pleas Check your notifications.</p>
            </div>
        @endif
            
            
    @endauth


    
@endsection