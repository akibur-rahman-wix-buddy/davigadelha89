<?php

namespace App\Http\Controllers\Web\Backend\Course;

use App\Helper\Helper;
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
        $categories = Category::all();
        $data = Course::latest();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($query) {
                    return $query->category->title;
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
                            <a href="' . route('course.edit', $data->id) . '" type="button" class="action edit text-success" title="Edit">
                            <i class="icon-pencil-alt"></i>
                            </a>&nbsp;
                            <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="action delete text-danger" title="Delete">
                            <i class="icon-trash"></i>
                          </a>
                        </div>';
                })

                ->addColumn('image', function ($data) {
                    $url = asset($data->image);
                    return '<img src="' . $url . '" alt="image" width="50px" height="50px" style="margin-left:20px;">';
                })

                ->rawColumns(['status', 'action', 'category', 'image'])
                ->make(true);
        }

        return view('backend.layouts.course.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $lessons = lesson::all();
        $courses = Course::all();
        return view('backend.layouts.course.create', compact('lessons', 'courses', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        //! Validate the request
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20348',
            'price' => 'required|numeric|min:0',


            'lessons.*.title' => 'required|string|max:255',
            'lessons.*.body' => 'nullable|string',
            'lessons.*.video' => 'nullable|mimes:mp4,mkv,avi,flv|max:51200',
            'lessons.*.total_yoga' => 'nullable|integer|min:0',
            'lessons.*.break_time' => 'nullable|integer|min:0',
            'lessons.*.exercise_time' => 'nullable|integer|min:0',
            'lessons.*.morning_meal' => 'nullable|string|max:255',
            'lessons.*.lunch_meal' => 'nullable|string|max:255',
            'lessons.*.workout_snack' => 'nullable|string|max:255',
            'lessons.*.dinner_meal' => 'nullable|string|max:255',
        ]);

        // dd($request->all());

        //! Create the course
        $data = new Course();
        $data->category_id = $request->category_id;
        $data->title = $request->title;
        $data->description = strip_tags($request->body);
        $data->price = $request->price;

        //! Image store in local
        $featuredImage = Helper::fileUpload($request->file('image'), 'product-image', $request->image);
        $data->image = $featuredImage;


        $data->save();

        $course = Course::latest()->first();

        //! Handle lessons
        if ($request->has('lessons')) {
            foreach ($request->lessons as $lessonData) {


                //! Video Upload
                if (isset($lessonData['video']) && $lessonData['video']) {
                    $videoFile = $lessonData['video'];
                    $videoPath = $videoFile ? Helper::videoUpload($videoFile, 'lesson-video', $lessonData['title']) : null;
                }

                //! Create the lesson
                $data->lessons()->create([
                    'title' => $lessonData['title'],
                    'description' => strip_tags($lessonData['body']),
                    'video' => $videoPath,
                    'total_yoga' => $lessonData['total_yoga'],
                    'break_time' => $lessonData['break_time'],
                    'exercise_time' => $lessonData['exercise_time'],
                    'morning_meal' => $lessonData['morning_meal'],
                    'lunch_meal' => $lessonData['lunch_meal'],
                    'workout_snack' => $lessonData['workout_snack'],
                    'dinner_meal' => $lessonData['dinner_meal'],
                ]);
            }
        }

        return redirect()->route('course.index')->with('success', 'Course created successfully!');
    }



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
