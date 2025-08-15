@extends('auth.body.main')

@section('container')
<div class="row align-items-center justify-content-center height-self-center">
    <div class="col-lg-8">
        <div class="card auth-card">
            <div class="card-body p-0">
                <div class="d-flex align-items-center auth-content">
                    <div class="col-lg-7 align-self-center">
                        <div class="p-3">

                            <h2 class="mb-2">{{ __('Log In') }}</h2>
                            <p>{{ __('Entrez votre adresse e-mail et votre mot de passe pour accéder au panneau d\'administration.') }}</p>

                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control @error('email') is-invalid @enderror @error('username') is-invalid @enderror" type="text" name="input_type" placeholder=" " value="{{ old('input_type') }}" autocomplete="off" required autofocus>
                                            <label>{{ __('Email/Username') }}</label>
                                        </div>
                                        @error('username')
                                        <div class="mb-4" style="margin-top: -20px">
                                            <div class="text-danger small">{{ __('Incorrect username or password.') }}</div>
                                        </div>
                                        @enderror
                                        @error('email')
                                        <div class="mb-4" style="margin-top: -20px">
                                            <div class="text-danger small">{{ __('Incorrect username or password.') }}</div>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="floating-label form-group">
                                            <input class="floating-input form-control @error('email') is-invalid @enderror @error('username') is-invalid @enderror" type="password" name="password" placeholder=" " required>
                                            <label>{{ __('Password') }}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <p>
                                            {{ __("Don't have an account?") }} <a href="{{ route('register') }}" class="text-primary">{{ __('Sign Up') }}</a>
                                        </p>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="#" class="text-primary float-right">{{ __('Forgot Password?') }}</a>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('Log In') }}</button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-5 content-right">
                        <img src="{{ asset('assets/images/login/01.png') }}" class="img-fluid image-right" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
