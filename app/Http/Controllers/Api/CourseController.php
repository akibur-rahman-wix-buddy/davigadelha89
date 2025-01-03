<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Get all courses.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $courses = Course::with('category', 'lessons')
                ->when($request->has('category_id'), function ($query) use ($request) {
                    $query->where('category_id', $request->category_id);
                })
                ->when($request->has('status'), function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->latest()
                ->paginate(10); // Adjust pagination as needed

            return response()->json([
                'success' => true,
                'message' => 'Courses retrieved successfully.',
                'data' => $courses,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch courses.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
