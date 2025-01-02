<?php

namespace App\Http\Controllers\Web\Backend\Pdf;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class PdfController extends Controller
{
    public function index(Request $request)
    {
        $data = Pdf::latest();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($data) {
                    $status = '';
                    $status .= '<div class="switch-sm icon-state">';
                    $status .= '<label class="switch">';
                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';

                    // Check if the status is active
                    if ($data->status == "active") {
                        $status .= ' checked';
                    }

                    $status .= '>';
                    $status .= '<span class="switch-state"></span>'; // This is the visual switch
                    $status .= '</label>';
                    $status .= '</div>';
                    $status .= '</div>';

                    return $status;
                })
                ->addColumn('action', function ($data) {

                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                  <a href="' . route('pdf.edit',  $data->id) . '" type="button" class="action edit text-success" title="Edit">
                                  <i class="icon-pencil-alt"></i>
                                  </a>&nbsp;
                                  <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="action delete text-danger" title="Delete">
                                  <i class="icon-trash"></i>
                                </a>
                                </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('backend.layouts.pdf.index');
    }

    public function create()
    {
        return view('backend.layouts.pdf.create');
    }

//    public function store(Request $request)
//    {
////        dd($request->all());
//        $request->validate([
//            'title' => 'required|string|max:255',
////            'file_path' => 'required|mimes:pdf|max:2048', // max size 2MB
//        ]);
//
//        $filePath = $request->file('file')->store('pdfs', 'public');
//
//        $data = new Pdf();
//        $data->title = $request->title;
//        $data->file_path = $filePath;
//        $data->save();
//
//        return redirect()->route('pdf.index')->with('notify-success', 'Pdf Created Successfully');
//    }

//    public function store(Request $request)
//    {
//        $request->validate([
//            'title' => 'required|string|max:255',
//            'file_path' => 'required|mimes:pdf|max:2048', // max size 2MB
//        ]);
//
//        // Use the helper method for file upload
//        $filePath = Helper::fileUpload($request->file('file'), 'pdfs', $request->title);
//
//        if (!$filePath) {
//            return redirect()->back()->withErrors(['file' => 'File upload failed. Please try again.']);
//        }
//
//        $data = new Pdf();
//        $data->title = $request->title;
//        $data->file_path = $filePath;
//        $data->save();
//
//        return redirect()->route('pdf.index')->with('notify-success', 'PDF Created Successfully');
//    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:2048', // Ensure it's a valid PDF file
        ]);

        // Use the helper method to upload the file
        $filePath = Helper::fileUpload($request->file('file'), 'pdfs', $request->title);

        // Save data to the database
        $data = new Pdf();
        $data->title = $request->title;
        $data->file_path = $filePath; // Path returned from the helper
        $data->save();

        return redirect()->route('pdf.index')->with('notify-success', 'PDF Created Successfully');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Pdf::find($id);
        return view('backend.layouts.pdf.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255', // Allow updating just the title
            'file' => 'sometimes|mimes:pdf|max:2048', // File is optional
        ]);

        $data = Pdf::findOrFail($id); // Find the existing record

        // Update the title if provided
        if ($request->filled('title')) {
            $data->title = $request->title;
        }

        // Handle file upload if a new file is provided
        if ($request->hasFile('file')) {
            // Delete the old file
            if ($data->file_path && file_exists(public_path($data->file_path))) {
                unlink(public_path($data->file_path));
            }

            // Upload the new file using the helper
            $filePath = Helper::fileUpload($request->file('file'), 'pdfs', $request->title ?? $data->title);
            $data->file_path = $filePath;
        }

        $data->save(); // Save the updated record

        return redirect()->route('pdf.index')->with('notify-success', 'PDF Updated Successfully');
    }




//    public function update(Request $request, $id)
//    {
//        $request->validate([
//            'title' => 'sometimes|string|max:255',
//            'file' => 'sometimes|mimes:pdf|max:2048',
//        ]);
//
//        $data = Pdf::find($id);
//        $data->title = $request->title;
//        if ($request->hasFile('file')) {
//            // Delete old file
//            Storage::disk('public')->delete($data->file_path);
//
//            // Upload new file
//            $filePath = $request->file('file')->store('pdfs', 'public');
//            $data->file_path = $filePath;
//        }
//        $data->save();
//
//        return redirect()->route('pdf.index')->with('notify-success', 'Pdf Updated Successfully');
//    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy($id)
    {
        $data = Pdf::findOrFail($id);
        Storage::disk('public')->delete($data->file_path);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }

    /**
     * Update the status of a category.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function status($id)
    {
        $data = Pdf::findOrFail($id);

        if ($data->status == 'active') {
            $data->status = 'inactive';
            $data->save();
            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
                'data'    => $data,
            ]);
        } else {
            $data->status = 'active';
            $data->save();
            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data'    => $data,
            ]);
        }
    }

    public function download($id)
    {
        $data = Pdf::findOrFail($id);
        return Storage::disk('public')->download($data->file_path);
    }
}
