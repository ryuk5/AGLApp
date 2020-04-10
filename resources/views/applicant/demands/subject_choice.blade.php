@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Select Subject</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('applicant.demands.create') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="subjects" class="col-md-4 col-form-label text-md-right">Subjects</label>

                            <div class="col-md-6">
                                <select class="form-control" id="subject" name="subject">
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                  </select>
                            </div>
                        </div>

                        

                    <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Create Demand
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
