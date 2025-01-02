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
use Illuminate\Support\Facades\File;

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

        //! Image store in public folder
        $featuredImage = Helper::fileUpload($request->file('image'), 'course-image', $request->image);
        $data->image = $featuredImage;


        $data->save();

        $course = Course::latest()->first();

        //! Handle lessons
        if ($request->has('lessons')) {
            foreach ($request->lessons as $lessonData) {

                $videoPath = null;

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

        $data = Course::find($id);
        // Check if course exists
        if (!$data) {
            return redirect()->route('course.index')->with('error', 'Course not found');
        }

        $categories = Category::all();
        return view('backend.layouts.course.edit', compact('categories', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4000',
        ]);

        $data = Course::find($id);

        $data->category_id = $request->category_id;
        $data->title = $request->title;
        $data->description = strip_tags($request->body);


        // Check if image exists and handle the update
        if ($request->hasFile('image')) {
            // Remove old image if it exists
            if ($data->image && File::exists(storage_path('app/public/' . $data->image))) {
                File::delete(storage_path('app/public/' . $data->image));
            }

            // Upload the new image
            $featuredImage = Helper::fileUpload($request->file('image'), 'course-image', $request->image);
            $data->image = $featuredImage;
        }

        $data->save();


        // Get the existing lesson IDs for comparison
        $existingLessonIds = $data->lessons->pluck('id')->toArray();

        // Loop through the lesson data
        foreach ($request->lessons as $lessonData) {
            if (isset($lessonData['id']) && in_array($lessonData['id'], $existingLessonIds)) {
                // Update existing lesson
                $lesson = Lesson::findOrFail($lessonData['id']);
            } else {
                // Create a new lesson
                $lesson = new Lesson();
                $lesson->course_id = $data->id;
            }


            //! Process video upload if exists
            if (isset($lessonData['video']) && $lessonData['video']) {
                $videoFile = $lessonData['video'];
                $videoPath = Helper::videoUpload($videoFile, 'lesson-video', $lessonData['title']);
            } else {
                // Use the existing lesson video if no new video is uploaded
                $videoPath = $lessonData['existing_lesson_video'] ?? $lesson->video;
            }


            // Update lesson details
            $lesson->title = $lessonData['title'];
            $lesson->description = strip_tags($lessonData['body']);
            $lesson->video = isset($videoPath) ? $videoPath : $lesson->video;
            $lesson->total_yoga = $lessonData['total_yoga'];
            $lesson->break_time = $lessonData['break_time'];
            $lesson->exercise_time = $lessonData['exercise_time'];
            $lesson->morning_meal = $lessonData['morning_meal'];
            $lesson->lunch_meal = $lessonData['lunch_meal'];
            $lesson->workout_snack = $lessonData['workout_snack'];
            $lesson->dinner_meal = $lessonData['dinner_meal'];

            $lesson->save();
        }

        // Optionally delete any remaining lessons  that were not in the request
        foreach ($existingLessonIds as $existingLessonId) {
            if (!collect($request->lessons)->contains('id', $existingLessonId)) {
                $lessonToDelete = Lesson::find($existingLessonId);
                if ($lessonToDelete) {
                    $lessonToDelete->delete();
                }
            }
        }

        return redirect()->route('course.index')->with('notify-success', 'Product Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Course::findOrFail($id);

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }

    /**
     * Update the status of a blog.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function status($id)
    {
        $data = Course::findOrFail($id);

        if ($data->status == 'active') {
            $data->status = 'inactive';
            $data->save();
            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
                'data' => $data,
            ]);
        } else {
            $data->status = 'active';
            $data->save();
            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data' => $data,
            ]);
        }
    }
}
