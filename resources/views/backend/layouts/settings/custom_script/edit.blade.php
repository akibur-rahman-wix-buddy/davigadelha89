@extends('backend.app')

@section('title', 'Custom Script Edit')

@push('styles')
    <style>
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
                    <h3>Custom Script Form</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('settings.custom-script.index')}}"><i data-feather="skip-back"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item active"> Custom Script</li>
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
                    <form class="card" method="POST" action="{{ route('settings.custom-script.update',['id' => $custom_script->id]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">Custom Script Edit</h4>
                            <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="title" class="form-label f-w-500">Type :</label>
                                        <select name="type" class="form-select">
                                            <option value="">-- Select Type --</option>
                                            <option value="header" {{$custom_script->type == 'header' ? 'selected' : ''}}>Header</option>
                                            <option value="footer" {{$custom_script->type == 'footer' ? 'selected' : ''}}>Footer</option>
                                        </select>
                                        @error('type')
                                        <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div>
                                        <label for="script_content" class="form-label f-w-500">Content :</label>
                                        <textarea name="script_content" class="form-control @error('script_content') is-invalid @enderror" id="script_content" cols="" rows="">{{$custom_script->script_content}}</textarea>
                                        @error('script_content')
                                        <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a href="{{ route('settings.custom-script.edit',['id' => $custom_script->id]) }}" class="btn btn-warning">Cancel</a>
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
            .create(document.querySelector('#content'), {
                height: '500px'
            })
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#content1'), {
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

