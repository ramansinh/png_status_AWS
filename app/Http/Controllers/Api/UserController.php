<?php

namespace App\Http\Controllers\Api;

use App\Model\Favourite;
use App\Model\Privacy;
use App\Model\UserAction;
use App\Model\Image;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function register(Request $request){
//        return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $response['result']='0';
            $response['message']=$errors = $validator->errors()->first();
            $response['errors']=$errors = $validator->errors();
        }else{
            $random = Str::random(100);
            $user = \App\User::create([
                'api_token' => $random,
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'device' => $request['device'],
                'device_id' => $request['device_id'],
                'image' =>  $this->uploadFile($request, '' , 'image', 'user'),

            ]);
            $status_code = 200;
            $response['result']='1';
            $response['message']='User registered successfully';
            $response['api_token']=$user->api_token;
            $response['record']=  \App\User::find($user->id);
        }
        return Response::json($response);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $response['result']='0';
            $response['message']=$errors = $validator->errors()->first();
            $response['errors']=$errors = $validator->errors();
            $status_code = 422;
        }else{
            $status_code = 200;
            $auth = \App\User::where('email',$request['email'])->first();
           // if(!empty($auth) && Hash::check($request['password'], $auth['password'])){
                $random = Str::random(100);
              //  $auth->update(['api_token'=>$random]);
                $response['result']='1';
                $response['message']='login successfully';
                $response['api_token']=$auth->api_token;
                $response['record']=  $auth;
          /*  }else{
                $response['result']='0';
                $response['message']='Invalid email or password';
            }*/
        }
        return Response::json($response);
    }

    public function profile(Request $request){

        $query = User::query();
        $query->where('api_token',$request['api_token'])->whereNotNull('api_token');


        $auth =  $query->first();

        if(!empty($auth)){

            if (!empty($request['password'])){
                $request['password'] = bcrypt($request['password']);
            }
            if (!empty($request['email'])){
                $validator = Validator::make($request->all(), [
//                    'email' => 'required|email|unique:users,email,',
                    'email' => 'required|email|max:255|unique:users,email'.(!empty($auth["id"])?','.$auth["id"]:''),
                ]);
                if ($validator->fails()) {
                    $response['result']='0';
                    $response['message']=$errors = $validator->errors()->first();
                    $response['errors']=$errors = $validator->errors();
                    return Response::json($response);
                }
            }
            $inputs = $request->all();
            //return $request->file('image');
            $inputs['image'] =  $this->uploadFile($request ,$auth, 'image', 'user');
            if (empty($inputs['image'])) {
                unset($inputs['image']);
            }

            $auth->update($inputs);

            //user action [Download/view/share/edit list]

                $records['favourite'] = Favourite::where('user_id', $auth['id'])->get();
                $records['download'] = UserAction::where('type', 'download')->where('user_id', $auth['id'])->get();
                $records['view'] = UserAction::where('type', 'view')->where('user_id', $auth['id'])->get();
                $records['share'] = UserAction::where('type', 'share')->where('user_id', $auth['id'])->get();
                $records['edit'] = UserAction::where('type', 'edit')->where('user_id', $auth['id'])->get();


            $response['result'] = '1';
            $response['message'] = 'Profile updated successfully';
            $response['record'] = $auth;
            $response['user_action_list'] = $records;

        }else{
            $response['result'] = '0';
            $response['message'] = 'Invalid token';
        }
        return Response::json($response);
    }
    public function user_list(Request $request){
//        $auth = \App\User::where('api_token',$request['api_token'])->first();
//        if(!empty($auth)){
            $query = User::query();
            if(!empty($request['search'])){
                $query->where('name','LIKE','%'.$request['search'].'%');
            }
            $users = $query->paginate();

            $response['result'] = '1';
            $response['message'] = 'success';
            $response['records'] = $users;

//        }else{
//            $response['result'] = '0';
//            $response['message'] = 'Error';
//        }
        return Response::json($response);
    }
    public function forgot_password(Request $request){
//        $auth = \App\User::where('email',$request['email'])->first();
//        if(!empty($auth)){
//            $new_pass = str_random(8);
//
//            $auth->password = bcrypt($new_pass);
//            $auth->save();
//
//            //return view('mail.password_reset',['user'=>$auth]);
//            //return $auth;
//            $message = view('mail.password_reset',['user'=>$auth,'new_pass' => $new_pass])->render();
//
//
//            $data['user'] = $auth;
//            $data['new_pass'] = $new_pass;
//            Mail::send('mail.password_reset', $data, function($message) use ($auth) {
//                $message->to($auth['email'])->subject('reset password');
//            });

            $response['result'] = '1';
            $response['message'] = 'success.';

//        }else{
//            $response['result'] = '0';
//            $response['message'] = 'Invalid email.';
//        }
        return Response::json($response);
    }

    public function privacy(Request $request)
    {

        $auth = \App\User::where('api_token', $request['api_token'])->whereNotNull('api_token')->first();
        if (!empty($auth)) {

            $records = Privacy::get();


            $response['result'] = '1';
            $response['message'] = 'success';
            $response['records'] = $records;

        } else {
            $response['result'] = '0';
            $response['message'] = 'Invalid Token';
        }
        return Response::json($response);
    }

    public function my_edited_post(Request $request){
        $auth = \App\User::where('api_token', $request['api_token'])->whereNotNull('api_token')->first();
        if (!empty($auth) && !empty($request['type'])) {
            $userAction = UserAction::select(['id','image_id'])
                ->where('user_id',$auth['id'])
                ->where('type',$request['type'])
                ->orderBy('id','desc')
                ->paginate()
                ->pluck('image_id');

            $records = Image::with(['favourite' => function ($q) use ($auth) {
                $q->where('user_id', $auth->id);
            }])
                ->withCount(['view','download','share','edit'])
                ->whereIn('id',$userAction)
                ->orderBy('id', 'DESC')
                ->paginate();

            foreach ($records as $key => $record) {

                $records[$key]['is_my_favorite'] = (!empty($record['favourite'])&&!empty($auth)) ? "1" : "0";
            }

            $response['result'] = '1';
            $response['message'] = 'success';
            $response['actions'] = $userAction;
            $response['records'] = $records;

        } else {
            $response['result'] = '0';
            $response['message'] = 'Invalid Token';
        }
        return Response::json($response);
    }

    public function my_favorite_post(Request $request){
        $auth = \App\User::where('api_token', $request['api_token'])->whereNotNull('api_token')->first();
        if (!empty($auth)) {
//            $userAction = UserAction::select(['id','image_id'])
//                ->where('user_id',$auth['id'])
//                ->where('type',$request['type'])
//                ->orderBy('id','desc')
//                ->paginate()
//                ->pluck('image_id');
            $userAction = Favourite::select(['id','user_id','image_id'])
                ->where('user_id',$auth['id'])
                ->orderBy('id','desc')
                ->paginate()
                ->pluck('image_id');


            $records = Image::with(['favourite' => function ($q) use ($auth) {
                $q->where('user_id', $auth->id);
            }])
                ->withCount(['view','download','share','edit'])
                ->whereIn('id',$userAction)
                ->orderBy('id', 'DESC')
                ->paginate();

            foreach ($records as $key => $record) {

                $records[$key]['is_my_favorite'] = (!empty($record['favourite'])&&!empty($auth)) ? "1" : "0";
            }

            $response['result'] = '1';
            $response['message'] = 'success';
            $response['actions'] = $userAction;
            $response['records'] = $records;

        } else {
            $response['result'] = '0';
            $response['message'] = 'Invalid Token';
        }
        return Response::json($response);
    }




}
