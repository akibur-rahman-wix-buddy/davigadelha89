@extends('backend.app')

@section('title','System Settings')

@push('styles')
    <style>

        .dropify-wrapper .dropify-message p {
            font-size: 26px;
            margin: 5px 0 0;
        }
        .ck-editor__editable[role="textbox"] {
            min-height: 150px;
        }
    </style>
@endpush

@section('content')

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>System Settings</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item active"> System Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row">
                <div class="col-xl-12 col-lg-7">
                    <form class="card" method="POST" action="{{ route('settings.system.update') }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">System Settings</h4>
                            <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-500" for="email">Email Address :</label>
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               placeholder="Email" id="email" name="email"
                                               value="{{ $setting->email ?? 'admin@gmail.com' }}">
                                        @error('email')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label f-w-500">Title :</label>
                                        <input type="text"
                                               class="form-control @error('title') is-invalid @enderror"
                                               placeholder="Title" name="title" id="title"
                                               value="{{ $setting->title ?? 'Title' }}">
                                        @error('title')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-500" for="system_name">System Name :</label>
                                        <input type="text"
                                               class="form-control @error('system_name') is-invalid @enderror"
                                               placeholder="System Name" id="system_name" name="system_name"
                                               value="{{ $setting->system_name ?? 'System Name' }}">
                                        @error('system_name')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-500" for="copyright_text">Copy Rights Test :</label>
                                        <input type="text"
                                               class="form-control @error('copyright_text') is-invalid @enderror"
                                               placeholder="Copy Rights" name="copyright_text" id="copyright_text"
                                               value="{{ $setting->copyright_text ?? 'Text' }}">
                                        @error('copyright_text')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-500" for="logo">Logo :</label>
                                        <input type="file"
                                               class="form-control dropify @error('logo') is-invalid @enderror"
                                               id="logo" name="logo"
                                               data-default-file="@isset($setting){{ asset($setting->logo ?? 'backend/images/logo/logo.png') }}@endisset">
                                        @error('logo')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-500" for="logo">Favicon :</label>
                                        <input type="file"
                                               class="form-control dropify @error('favicon') is-invalid @enderror"
                                               name="favicon" id="favicon"
                                               data-default-file="@isset($setting){{ asset($setting->favicon ?? 'backend/images/favicon/favicon.png') }}@endisset">
                                        @error('favicon')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div>
                                        <label for="description" class="form-label f-w-500">About System :</label>
                                        <textarea placeholder="Type Here..." id="description" class="form-control" name="description">{{ $setting->description ?? '' }}</textarea>
                                        @error('description')
                                        <div style="color: red">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{route('settings.system.index')}}" class="btn btn-warning">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection


@push('scripts')
    <script>
        ClassicEditor
            .create(document.querySelector('#description'), {
                height: '500px'
            })
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#description1'), {
                height: '500px'
            })
            .catch(error => {
                console.error(error);
            });


        $('.dropify').dropify();



        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush
