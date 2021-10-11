<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use App\Model\Privacy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class PrivacyController extends Controller
{
    private $data = array(
        'route' => 'admin.privacy.',
        'title' => 'Privacy',
        'menu' => 'privacy',
        'submenu' => '',
    );

    public function __construct() {
        // $this->middleware('auth');
        //$this->middleware(['permission:publish |category add|category edit|category delete']);
    }

    private function _validate($request, $id = null) {
        $this->validate($request, [
            'privacy' => 'required|max:255',
        ]);
    }

    public function index(Request $request) {

        if ($request->ajax()) {
            $records = Privacy::select('*')->orderBy('id','ASC');

            return DataTables::of($records)
//                ->editColumn('sequence', function ($record) {
//                    return '<input style="width:100px" type="text" class="form-control txt_inline_edit inline_update" name="" value="'.$record['sequence'].'" row_id="'.$record['id'].'" field="sequence" ajax_url="'. route($this->data['route'] . 'update',$record['id']).'" />';
//                })
                ->editColumn('created_at', function ($record) {
                    return $record->created_at->format(config('setting.DATE_FORMAT'));
                })
                ->addColumn('action', function ($record) {
                    return '<a href="' . route($this->data['route'] . 'show', ['id' => $record->id]) . '" class="btn btn-primary btn-sm" title="" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye-slash"></i></a>' .
                        '&nbsp;<a href="' . route($this->data['route'] . 'edit', ['id' => $record->id]) . '" class="btn btn-info btn-sm" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>' ;
//                        '&nbsp;<button class="btn btn-danger btn-sm data-delete " data-id="' . $record->id . '" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.privacy.index', $this->data);

    }

    public function create() {
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['category add']), 403);
        return view('admin.privacy.create', $this->data);
    }

    public function store(Request $request) {
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['category add']), 403);
        $this->_validate($request);
        $inputs = $request->all();

        $record = new Privacy($inputs);
        $record->save();

        Session::flash('success', $this->data['title'] . ' inserted successfully.');
        return redirect()->route($this->data['route'] . 'index');
    }

    public function show($id) {
        $this->data['record'] = Privacy::findOrFail($id);
        return view('admin.privacy.show', $this->data);
    }

    public function edit($id) {
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['category edit']), 403);
        $this->data['record'] = Privacy::findOrFail($id);
        return view('admin.privacy.create', $this->data);
    }

    public function update(Request $request, $id) {
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['category edit']), 403);
        $record = Privacy::findOrFail($id);
        /* Change Status Block */
        if ($request->ajax()) {
            $record->update($request->all());
            return \Illuminate\Support\Facades\Response::json(['result' => 'success']);
        }
        $this->_validate($request);

        $inputs = $request->all();

        $record->update($inputs);

        Session::flash('info', $this->data['title'] . ' updated successfully.');
        return redirect()->route($this->data['route'] . 'index');
    }

    public function destroy($id) {
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['category delete']), 403);
        $record = Privacy::findOrFail($id);
        $record->delete();
        return \Illuminate\Support\Facades\Response::json([
            'result' => 'success',
            'message' => 'Deleted Data successfully!']);
    }
}
