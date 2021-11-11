@extends('layout')
  
@section('content')
<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Phone Verification</div>
                  <div class="card-body">
  
                  <form action="{{ route('reverify.post') }}" method="POST">
                          @csrf
                          <div class="form-group row">
                              <label for="phone_number" class="col-md-4 col-form-label text-md-right">enter your registered Phone Number</label>
                              <div class="col-md-6">
                                  <input type="number" id="phone_number" class="form-control" name="phone_number" required autofocus>
                                  @if ($errors->has('phone_number'))
                                      <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                                  @endif
                              </div>
                          </div>

                          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                   
  
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  Verify
                              </button>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection