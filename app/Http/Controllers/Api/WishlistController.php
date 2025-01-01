<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    public function toggleWishlist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first(),
                'code' => 422,
            ], 422);
        }

        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => 'Unauthorized',
                'code' => 401,
            ], 401);
        }

        // Check if the course is already in the wishlist
        $wishlistItem = Wishlist::where([
            'user_id' => $user->id,
            'course_id' => $request->course_id,
        ])->first();

        if ($wishlistItem) {
            // If the product is already in the wishlist, remove it
            $wishlistItem->delete();

            return response()->json([
                'status' => true,
                'message' => 'Course removed from wishlist',
                'code' => 200,
            ]);
        } else {
            // If the product is not in the wishlist, add it
            $wishlist = Wishlist::create([
                'user_id' => $user->id,
                'course_id' => $request->course_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Course added to wishlist',
                'code' => 200,
                'wishlist' => $wishlist,
            ]);
        }
    }




    public function viewWishlist()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => 'Unauthorized',
                'code' => 401,
            ], 401);
        }

        $wishlistItems = Wishlist::with('course')->where('user_id', $user->id)->get();

        if ($wishlistItems->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Wishlist is empty',
                'wishlist' => [],
                'code' => 200,
            ], 200);
        }

        $transformedWishlist = $wishlistItems->map(function ($item) {
            return [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'product_id' => $item->product_id,
                'product' => [
                    'id' => $item->product->id,
                    'name' => $item->product->name,
                    'selling_price' => $item->product->selling_price,
                    'image' => $item->product->image,
                ],
            ];
        });

        return response()->json([
            'status' => true,
            'code' => 200,
            'wishlist' => $transformedWishlist,
        ], 200);
    }




    public function clearAllCloset()
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => 'Unauthorized',
                'code' => 401,
            ], 401);
        }

        $deletedCount = Wishlist::where('user_id', $user->id)->delete();

        if ($deletedCount === 0) {
            return response()->json([
                'status' => true,
                'message' => 'Your wishlist is already empty',
                'code' => 200,
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'All items have been removed from your wishlist',
            'code' => 200,
        ], 200);
    }
}
