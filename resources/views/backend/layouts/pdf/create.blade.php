@extends('backend.app')

@section('title', 'Create PDF')

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
                    <h3>Create New Agreement File</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('pdf.index') }}">Create PDF</a>
                        </li>
{{--                        <li class="breadcrumb-item active"></li>--}}
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form class="card" method="POST" action="{{ route('pdf.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title mb-0">PDF Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                        <div class="mb-3">
                            <label for="name" class="form-label">PDF Title:</label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="Enter pdf title" value="{{ old('title') }}">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="file" class="form-label f-w-500">PDF File :</label>
                                <input class="form-control dropify @error('file') is-invalid @enderror"
                                       type="file" name="file">

                                @error('file')
                                <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('pdf.index') }}" class="btn btn-warning">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid ends -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });
    </script>
@endpush
