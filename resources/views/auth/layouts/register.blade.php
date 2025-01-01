@php

    $system =\App\Models\SystemSetting::first();

@endphp

@extends('auth.app')

@section('title','Registration Page')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="login-card">
                <div>
                    <div>
                        <a class="logo" href="">
                            @if (!empty($system->logo))
                                <img class="mb-3" width="150" height="100px" src="{{ asset($system->logo ?? "") }}" alt="logo" />
                            @else
                                <img class="img-fluid for-light" src="{{asset('backend/images/logo/img34.png')}}" alt="looginpage">
                            @endif
                        </a>
                    </div>
                    <div class="login-main">
                        <form id="formAuthentication" class="theme-form" action="{{ route('register') }}" method="post">
                            @csrf


                            <h4>Create your account</h4>
                            <p>Enter your personal details to create account</p>

                            <div class="form-group">
                                <label for="username" class="col-form-label">Name</label>
                                <input
                                    type="text"
                                    class="form-control @error('name') border-danger @enderror"
                                    id="name"
                                    name="name"
                                    placeholder="Enter name"
                                    autofocus />
                                @error('name')
                                <div style="color: red;">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email</label>
                                <input
                                    type="email"
                                    class="form-control @error('email') border-danger @enderror"
                                    id="email"
                                    name="email"
                                    required
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
                                        aria-describedby="password"
                                        required
                                        autocomplete="new-password" />

                                    <div class="show-hide"><span class="show">              </span></div>
                                </div>
                                @error('password')
                                <div style="color: red;">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="password_confirmation">Confirm Password</label>
                                <div class="form-input position-relative">

                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        class="form-control @error('password_confirmation') border-danger @enderror"
                                        name="password_confirmation"
                                        placeholder="*********"
                                        aria-describedby="password"
                                        required
                                        autocomplete="new-password" />

                                    <div class="show-hide"><span class="show"></span></div>
                                </div>
                                @error('password_confirmation')
                                <div style="color: red;">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <div class="checkbox p-0">
                                    <input type="checkbox" id="remember-me" />
                                    <label class="text-muted" for="remember-me"> Remember Me </label>
                                </div>
                                <button class="btn btn-primary btn-block w-100 mt-3" type="submit">Create Account</button>
                            </div>

                            <div class="login-social-title">
                                <h6>Or Sign in with                 </h6>
                            </div>
                            <div class="form-group">
                                <ul class="login-social">
                                    <li><a href="https://www.linkedin.com/" target="_blank"><i data-feather="linkedin"></i></a></li>
                                    <li><a href="https://twitter.com/" target="_blank"><i data-feather="twitter"></i></a></li>
                                    <li><a href="https://www.facebook.com/" target="_blank"><i data-feather="facebook"></i></a></li>
                                    <li><a href="https://www.instagram.com/" target="_blank"><i data-feather="instagram"></i></a></li>
                                </ul>
                            </div>
                            <p class="mt-4 mb-0 text-center">Already have an account?<a class="ms-2" href="{{route('login')}}">Sign in</a></p>
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
                    } else {
                        input.type = 'password';
                    }
                });
            });
        });
    </script>
@endpush
