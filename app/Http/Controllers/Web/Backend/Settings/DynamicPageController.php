<?php

namespace App\Http\Controllers\Web\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class DynamicPageController extends Controller
{
    /**
     * Display a listing of the dynamic pages.
     *
     * @param Request $request
     */

    public function index(Request $request)
    {
        $data = DynamicPage::latest();
        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('page_title', function ($data) {
                    $page_title       = $data->page_title;
                    $short_page_title = strlen($page_title) > 100 ? substr($page_title, 0, 100) . '...' : $page_title;
                    return '<p>' . $short_page_title . '</p>';
                })
                ->addColumn('page_content', function ($data) {
                    $page_content       = $data->page_content;
                    $short_page_content = strlen($page_content) > 100 ? substr($page_content, 0, 100) . '...' : $page_content;
                    return '<p>' . $short_page_content . '</p>';
                })
                ->addColumn('status', function ($data) {
//                    $status = '<div class="d-flex justify-content-center">';  // Center align the switch
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
                                  <a href="' . route('settings.dynamic-page.edit',  $data->id) . '" type="button" class="action edit text-success" title="Edit">
                                  <i class="icon-pencil-alt"></i>
                                  </a>&nbsp;
                                  <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="action delete text-danger" title="Delete">
                                  <i class="icon-trash"></i>
                                </a>
                                </div>';
                })
                ->rawColumns(['page_title', 'page_content', 'status', 'action'])
                ->filterColumn('page_title', function ($query, $keyword) {
                    $query->where('page_title', 'like', "%{$keyword}%");
                })
                ->filterColumn('page_content', function ($query, $keyword) {
                    $query->where('page_content', 'like', "%{$keyword}%");
                })
                ->make(true);
        }
        return view('backend.layouts.settings.dynamic_page.index');
    }

    /**
     * Show the form for creating a new dynamic page.
     *
     */
    public function create()
    {
        return view('backend.layouts.settings.dynamic_page.create');
    }

    /**
     * Store a newly created dynamic page in the database.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'page_title' => 'required|string|max:100',
                'page_content' => 'required|string',
            ]);

            // If validation fails, redirect back with errors and input data

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = new DynamicPage();
            $data->page_title = $request->page_title;
            $data->page_slug = Str::slug($request->page_title);
            $data->page_content = $request->page_content;
            $data->save();

            return redirect()->route('settings.dynamic-page.index')->with('notify-success', 'Dynamic Page Created Successfully.');
        } catch (Exception $e) {
            return redirect()->route('settings.dynamic-page.index')->with('notify-success', 'Dynamic Page Failed To Create.');
        }
    }

    /**
     * Show the form for editing the specified dynamic page.
     *
     * @param int $id
     */
    public function edit($id)
    {
        $data = DynamicPage::find($id);
        return view('backend.layouts.settings.dynamic_page.edit', compact('data'));
    }


    /**
     * Update the specified dynamic page in the database.
     *
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'page_title' => 'required|string|max:100',
                'page_content' => 'required|string',
            ]);

            // If validation fails, redirect back with errors and input data
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = DynamicPage::findOrFail($id);
            $data->page_title = $request->page_title;
            $data->page_slug = Str::slug($request->page_title);
            $data->page_content = $request->page_content;
            $data->update();

            return redirect()->route('settings.dynamic-page.index')->with('notify-success', 'Dynamic Page Updated Successfully.');

        } catch (Exception $e) {
            return redirect()->route('settings.dynamic-page.index')->with('notify-warning', 'Dynamic Page Failed To Update');
        }
    }

    /**
     * Remove the specified dynamic page from the database.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        $data = DynamicPage::findOrFail($id);
        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }

    /**
     * Change the status of the specified dynamic page.
     *
     * @param int $id
     */
    public function status($id)
    {
        $data = DynamicPage::where('id', $id)->first();
        if ($data->status == 'active') {
            // If the current status is active, change it to inactive
            $data->status = 'inactive';
            $data->save();

            // Return JSON response indicating success with message and updated data
            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
                'data' => $data,
            ]);
        } else {
            // If the current status is inactive, change it to active
            $data->status = 'active';
            $data->save();

            // Return JSON response indicating success with a message and updated data.
            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data' => $data,
            ]);
        }
    }
}
