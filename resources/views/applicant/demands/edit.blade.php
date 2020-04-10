@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit a Demand</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('applicant.demands.update', $demand) }}">
                        @csrf
                        {{ method_field('PUT') }}

                        <div class="form-group row">
                            <label for="items" class="col-md-4 col-form-label text-md-right">Items</label>

                            <div class="col-md-6">
                                <select class="form-control" id="item" name="item">
                                    <option value="none">Select Item</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                  </select>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="descreption" class="col-md-4 col-form-label text-md-right">Descreption</label>

                            <div class="col-md-6">
                                <textarea class="form-control" name="descreption" id="descreption" rows="3" required autofocus>{{ $demand->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">Amount</label>

                            <div class="col-md-6">
                            <input id="qty" type="text" class="form-control" name="qty" value="{{ $demand->qty }}" required >    
                            </div>
                        </div>

                        <div class="form-group row">
                        <label for="dl" class="col-md-4 col-form-label text-md-right">Dead Line</label>

                            <div class="col-md-6">
                                <input id="dl" type="text" class="form-control" name="dl" value="{{ $demand->dl }}" required >    
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="urgent" class="col-md-4 col-form-label text-md-right">Urgent</label>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="radio" name="urgent" value="1">
                                    <label>Yes</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="urgent" value="0">
                                    <label>No</label>
                                </div>
                                
                            </div>
                        </div>

                    <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Demand
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
