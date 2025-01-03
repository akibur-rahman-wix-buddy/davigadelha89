<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\lesson;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Validation\ValidationException;

use App\Models\Article;

class SearchController extends Controller
{
    /**
     * Search across multiple resources dynamically.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
//    public function search(Request $request)
//    {
//        $query = $request->input('q'); // Search query
//        $type = $request->input('type'); // Type of resource to search (e.g., courses, users, articles)
//
//        if (!$query) {
//            return response()->json([
//                'success' => false,
//                'message' => 'Search query is required',
//            ], 400);
//        }
//
//        // Map resource types to their respective models
//        $modelMap = [
//            'courses' =>   Course::class,
//            'users' =>     User::class,
//            'articles' =>  Article::class,
//        ];
//
//        // Check if the provided type exists in the map
//        if (!array_key_exists($type, $modelMap)) {
//            return response()->json([
//                'success' => false,
//                'message' => 'Invalid search type',
//            ], 400);
//        }
//
//        // Dynamically resolve the model and perform the search
//        $model = $modelMap[$type];
//        $results = $model::where(function ($queryBuilder) use ($query, $model) {
//            // Perform a dynamic search based on model attributes
//            $searchableFields = $model::$searchable ?? ['title', 'description', 'name', 'content']; // Default fields
//            foreach ($searchableFields as $field) {
//                $queryBuilder->orWhere($field, 'LIKE', "%{$query}%");
//            }
//        })->paginate(10);
//
//        return response()->json([
//            'success' => true,
//            'data' => $results,
//        ], 200);
//    }

    public function search(Request $request)
    {
        try {
            // Validate the query
            $request->validate([
                'query' => 'required|string|max:255',
            ]);

            $query = $request->input('query');

            // Search in categories, courses, and lessons
            $categories = Category::where('name', 'LIKE', "%{$query}%")->get(['id', 'name', 'status']);
            $courses = Course::where('title', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->get(['id', 'title', 'description','status', 'category_id']);
            $lessons = Lesson::where('title', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->get(['id', 'title', 'description', 'course_id']);

            // Combine results
            $results = [
                'categories' => $categories,
                'courses' => $courses,
                'lessons' => $lessons,
            ];

            return response()->json(['status' => true, 'data' => $results], 200);
        } catch (ValidationException $e) {
            // Customize the error response
            return response()->json([
                'status' => false,
                'error' => $e->validator->errors()->first(),
                'code' => 422,
            ], 422);
        }
    }


}
