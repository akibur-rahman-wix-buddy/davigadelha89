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
                                <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i
                                        class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#"
                                    data-bs-toggle="card-remove"><i class="fe fe-x"></i>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="category_name" class="form-label f-w-500">Category :</label>
                                        <select name="category_id" class="form-select">
                                            <option value="">-- Select Type --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('category_id')
                                            <div style="color: red;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


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

                                {{-- <div class="col-12">
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
                                </div> --}}

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">
                                            Description :
                                        </label>
                                        <textarea id="body" name="body" class="ck-editor form-control">{{ old('body') }}</textarea>
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
                                

                                <!-- Lesson Fields Start Here -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <h4 class="form-label f-w-700 fs-5"> Create Lessons </h4>
                                        {{-- <label for="lessons" class="form-label f-w-900"> Create Lessons </label> --}}
                                        <div class="lesson-fields" id="lesson-fields">
                                            <div class="lesson-row" id="lesson-row-0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="lesson_title" class="form-label">
                                                                Lesson Title :
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                name="lessons[0][title]" placeholder="Lesson Title">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="lesson_description" class="form-label">
                                                                Lesson Description :
                                                            </label>
                                                            <textarea id="body" name="lessons[0][body]" class="ck-editor form-control">{{ old('body') }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="lesson_video" class="form-label">Video :</label>
                                                            <input type="file" class="form-control dropify"
                                                                name="lessons[0][video]">
                                                        </div>
                                                    </div>

                                                    <!-- Additional Inputs -->
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="total_yoga" class="form-label">Total Yoga
                                                                :</label>
                                                            <input type="number" class="form-control"
                                                                name="lessons[0][total_yoga]" placeholder="Total Yoga">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="break_time" class="form-label">
                                                                Break Time (in minutes) :
                                                            </label>
                                                            <input type="number" class="form-control"
                                                                name="lessons[0][break_time]" placeholder="Break Time">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="exercise_time" class="form-label">
                                                                Exercise Time (in minutes) :
                                                            </label>
                                                            <input type="number" class="form-control"
                                                                name="lessons[0][exercise_time]"
                                                                placeholder="Exercise Time">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="morning_meal" class="form-label">
                                                                Morning Meal :
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                name="lessons[0][morning_meal]"
                                                                placeholder="Morning Meal">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="lunch_meal" class="form-label">Lunch Meal
                                                                :</label>
                                                            <input type="text" class="form-control"
                                                                name="lessons[0][lunch_meal]" placeholder="Lunch Meal">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="workout_snack" class="form-label">
                                                                Workout Snack :
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                name="lessons[0][workout_snack]"
                                                                placeholder="Workout Snack">
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="dinner_meal" class="form-label">
                                                                Dinner Meal :
                                                            </label>
                                                            <input type="text" class="form-control"
                                                                name="lessons[0][dinner_meal]" placeholder="Dinner Meal">
                                                        </div>
                                                    </div>

                                                    <!-- Remove Button -->
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-dark remove-lesson-btn"
                                                            data-lesson-id="0">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" id="add-lesson" class="btn btn-info mt-2">Add
                                            Lesson</button>
                                    </div>
                                </div>
                                <!-- Lesson Fields End Here -->

                            </div>
                        </div>

                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-primary" type="submit">Create</button>
                    <a href="{{ route('course.create') }}" class="btn btn-warning">Cancel</a>
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
        let lessonIndex = 1; //! Start with the second lesson (first is index 0)

        $('#add-lesson').on('click', function() {
            let lessonRow = `
            <div class="lesson-row mt-3" id="lesson-row-${lessonIndex}">
                <h4 class="form-label f-w-700 fs-5"> Create Lessons </h4>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="lesson_title" class="form-label">Lesson Title</label>
                            <input type="text"
                                   class="form-control"
                                   name="lessons[${lessonIndex}][title]" placeholder="Lesson Title">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="lesson_description" class="form-label">Lesson Description</label>
                            <textarea id="lesson_description_${lessonIndex}" name="lessons[${lessonIndex}][body]" class="ck-editor form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="lesson_video" class="form-label">Video</label>
                             <input type="file" class="form-control dropify" name="lessons[${lessonIndex}][video]">
                        </div>
                    </div>

                    <!-- Additional Inputs -->
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="total_yoga" class="form-label">Total Yoga</label>
                            <input type="number"
                                   class="form-control"
                                   name="lessons[${lessonIndex}][total_yoga]" placeholder="Total Yoga">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="break_time" class="form-label">Break Time (in minutes)</label>
                            <input type="number"
                                   class="form-control"
                                   name="lessons[${lessonIndex}][break_time]" placeholder="Break Time">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="exercise_time" class="form-label">Exercise Time (in minutes)</label>
                            <input type="number"
                                   class="form-control"
                                   name="lessons[${lessonIndex}][exercise_time]" placeholder="Exercise Time">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="morning_meal" class="form-label">Morning Meal</label>
                            <input type="text"
                                   class="form-control"
                                   name="lessons[${lessonIndex}][morning_meal]" placeholder="Morning Meal">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="lunch_meal" class="form-label">Lunch Meal</label>
                            <input type="text"
                                   class="form-control"
                                   name="lessons[${lessonIndex}][lunch_meal]" placeholder="Lunch Meal">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="workout_snack" class="form-label">Workout Snack</label>
                            <input type="text"
                                   class="form-control"
                                   name="lessons[${lessonIndex}][workout_snack]" placeholder="Workout Snack">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="dinner_meal" class="form-label">Dinner Meal</label>
                            <input type="text"
                                   class="form-control"
                                   name="lessons[${lessonIndex}][dinner_meal]" placeholder="Dinner Meal">
                        </div>
                    </div>

                    <!-- Remove Button -->
                    <div class="col-12">
                        <button type="button" class="btn btn-dark remove-lesson-btn" data-lesson-id="${lessonIndex}">Remove</button>
                    </div>
                </div>
            </div>
        `;
            $('#lesson-fields').append(lessonRow);
            lessonIndex++;

            //! Initialize Dropify for new video input
            $('.dropify').dropify();


            //! Initialize CKEditor for new lesson description textarea
            ClassicEditor
                .create(document.querySelector(`#lesson_description_${lessonIndex - 1}`), {
                    removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption',
                        'ImageStyle', 'ImageToolbar', 'ImageUpload', 'MediaEmbed'
                    ],
                    height: '500px'
                })
                .catch(error => {
                    console.error(error);
                });

        });

        //! Remove lesson functionality
        $(document).on('click', '.remove-lesson-btn', function() {
            const lessonId = $(this).data('lesson-id');
            $(`#lesson-row-${lessonId}`).remove();
        });
    </script>


    {{-- ck editor start --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>

    <script>
        document.querySelectorAll('.ck-editor').forEach(element => {
            ClassicEditor
                .create(element, {
                    removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption',
                        'ImageStyle',
                        'ImageToolbar', 'ImageUpload', 'MediaEmbed'
                    ],
                    height: '500px'
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>

    {{-- ck editor end --}}
@endpush
