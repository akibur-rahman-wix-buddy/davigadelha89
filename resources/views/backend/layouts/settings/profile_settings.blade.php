@extends('backend.app')

@section('title', 'Profile settings')

@push('styles')
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 18px;
            margin: 5px 0 0 0;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Profile Settings</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"> Form Layout</li>
                        <li class="breadcrumb-item active"> Profile Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4>My Profile</h4>
                            </div>
                            <div class="card-body">
                                <form class="theme-form" action="{{ route('settings.update-profile') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0" for="avatar">User Avatar:</label>
                                        <input type="file" name="avatar" data-default-file="@isset($users){{ asset($users->avatar ?? '') }}@endisset" id="avatar" class="form-control dropify w-50 @error('avatar') border-danger @enderror" data-height="100" />
                                        @error('avatar')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0" for="exampleInputEmail1">User Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ Auth::user()->name ?? ''}}" type="text" aria-describedby="emailHelp" placeholder="Enter your name">
                                        @error('name')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0" for="exampleInputEmail1">Email Address</label>
                                        <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ Auth::user()->email ?? ''}}" type="email" aria-describedby="emailHelp" placeholder="Enter email" readonly>
                                        @error('email')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary">Submit</button>
                                        <a href="{{route('settings.profile')}}" class="btn btn-warning">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4>Update Your Password</h4>
                            </div>
                            <div class="card-body">
                                <form class="theme-form" action="{{ route('settings.update-password') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0" for="old_password">Current Password :</label>
                                        <input type="password"
                                               class="form-control @error('old_password') is-invalid @enderror"
                                               placeholder="Current Password" id="old_password" name="old_password"
                                               value="{{old('old_password')}}">
                                        @error('old_password')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0" for="password">New Password :</label>
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="New Password" id="password" name="password"
                                               value="{{old('password')}}">
                                        @error('password')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">

                                        <label class="col-form-label pt-0" for="password_confirmation">Confirm Password :</label>
                                        <input type="password"
                                               class="form-control @error('password_confirmation') is-invalid @enderror"
                                               placeholder="Confirm Password" id="password_confirmation" name="password_confirmation"
                                               value="">
                                        @error('password_confirmation')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary">Submit</button>
                                        <a href="{{route('settings.profile')}}" class="btn btn-warning">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection



