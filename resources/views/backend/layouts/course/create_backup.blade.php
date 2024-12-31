@extends('backend.app')

@section('title', 'Course Create')

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
                    <h3>Course Create Form</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('course.index') }}"><i data-feather="skip-back"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item active"> Course Create</li>
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
                    <form class="card" method="POST" action="{{ route('course.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <h4 class="card-title mb-0">Course Create</h4>
                            <div class="card-options">
                                <a class="card-options-collapse" href="#"
                                    data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                    class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                        class="fe fe-x"></i>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-12">
                                    <div class="mb-3">

                                        <label for="category_name" class="form-label f-w-500">Category :</label>
                                        <select name="category_id" class="form-select">
                                            <option value="">-- Select Type --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('category_id')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div> --}}

                                

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="title" class="form-label f-w-500">Title :</label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            placeholder="title" name="title" id="title" value="{{ old('title') }}">
                                        @error('title')
                                            <div style="color: red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>                                

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label f-w-500">Description :</label>
                                        <input type="text"
                                            class="form-control @error('description') is-invalid @enderror"
                                            placeholder="Code" name="description" id="description"
                                            value="{{ old('description') }}">
                                        @error('description')
                                            <div style="color: red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="image" class="form-label f-w-500">Image :</label>
                                        <input class="form-control dropify @error('image') is-invalid @enderror"
                                            type="file" name="image">

                                        @error('image')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="price" class="form-label f-w-500">Price :</label>
                                        <textarea class="form-control @error('price') is-invalid @enderror" placeholder="price"
                                            name="price" id="price">{{ old('price') }}</textarea>
                                        @error('price')
                                            <div style="color: red">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> 

                                <!-- Variant Fields -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="variants" class="form-label f-w-500">Variants :</label>
                                        <div class="variant-fields" id="variant-fields">
                                            <div class="variant-row">
                                                <div class="row">

                                                    <!-- Color -->

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="color" class="form-label">Color</label>
                                                            <input type="text"
                                                                class="form-control @error('variants.0.color') is-invalid @enderror"
                                                                name="variants[0][color]" placeholder="Variant Color"
                                                                value="{{ old('variants.0.color') }}" required>
                                                            @error('variants.0.color')
                                                                <div style="color: red">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- Color Code -->
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="color_code" class="form-label">Color Code</label>
                                                            <!-- Color Picker Input -->
                                                            <input type="color"
                                                                class="form-control form-control-color @error('variants.0.color_code') is-invalid @enderror"
                                                                id="colorPicker"
                                                                value="{{ old('variants.0.color_code', '#000000') }}">

                                                            <!-- HEX Code Input -->
                                                            <input type="text"
                                                                class="form-control mt-2 @error('variants.0.color_code') is-invalid @enderror"
                                                                name="variants[0][color_code]" id="colorHex"
                                                                placeholder="Variant Color Code"
                                                                value="{{ old('variants.0.color_code', '#000000') }}"
                                                                required>

                                                            <!-- Error Display -->
                                                            @error('variants.0.color_code')
                                                                <div style="color: red">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>


                                                    <!-- Quantity -->
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="quantity" class="form-label">Quantity</label>
                                                            <input type="number"
                                                                class="form-control @error('variants.0.quantity') is-invalid @enderror"
                                                                name="variants[0][quantity]"
                                                                placeholder="Variant Quantity" min="1"
                                                                value="{{ old('variants.0.quantity') }}" required>
                                                            @error('variants.0.quantity')
                                                                <div style="color: red">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <!-- Variant Image -->
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="variant_image" class="form-label">Variant
                                                                Image</label>
                                                            <input type="file"
                                                                class="form-control dropify @error('variants.0.variant_image') is-invalid @enderror"
                                                                name="variants[0][variant_image]" required>
                                                            @error('variants.0.variant_image')
                                                                <div style="color: red">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" id="add-variant" class="btn btn-success mt-2">Add
                                            Variant</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Create</button>
                    <a href="{{ route('product.create') }}" class="btn btn-warning">Cancel</a>
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

        ClassicEditor
            .create(document.querySelector('#sub_description'), {
                height: '500px'
            })
            .catch(error => {
                console.error(error);
            });


        // $('.dropify').dropify();



        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>


    <script>
        // Add Variant functionality
        let variantIndex = 1; // Start with the second variant (first is index 0)
        $('#add-variant').on('click', function() {
            let variantRow = `
            <div class="variant-row" id="variant-row-${variantIndex}">
                <div class="row">
                    <!-- Color -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="color" class="form-label">Color</label>
                            <input type="text"
                                   class="form-control"
                                   name="variants[${variantIndex}][color]"
                                   placeholder="Variant Color">
                        </div>
                    </div>

                    <!-- Color Code -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="color_code" class="form-label">Color Code</label>

                            <!-- Color Picker Input -->
                            <input type="color"
                                   class="form-control form-control-color"
                                   id="colorPicker_${variantIndex}"
                                   value="#000000">

                            <!-- HEX Code Input -->
                            <input type="text"
                                   class="form-control mt-2"
                                   name="variants[${variantIndex}][color_code]"
                                   id="colorHex_${variantIndex}"
                                   placeholder="Variant Color Code"
                                   value="#000000">
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number"
                                   class="form-control"
                                   name="variants[${variantIndex}][quantity]"
                                   placeholder="Variant Quantity"
                                   min="1">
                        </div>
                    </div>

                    <!-- Variant Image -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="variant_image" class="form-label">Variant Image</label>
                            <input type="file"
                                   class="form-control dropify"
                                   name="variants[${variantIndex}][variant_image]">
                        </div>
                    </div>
                </div>
            </div>
        `;
            $('#variant-fields').append(variantRow);
            $('.dropify').dropify();

            // Synchronize color picker with HEX input
            synchronizeColorPicker(variantIndex);

            variantIndex++;
        });

        // Function to synchronize color picker and HEX input
        function synchronizeColorPicker(index) {
            const colorPicker = $(`#colorPicker_${index}`);
            const colorHex = $(`#colorHex_${index}`);

            // Update HEX input when the color picker changes
            colorPicker.on('input', function() {
                colorHex.val(colorPicker.val());
            });

            // Update color picker when the HEX input changes
            colorHex.on('input', function() {
                if (/^#[0-9A-Fa-f]{6}$/.test(colorHex.val())) {
                    colorPicker.val(colorHex.val());
                }
            });
        }
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const colorPicker = document.getElementById('colorPicker');
            const colorHex = document.getElementById('colorHex');

            // Update the HEX input when the color picker value changes
            colorPicker.addEventListener('input', function() {
                colorHex.value = colorPicker.value;
            });

            // Optional: Sync the picker when HEX input is updated manually
            colorHex.addEventListener('input', function() {
                if (/^#([0-9A-F]{3}){1,2}$/i.test(colorHex.value)) {
                    colorPicker.value = colorHex.value;
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const colorPicker = document.getElementById('colorPicker');
            const colorHex = document.getElementById('colorHex');

            // Update the HEX input when the color picker value changes
            colorPicker.addEventListener('input', function() {
                colorHex.value = colorPicker.value;
            });

            // Optional: Sync the picker when HEX input is updated manually
            colorHex.addEventListener('input', function() {
                if (/^#([0-9A-F]{3}){1,2}$/i.test(colorHex.value)) {
                    colorPicker.value = colorHex.value;
                }
            });
        });
    </script>
@endpush
