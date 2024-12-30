@extends('backend.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Stripe Settings</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item"> Form Layout</li>
                        <li class="breadcrumb-item active"> Stripe Settings</li>
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
                                <h4>Stripe Settings</h4>
                            </div>
                            <div class="card-body">
                                <form class="theme-form" action="{{route('settings.stripe.update')}}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0" for="stripe_key">STRIPE KEY :</label>
                                        <input type="text"
                                               id="stripe_key"
                                               class="form-control @error('stripe_key') is-invalid @enderror"
                                               placeholder="ENTER STRIPE KEY" name="stripe_key" value="{{ env('STRIPE_KEY') }}" required>
                                        @error('stripe_key')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0">STRIPE SECRET :</label>
                                        <input type="text"
                                               id="stripe_secret"
                                               class="form-control @error('stripe_secret') is-invalid @enderror"
                                               placeholder="ENTER STRIPE SECRET" name="stripe_secret" value="{{ env('STRIPE_SECRET') }}"
                                               required>
                                        @error('stripe_secret')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="card-footer text-end">
                                        <button class="btn btn-primary">Submit</button>
                                        <a href="{{ route('settings.stripe.index') }}" class="btn btn-warning">Cancel</a>
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
