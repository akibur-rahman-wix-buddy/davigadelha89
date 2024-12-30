<?php

namespace App\Http\Controllers\Web\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\CustomScript;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomScriptController extends Controller
{
    /**
     * Displays the list of custom script.
     *
     * This method handles AJAX requests to fetch and return custom script data
     * in a format suitable for DataTables, including columns for publish
     * custom script. If not an AJAX request, it returns the main view for custom script.
     *
     * @param Request $request The incoming HTTP request.
     */

//    public function index(Request $request)
//    {
//        // Define a mapping array for content types
//        $contentTypeMapping = [
//            'header' => 'Header',
//            'footer' => 'Footer',
//        ];
//
//        $data = CustomScript::latest()->get(); // Retrieve all data
//
//        // Transform the data collection before sending to DataTables
//        $data->transform(function ($item) use ($contentTypeMapping) {
//            // Replace the raw 'type' with the transformed value
//            $item->type = $contentTypeMapping[$item->type] ?? $item->type;
//            return $item;
//        });
//
//        if ($request->ajax()) {
//            return Datatables::of($data)
//                ->addIndexColumn()
//                ->addColumn('status', function ($data) {
//                    $status = '<div class="switch-sm icon-state">';
//                    $status .= '<label class="switch">';
//                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';
//                    if ($data->status == "active") {
//                        $status .= ' checked';
//                    }
//                    $status .= '>';
//                    $status .= '<span class="switch-state"></span>';
//                    $status .= '</label>';
//                    $status .= '</div>';
//                    return $status;
//                })
//                ->addColumn('action', function ($data) {
//                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
//                            <a href="' . route('settings.custom-script.edit',  $data->id) . '" type="button" class="action edit text-success" title="Edit">
//                            <i class="icon-pencil-alt"></i></a>&nbsp;
//                            <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="action delete text-danger" title="Delete">
//                            <i class="icon-trash"></i></a></div>';
//                })
//                ->rawColumns(['status', 'action'])
//                ->make(true);
//        }
//
//        return view('backend.layouts.settings.custom_script.index');
//    }

    public function index(Request $request)
    {
        // Define a mapping array for content types
        $contentTypeMapping = [
            'header' => 'Header',
            'footer' => 'Footer',
        ];

        $data = CustomScript::latest();
        if (!empty($request->input('search.value'))) {
            $searchTerm = $request->input('search.value');
            $data->where('type', 'LIKE', "%$searchTerm%")
                ->orWhere('script_content', 'LIKE', "%$searchTerm%");
        }
        if ($request->ajax()) {
            return Datatables::of($data)
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
                                  <a href="' . route('settings.custom-script.edit',  $data->id) . '" type="button" class="action edit text-success" title="Edit">
                                  <i class="icon-pencil-alt"></i>
                                  </a>&nbsp;
                                  <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="action delete text-danger" title="Delete">
                                  <i class="icon-trash"></i>
                                </a>
                                </div>';
                })
                ->addColumn('type', function ($data) use ($contentTypeMapping) {
                    // Transform the type based on the mapping array
                    return $contentTypeMapping[$data->type] ?? $data->type;
                })
                ->rawColumns(['status', 'action','type'])
                ->make(true);
        }

        return view('backend.layouts.settings.custom_script.index');
    }

    /**
     * Show the form for creating a new custom script page.
     */
    public function create()
    {
        return view('backend.layouts.settings.custom_script.create',['custom_scripts' => CustomScript::all()]);
    }

    /**
     * Store a newly created custom script page in the database.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'script_content' => 'required',
            'type' => 'required',
        ]);


        $custom_script = new CustomScript();
        $custom_script->script_content = $request->script_content;
        $custom_script->type = $request->type;
        $custom_script->save();

        return redirect()->route('settings.custom-script.index')->with('notify-success', 'Custom Script Created Successfully');
    }

    /**
     * Display the specified category to edit and update.
     *
     * @param  string  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */

    public function edit($id)
    {
        $custom_script = CustomScript::find($id);
        return view('backend.layouts.settings.custom_script.edit',compact('custom_script'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'script_content' => 'required',
            'type' => 'required|in:header,footer', // Validate type to ensure it's either 'header' or 'footer'
        ]);

        $custom_script = CustomScript::find($id);
        $custom_script->script_content = $request->script_content;
        $custom_script->type = $request->type;
        $custom_script->save();

        return redirect()->route('settings.custom-script.index')->with('notify-success', 'Custom Script Updated Successfully');
    }

    /**
     * Delete the specified dynamic page from the category database.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        $custom_script = CustomScript::findOrFail($id);
        $custom_script->delete();

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
        $data = CustomScript::findOrFail($id);

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
}
