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
    /**
     * Display a listing of the PDFs.
     *
     * @param \Illuminate\Http\Request $request
     */

    public function index(Request $request)
    {
        $data = Pdf::latest();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('file_path', function ($data) {
                    $fileName = basename($data->file_path);
                    $url = asset($data->file_path);
                    $pdfIcon = '<i class="fa fa-file-pdf-o text-danger" style="font-size: 18px;"></i>';
                    return '<a href="' . $url . '" target="_blank" style="text-decoration: none;">' . $pdfIcon . ' ' . $fileName . '</a>';
                })
                ->addColumn('status', function ($data) {
                    $status = '<div class="switch-sm icon-state">';
                    $status .= '<label class="switch">';
                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" name="status"';
                    if ($data->status == "active") {
                        $status .= ' checked';
                    }
                    $status .= '><span class="switch-state"></span></label></div>';
                    return $status;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group">
                                <a href="' . route('pdf.edit', $data->id) . '" class="action edit text-success" title="Edit">
                                    <i class="icon-pencil-alt"></i>
                                </a>
                                <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" class="action delete text-danger" title="Delete">
                                    <i class="icon-trash"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['file_path', 'status', 'action'])
                ->make(true);
        }
        return view('backend.layouts.pdf.index');
    }

    /**
     * Show the form for creating a new PDF.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.layouts.pdf.create');
    }

    /**
     * Store a newly created PDF in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $filePath = Helper::fileUpload($request->file('file'), 'pdfs', $request->title);

        $data = new Pdf();
        $data->title = $request->title;
        $data->file_path = $filePath;
        $data->save();

        return redirect()->route('pdf.index')->with('notify-success', 'PDF Created Successfully');
    }

    /**
     * Show the form for editing the specified PDF.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $data = Pdf::find($id);
        return view('backend.layouts.pdf.edit', compact('data'));
    }

    /**
     * Update the specified PDF in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'file' => 'sometimes|mimes:pdf|max:2048',
        ]);

        $data = Pdf::findOrFail($id);

        if ($request->filled('title')) {
            $data->title = $request->title;
        }

        if ($request->hasFile('file')) {
            if ($data->file_path && file_exists(public_path($data->file_path))) {
                unlink(public_path($data->file_path));
            }
            $filePath = Helper::fileUpload($request->file('file'), 'pdfs', $request->title ?? $data->title);
            $data->file_path = $filePath;
        }

        $data->save();

        return redirect()->route('pdf.index')->with('notify-success', 'PDF Updated Successfully');
    }

    /**
     * Delete the specified PDF from the database and remove its file from the public directory.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $data = Pdf::findOrFail($id);

        // Check and delete the file from the public directory
        if ($data->file_path && file_exists(public_path($data->file_path))) {
            unlink(public_path($data->file_path));
        }

        // Delete the database record
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }


    /**
     * Update the status of a PDF.
     *
     * @param string $id
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

    /**
     * Download the specified PDF.
     *
     * @param string $id
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download($id)
    {
        $data = Pdf::findOrFail($id);
        return Storage::disk('public')->download($data->file_path);
    }
}
