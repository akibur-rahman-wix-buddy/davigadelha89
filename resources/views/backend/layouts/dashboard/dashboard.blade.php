@php
    $users = null;
    if (auth()->check()) {
        $userId = \Illuminate\Support\Facades\Auth::id();

        // Query the users table to get the user with the given ID
        $users = \App\Models\User::where('id', $userId)->first();
    }
@endphp




@extends('backend.app')

@section('title', 'Dashboard Page')

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid dashboard-default">
        <div class="row">
            <div class="col-10">
                <div class="card profile-greeting">
                    <div class="card-body">
                        <div class="d-sm-flex d-block justify-content-between">
                            <div class="flex-grow-1">

                            </div>
                            <div class="badge-group">
                                <div class="badge badge-light-primary f-12"><i class="fa fa-clock-o"></i><span
                                        id="txt"></span></div>
                            </div>
                        </div>
                        <div class="greeting-user">
                            <div class="profile-vector">
                                <ul class="dots-images">
                                    <li class="dot-small bg-info dot-1"></li>
                                    <li class="dot-medium bg-primary dot-2"></li>
                                    <li class="dot-medium bg-info dot-3"></li>
                                    <li class="semi-medium bg-primary dot-4"></li>
                                    <li class="dot-small bg-info dot-5"></li>
                                    <li class="dot-big bg-info dot-6"></li>
                                    <li class="dot-small bg-primary dot-7"></li>
                                    <li class="semi-medium bg-primary dot-8"></li>
                                    <li class="dot-big bg-info dot-9"></li>
                                </ul>
                                @isset($users)
                                    @if ($users->avatar)
                                        <img id="avatar" src="{{ asset($users->avatar) }}" alt="Avatar"
                                             class="rounded-circle" height="50" width="50">
                                    @else
                                        <img src="{{ asset('backend/images/dashboard/default/profile.png') }}" class="img-fluid"
                                             alt="">
                                    @endif
                                @else
                                    <img src="{{ asset('backend/images/dashboard/default/profile.png') }}" class="img-fluid"
                                         alt="">
                                @endisset
                                <ul class="vector-image">
                                    <li> <img src="{{ asset('backend/images/dashboard/default/ribbon1.png') }}"
                                              alt=""></li>
                                    <li> <img src="{{ asset('backend/images/dashboard/default/ribbon3.png') }}"
                                              alt=""></li>
                                    <li> <img src="{{ asset('backend/images/dashboard/default/ribbon4.png') }}"
                                              alt=""></li>
                                    <li> <img src="{{ asset('backend/images/dashboard/default/ribbon5.png') }}"
                                              alt=""></li>
                                    <li> <img src="{{ asset('backend/images/dashboard/default/ribbon6.png') }}"
                                              alt=""></li>
                                    <li> <img src="{{ asset('backend/images/dashboard/default/ribbon7.png') }}"
                                              alt=""></li>
                                </ul>
                            </div>
                            <h4><a href="{{ route('settings.profile') }}"><span>Welcome Back</span>
                                    {{ Auth::user()->name ?? '' }} </a><span class="right-circle"><i
                                        class="fa fa-check-circle font-primary f-14 middle"></i></span></h4>
                            <div><span class="badge badge-primary"></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-12 order-1">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body ">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0 d-flex align-items-center">
                                        <img   style="width: 50px; height: 50px"
                                               src="{{ asset('backend/images/profile-avatar.png') }}"
                                               alt="user"
                                               class="rounded"
                                        />
                                    </div>

                                </div>
                                <span class="fw-semibold d-block mb-1">Total User</span>
                                <h3 class="card-title mb-2">{{ \App\Models\User::count() }}</h3>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img  style="width: 50px; height: 50px"
                                              src="{{ asset('backend/images/order.jpg') }}"
                                              alt="Credit Card"
                                              class="rounded"
                                        />
                                    </div>

                                </div>
                                <span class="fw-semibold d-block mb-1">Total Order</span>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>


        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
