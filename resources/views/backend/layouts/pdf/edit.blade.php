@extends('backend.app')

@section('title', 'Edit PDF')

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Edit Agreement File</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i data-feather="home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('pdf.index') }}">Agreement Files</a>
                        </li>
                        <li class="breadcrumb-item active">Edit PDF</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form class="card" method="POST" action="{{ route('pdf.update', ['id' => $data->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h4 class="card-title mb-0">Agreement File Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">PDF Title:</label>
                                <input type="text" name="title" id="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       placeholder="Enter Title" value="{{ old('title', $data->title) }}">
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="file" class="form-label f-w-500">Current PDF File:</label>
                                @if($data->file_path)
                                    <!-- Display the current file link -->
                                    <p>
                                        <a href="{{ asset($data->file_path) }}" target="_blank" class="btn btn-link">View Current PDF</a>
                                    </p>
                                @else
                                    <p>No file uploaded.</p>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label f-w-500">Upload New PDF File (optional):</label>
                                <input class="form-control dropify @error('file') is-invalid @enderror"
                                       type="file" name="file" accept="application/pdf">
                                @error('file')
                                <div style="color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('category.index') }}" class="btn btn-warning">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container-fluid ends -->
@endsection
