@extends('backend.app')

@section('title', 'Courses and Lessons')

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Courses and Lessons Information</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Data Table</li>
                        <li class="breadcrumb-item active">Courses and Lessons</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4>Courses and Lessons Information</h4>
                    </div>
                    <div class="card-header pb-0" style="display: flex; justify-content: end;">
                        <a href="{{ route('course.create') }}" class="btn btn-primary">
                            Create Course
                        </a>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive theme-scrollbar">
                            <table class="display" id="data-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Course Title</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Lesson Title</th>
                                        <th>Lesson Description</th>
                                        <th>Total Yoga</th>
                                        <th>Break Time</th>
                                        <th>Exercise Time</th>
                                        <th>Morning Meal</th>
                                        <th>Lunch Meal</th>
                                        <th>Workout Snack</th>
                                        <th>Dinner Meal</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be populated here through AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });

            if (!$.fn.DataTable.isDataTable('#data-table')) {
                $('#data-table').DataTable({
                    order: [],
                    lengthMenu: [
                        [25, 50, 100, 200, 500, -1],
                        [25, 50, 100, 200, 500, "All"]
                    ],
                    processing: true,
                    responsive: true,
                    serverSide: true,
                    language: {
                        processing: `Loading data...`
                    },
                    pagingType: "full_numbers",
                    dom: "<'row justify-content-between table-topbar'<'col-md-2 col-sm-4 px-0'l><'col-md-2 col-sm-4 px-0'f>>tipr",
                    ajax: {
                        url: "{{ route('course.index') }}",  // Adjust the URL to your route if needed
                        type: "GET",
                        dataSrc: function(response) {
                            let data = response.data; // Assuming `data` contains the courses info
                            let rows = "";
                            data.forEach(function(course, index) {
                                let lessons = course.lessons.map(function(lesson) {
                                    return `
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td>${course.category.name}</td>
                                            <td>${course.title}</td>
                                            <td>${course.description.substring(0, 50)}...</td>
                                            <td>$${course.price.toFixed(2)}</td>
                                            <td>${course.status.charAt(0).toUpperCase() + course.status.slice(1)}</td>
                                            <td>${lesson.title}</td>
                                            <td>${lesson.description.substring(0, 50)}...</td>
                                            <td>${lesson.total_yoga}</td>
                                            <td>${lesson.break_time} min</td>
                                            <td>${lesson.exercise_time} min</td>
                                            <td>${lesson.morning_meal}</td>
                                            <td>${lesson.lunch_meal}</td>
                                            <td>${lesson.workout_snack}</td>
                                            <td>${lesson.dinner_meal}</td>
                                            <td>
                                                <a href="{{ route('course.edit', ':id') }}".replace(':id', ${course.id}) class="btn btn-warning btn-sm">Edit</a>
                                                <a href="javascript:void(0);" onclick="showDeleteConfirm(${course.id})" class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    `;
                                }).join('');

                                rows += lessons;
                            });

                            // Insert rows into the tbody
                            $('#data-table tbody').html(rows);
                        }
                    },
                    columns: [
                        { data: 'id', name: 'id', orderable: false, searchable: false },
                        { data: 'category_name', name: 'category_name', orderable: true, searchable: true },
                        { data: 'title', name: 'title', orderable: true, searchable: true },
                        { data: 'description', name: 'description', orderable: true, searchable: true },
                        { data: 'price', name: 'price', orderable: true, searchable: true },
                        { data: 'status', name: 'status', orderable: true, searchable: true },
                        { data: 'lesson_title', name: 'lesson_title', orderable: false, searchable: false },
                        { data: 'lesson_description', name: 'lesson_description', orderable: false, searchable: false },
                        { data: 'total_yoga', name: 'total_yoga', orderable: false, searchable: false },
                        { data: 'break_time', name: 'break_time', orderable: false, searchable: false },
                        { data: 'exercise_time', name: 'exercise_time', orderable: false, searchable: false },
                        { data: 'morning_meal', name: 'morning_meal', orderable: false, searchable: false },
                        { data: 'lunch_meal', name: 'lunch_meal', orderable: false, searchable: false },
                        { data: 'workout_snack', name: 'workout_snack', orderable: false, searchable: false },
                        { data: 'dinner_meal', name: 'dinner_meal', orderable: false, searchable: false },
                        { data: 'action', name: 'action', orderable: false, searchable: false }
                    ]
                });
            }
        });

        // Status Change Confirm Alert
        function showDeleteConfirm(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to delete this course?',
                text: 'If you delete this, all its lessons will also be deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteItem(id);
                }
            });
        }

        // Delete Course
        function deleteItem(id) {
            let url = '{{ route('course.destroy', ':id') }}';
            let csrfToken = '{{ csrf_token() }}';
            $.ajax({
                type: "DELETE",
                url: url.replace(':id', id),
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(resp) {
                    if (resp.success === true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Deleted Successfully",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#data-table').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: resp.message
                        });
                    }
                },
                error: function(error) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!"
                    });
                }
            })
        }
    </script>
@endpush
