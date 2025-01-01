<?php

namespace App\Http\Controllers\Web\Backend\Course;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\lesson;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Course::latest();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($data) {

                    return $data->category->name;
                })
                ->addColumn('status', function ($data) {
                    $status = '<div class="switch-sm icon-state">';
                    $status .= '<label class="switch">';
                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" name="status"';

                    if ($data->status == "active") {
                        $status .= ' checked';
                    }

                    $status .= '>';
                    $status .= '<span class="switch-state"></span>';
                    $status .= '</label>';
                    $status .= '</div>';

                    return $status;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <a href="' . route('courses.edit', $data->id) . '" type="button" class="action edit text-success" title="Edit">
                            <i class="icon-pencil-alt"></i>
                            </a>&nbsp;
                            <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="action delete text-danger" title="Delete">
                            <i class="icon-trash"></i>
                          </a>
                        </div>';
                })
                ->rawColumns(['status', 'action', 'category'])
                ->make(true);
        }

        return view('backend.layouts.course.index'); // Ensure this view exists
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $lessons = lesson::all();
        $courses = Course::all();
        return view('backend.layouts.course.create', compact( 'lessons', 'courses', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

    



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
