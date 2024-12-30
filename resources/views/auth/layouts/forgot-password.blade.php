@php

    $system =\App\Models\SystemSetting::first();

@endphp

@extends('auth.app')

@section('title','Forget Password')

@section('content')
    <div class="row">
        <div class="col-xl-5"><img class="bg-img-cover bg-center" src="{{asset('backend/images/login/3.jpg')}}" alt="looginpage"></div>
        <div class="col-xl-7 p-0">
            <div class="login-card">
                <div>
                    <div>
                        <a class="logo" href="{{route('login')}}">
                            @if (!empty($system->logo))
                                <img class="mb-3" width="150" height="100px" src="{{ asset($system->logo ?? "") }}" alt="logo" />
                            @else
                                <img class="img-fluid for-light" src="{{asset('backend/images/logo/bag-logo.png')}}" alt="looginpage">
                            @endif
                        </a>
                    </div>
                    <div class="login-main">


                        <!-- Session Status -->
                        <h6 class="text-center text-success">{{session('status')}}</h6>

                        <form class="theme-form" method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- /Logo -->
                            <h4 class="text-center">Forgot Password? 🔒</h4>
                            <p class="text-center">Enter your email and we'll send you instructions to reset your password</p>

                            <div class="form-group">
                                <label for="email" class="col-form-label">Email</label>
                                <input
                                    type="email"
                                    class="form-control @error('email') border-danger @enderror"
                                    id="email"
                                    name="email"
                                    placeholder="Enter email"
                                    autofocus />
                                @error('email')
                                <div style="color: red;">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <div class="text-end mt-3">
                                    <button class="btn btn-primary btn-block w-100" type="submit">Send Password Reset Link</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
