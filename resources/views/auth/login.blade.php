@extends('layouts.auth-master')

@section('content')
<div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">NiceAdmin</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your email id & password to login</p>
                  </div>

				<form method="post" class="row g-3 needs-validation"  action="{{ route('login.perform') }}">
        
				@include('layouts.partials.messages')
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />		
                    <div class="col-12">
                      <label for="email_id" class="form-label">Email Id</label>
                      
                        <input type="text"  name="username" value="{{ old('username') }}" id="email_id" class="form-control"  required>
						 @if ($errors->has('username'))
							<div class="invalid-feedback">{{ $errors->first('username') }}</div>
						@endif

                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password"  name="password" value="{{ old('password') }}"  class="form-control" required>
					   @if ($errors->has('password'))
							<div class="invalid-feedback">Please enter your password!</div>
						@endif
                    </div>
                    <div class="col-12">
                      <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>					   
                    </div>
                   
                  </form>

                </div>
              </div>

             
            </div>
          </div>
        </div>

      </section>

    </div>
	
	
@endsection