@extends('layout')
  
@section('content')
<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Login</div>
                  <div class="card-body">
                  @if (Session::has('errors'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('errors')->first() }}
                        </div>
                    @endif

                    @if (Session('status'))
                        <div class="alert alert-danger" role="alert">
                            Your account has not been verified, click the verify button to verify account
                            <a class="btn  btn-primary mx-sm-3" href= "{{ route('reverify') }}">Verify</a>

                        </div>                        

                    @endif

                    @if(session('success'))
                        <div class="alert alert-info"> 
                            Your Verification code is <strong>{{session('success')}}</strong> 
                            Please answer the call and follow the intruction. Once you are verified, you can then login
                            <a class="btn  btn-primary mx-sm-3" href= "{{ route('reverify') }}">Try again</a>
                        </div>
                    @endif

                      <form action="{{ route('login.post') }}" method="POST">
                          @csrf
                          <div class="form-group row">
                              <label for="phone_number" class="col-md-4 col-form-label text-md-right">Phone Number</label>
                              <div class="col-md-6">
                                  <input type="number" id="phone_number" class="form-control" name="phone_number" required autofocus>
                                  @if ($errors->has('phone_number'))
                                      <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                              <div class="col-md-6">
                                  <input type="password" id="password" class="form-control" name="password" required>
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>

                          <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                     
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  Login
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