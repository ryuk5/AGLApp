@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit a Donation</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('giver.donations.update', $donation) }}">
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
                                <textarea class="form-control" name="descreption" id="descreption" rows="3" required autofocus>{{ $donation->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">Amount</label>

                            <div class="col-md-6">
                            <input id="qty" type="text" class="form-control" name="qty" value="{{ $donation->qty }}" required >    
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="location" class="col-md-4 col-form-label text-md-right">Location</label>

                            <div class="col-md-6">
                                <input id="location" type="text" class="form-control" name="location" value="{{ $donation->location }}" required >    
                            </div>
                        </div>

                        <div class="form-group row">
                        <label for="availability" class="col-md-4 col-form-label text-md-right">Availability</label>

                            <div class="col-md-6">
                                <input id="availability" type="text" class="form-control" name="availability" value="{{ $donation->availability }}" required >    
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="followed" class="col-md-4 col-form-label text-md-right">Followed</label>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="radio" name="followed" value="1"
                                    @if ($donation->followed == 1)
                                        checked
                                    @endif
                                    >
                                    <label>Yes</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="followed" value="0"
                                    @if ($donation->followed == 0)
                                        checked
                                    @endif
                                    >
                                    <label>No</label>
                                </div>
                                
                            </div>
                        </div>

                    <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Donation
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
