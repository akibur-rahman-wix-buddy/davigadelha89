<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Course;

use App\Models\Article;

class SearchController extends Controller
{
    /**
     * Search across multiple resources dynamically.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->input('q'); // Search query
        $type = $request->input('type'); // Type of resource to search (e.g., courses, users, articles)

        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Search query is required',
            ], 400);
        }

        // Map resource types to their respective models
        $modelMap = [
            'courses' =>   Course::class,
            'users' =>     User::class,
            'articles' =>  Article::class,
        ];

        // Check if the provided type exists in the map
        if (!array_key_exists($type, $modelMap)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid search type',
            ], 400);
        }

        // Dynamically resolve the model and perform the search
        $model = $modelMap[$type];
        $results = $model::where(function ($queryBuilder) use ($query, $model) {
            // Perform a dynamic search based on model attributes
            $searchableFields = $model::$searchable ?? ['title', 'description', 'name', 'content']; // Default fields
            foreach ($searchableFields as $field) {
                $queryBuilder->orWhere($field, 'LIKE', "%{$query}%");
            }
        })->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $results,
        ], 200);
    }
}
