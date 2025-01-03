<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    /**
     * Get the list of PDFs.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Get all PDFs with optional filters (e.g., title, status)
        $query = Pdf::query();

        // Filter by title if provided
        if ($request->has('title') && $request->title !== null) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Filter by status if provided
        if ($request->has('status') && $request->status !== null) {
            $query->where('status', $request->status);
        }

        // Paginate the results (default: 10 per page)
        $perPage = $request->get('per_page', 10);
        $pdfs = $query->latest()->paginate($perPage);

        // Transform the data for API response
        $data = $pdfs->map(function ($pdf) {
            return [
                'id' => $pdf->id,
                'title' => $pdf->title,
                'file_path' => asset($pdf->file_path), // Full URL to the file
            ];
        });

        // Return paginated response
        return response()->json([
            'success' => true,
            'data' => $data,
            'pagination' => [
                'current_page' => $pdfs->currentPage(),
                'per_page' => $pdfs->perPage(),
                'total' => $pdfs->total(),
                'last_page' => $pdfs->lastPage(),
            ],
        ]);
    }

    /**
     * Show details of a specific PDF by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Find the PDF by ID
        $pdf = Pdf::find($id);

        // If PDF not found, return error
        if (!$pdf) {
            return response()->json([
                'success' => false,
                'message' => 'PDF not found',
            ], 404);
        }

        // Return the PDF details
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $pdf->id,
                'title' => $pdf->title,
                'file_path' => asset($pdf->file_path), // Full URL to the file
                'status' => $pdf->status,
                'created_at' => $pdf->created_at->toDateTimeString(),
                'updated_at' => $pdf->updated_at->toDateTimeString(),
            ],
        ]);
    }
}
