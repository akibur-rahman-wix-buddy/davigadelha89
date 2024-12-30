@php

    $system =\App\Models\SystemSetting::first();

@endphp

@extends('auth.app')

@section('title','Reset Password')

@section('content')
    <div class="row">
        <div class="col-12">
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
                            <form id="formAuthentication" class="theme-form" action="{{ route('password.store') }}" method="post">
                                @csrf
                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <h4>Reset Your Password</h4>

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
                                    <label class="col-form-label" for="password">New Password</label>
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
                                <button class="btn btn-primary btn-block w-100 mt-3" type="submit">Done</button>
                            </div>
                            <p class="mt-4 mb-0">Don't have account?<a class="ms-2" href="{{route('register')}}">Create Account</a></p>
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
