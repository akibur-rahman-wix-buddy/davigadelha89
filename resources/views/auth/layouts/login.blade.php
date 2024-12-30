@php

    $system =\App\Models\SystemSetting::first();

@endphp

@extends('auth.app')

@section('title','Login Page')

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
{{--                                <img class="img-fluid for-light" src="{{ asset($system->logo ?? "") }}" alt="logo" />--}}
                            @else
                                <img class="img-fluid for-light" src="{{asset('backend/images/logo/img34.png')}}" alt="looginpage">
                            @endif
                        </a>
                    </div>
                    <div class="login-main">
                        <!-- Session Status -->
                        <h6 class="text-center text-success">{{session('status')}}</h6>

                        <form class="theme-form" method="POST" action="{{ route('login') }}">
                            @csrf

                            <h4 class="text-center">Sign in to account</h4>
                            <p class="text-center">Enter your email & password to login</p>
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

                            <div class="form-group">
                                <label class="col-form-label" for="password">Password</label>
                                <div class="form-input position-relative">

                                    <input
                                        type="password"
                                        id="password"
                                        class="form-control @error('password') border-danger @enderror"
                                        name="password"
                                        placeholder="*********"
                                        aria-describedby="password" />

                                    <div class="show-hide"><span class="show">              </span></div>
                                </div>
                                @error('password')
                                <div style="color: red;">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <div class="checkbox p-0">
                                    <input type="checkbox" id="remember-me" />
                                    <label class="text-muted" for="remember-me"> Remember Me </label>
                                </div>

                                <a class="link" href="{{ route('password.request') }}">Forgot password?</a>

                                <div class="text-end mt-3">
                                    <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                                </div>
                            </div>
                            <div class="login-social-title">
                                <h6>Or Sign in with</h6>
                            </div>
                            <div class="form-group">
                                <ul class="login-social">
                                    <li><a href="https://www.linkedin.com/" target="_blank"><i data-feather="linkedin"></i></a></li>
                                    <li><a href="https://twitter.com/" target="_blank"><i data-feather="twitter"></i></a></li>
                                    <li><a href="https://www.facebook.com/" target="_blank"><i data-feather="facebook"></i></a></li>
                                    <li><a href="https://www.instagram.com/" target="_blank"><i data-feather="instagram"></i></a></li>
                                </ul>
                            </div>
                            <p class="mt-4 mb-0 text-center">Don't have account?<a class="ms-2" href="{{ route('register') }}">Create Account</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelectorAll('.show-hide');

            togglePassword.forEach(function (element) {
                element.addEventListener('click', function () {
                    const input = this.previousElementSibling;
                    const span = this.querySelector('span');

                    if (input.type === 'password') {
                        input.type = 'text';
                        //span.textContent = 'Hide'; // Change text to 'Hide'
                    } else {
                        input.type = 'password';
                        //span.textContent = 'Show'; // Change text to 'Show'
                    }
                });
            });
        });
    </script>
@endpush


