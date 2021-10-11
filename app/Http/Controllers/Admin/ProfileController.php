<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class ProfileController extends Controller
{
    private $data = array(
        'route' => 'admin.profile.',
        'title' => 'Profile',
        'menu' => 'profile',
        'submenu' => '',
    );

    public function __construct()
    {
        // $this->middleware('auth');
        //$this->middleware(['permission:publish |category add|category edit|category delete']);
    }

    private function _validate($request, $id = null)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
    }

    public function profile()
    {
        $auth = auth()->guard('admin')->user();
        $this->data['record'] = $auth;
        return view('admin.profile.profile',$this->data);
    }
    public function profile_store(Request $request)
    {
        $auth = auth()->guard('admin')->user();
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins,email'.(!empty($auth->id)?','.$auth->id:''),
            //'password' => ($id == null)?'required|required_with:password_confirmation|max:255':'required_with:password_confirmation|max:255',
            //'password_confirmation' => 'required_with:password|max:255|same:password',
        ]);

        $inputs = $request->all();
        if (!empty($inputs['password'])){
            $inputs['password'] = bcrypt($inputs['password']);
        }else{
            unset($inputs['password']);
        }
//        return $inputs;
        $auth->update($inputs);
        Session::flash('success','Profile updated successfully.');
        return redirect("admin/profile");

    }


}
