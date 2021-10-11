<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use App\Model\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;


class ImageController extends Controller
{
    //
    private $data = array(
        'route' => 'admin.image.',
        'title' => 'Image',
        'menu' => 'image',
        'submenu' => '',
    );
    public function __construct() {
        // $this->middleware('auth');
        //$this->middleware(['permission:publish |category add|category edit|category delete']);
    }
    private function _validate($request, $id = null) {
        $this->validate($request, [
            'preview_image' => 'required',
            'frame_image' => 'required',
        ]);
    }

    public function index(Request $request) {
//        if($request->has('export') && ($request->get('export')=='xlsx' || $request->get('export')=='csv')){
//            $categories = Image::select(['category_id','status','created_at','updated_at'])->orderBy('id','ASC')->get()->toArray()->with('category');
//            $this->exportFile($request->get('export'), 'image_upload', ['Title', 'Status', 'Created At', 'Updated At'], $categories);
//        }

        if ($request->ajax()) {
            $records = Image::select('*')->with('category');

            return DataTables::of($records)
                ->editColumn('sequence', function ($record) {
                    return '<input style="width:100px" type="text" class="form-control txt_inline_edit inline_update" name="" value="'.$record['sequence'].'" row_id="'.$record['id'].'" field="sequence" ajax_url="'. route($this->data['route'] . 'update',$record['id']).'" />';
                })
                ->editColumn('title', function ($record) {
                    return $record->title;
                })
                ->editColumn('preview_image', function ($record) {
                    return '<a target="_blank" href="'.$record['preview_image_url'].'"><img src="'.$record['preview_image_url'].'" width="150"></a>';
                })
                ->editColumn('frame_image', function ($record) {
                    return '<a target="_blank" href="'.$record['frame_image_url'].'"><img src="'.$record['frame_image_url'].'" width="150"></a>';
                })
                ->addColumn('status', function ($record) {
                    return '<input id="toggle-demo" value="' . $record->id . '" class="chk_status" data-toggle="toggle" data-on=" Active " data-off="Inactive &nbsp;" data-size="small" data-onstyle="success" data-offstyle="info"  type="checkbox" ' . ($record->status == "Active" ? " checked" : "" ) . ' >';
                })
                ->addColumn('action', function ($record) {
                    return '<a href="' . route($this->data['route'] . 'show', ['id' => $record->id]) . '" class="btn btn-primary btn-sm" title="" data-toggle="tooltip" data-original-title="View"><i class="fa fa-eye-slash"></i></a>' .
                        '&nbsp;<a href="' . route($this->data['route'] . 'edit', ['id' => $record->id]) . '" class="btn btn-info btn-sm" title="" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>' .
                        '&nbsp;<button class="btn btn-danger btn-sm data-delete " data-id="' . $record->id . '" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></button>';
                })
                ->rawColumns(['status', 'action','frame_image','preview_image','sequence'])
                ->make(true);
        }
        return view('admin.image.index', $this->data);

    }
    public function create() {
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['category add']), 403);
        return view('admin.image.create', $this->data);
    }
    public function store(Request $request) {

        $this->_validate($request);
        $inputs = $request->all();


        $category = Category::where('id',$request['category_id'])->first();
        //$inputs['language'] = $category['language'];


        $inputs['status'] = 'Active';
        $inputs['preview_image'] = $this->uploadFile($request, null, 'preview_image', 'preview_image');
        $inputs['frame_image'] = $this->uploadFile($request, null, 'frame_image', 'frame_image');

        $record = new Image($inputs);
        $record->save();

        Session::flash('success', $this->data['title'] . ' inserted successfully.');
        return redirect()->route($this->data['route'] . 'index');
    }
    public function show($id) {
        $this->data['record'] = Image::with('category')->findOrFail($id);
        return view('admin.image.show', $this->data);
    }

    public function edit($id) {
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['category edit']), 403);
        $this->data['record'] = Image::findOrFail($id);
        return view('admin.image.create', $this->data);
    }

    public function update(Request $request, $id) {
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['category edit']), 403);
        $record = Image::findOrFail($id);
        /* Change Status Block */
        if ($request->ajax()) {


            $record->update($request->all());
            return \Illuminate\Support\Facades\Response::json(['result' => 'success']);
        }
      //  $this->_validate($request);
        $inputs = $request->all();

        $category = Category::where('id',$request['category_id'])->first();
        $inputs['language'] = $category['language'];

        $inputs['preview_image'] = $this->uploadFile($request, $record, 'preview_image', 'preview_image');
        if (empty($inputs['preview_image'])) {
            unset($inputs['preview_image']);
        }
        $inputs['frame_image'] = $this->uploadFile($request, $record, 'frame_image', 'frame_image');
        if (empty($inputs['frame_image'])) {
            unset($inputs['frame_image']);
        }
        $record->update($inputs);

        Session::flash('info', $this->data['title'] . ' updated successfully.');
        return redirect()->route($this->data['route'] . 'index');
    }
    public function destroy($id) {
        //abort_unless(Auth::guard('admin')->user()->hasAnyPermission(['category delete']), 403);
        $record = Image::findOrFail($id);
        $this->deleteFile($record,'preview_image');
        $this->deleteFile($record,'frame_image');
        $record->delete();
        return \Illuminate\Support\Facades\Response::json([
            'result' => 'success',
            'message' => 'Deleted Data successfully!']);
    }

}
