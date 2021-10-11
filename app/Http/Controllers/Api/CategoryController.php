<?php

namespace App\Http\Controllers\Api;

use App\Model\About;
use App\Model\Company;
use App\Model\Favourite;
use App\Model\Image;
use App\Model\ImageUpload;
use App\Model\Video;
use App\Model\VideoCategory;
use App\Model\VideoUpload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Support\Facades\Response;


class CategoryController extends Controller
{
    //add Images category data
    public function category_add(Request $request){

        $auth = \App\User::where('api_token',$request['api_token'])->first();
      //  if(!empty($auth)) {
            $category =  Category::create([
                'status' =>  'Active',
                'image'  =>  $this->uploadFile($request, null, 'image', 'category'),
                'name'  =>  $request['name'],
                'language'  =>  $request['language']

            ]);
            $response['result'] = '1';
            $response['message'] = 'Category Added successfully';
            $response['record'] = Category::find($category->id);
/*
        }else{
            $response['result'] = '0';
            $response['message'] = 'Invalid Token';
        }*/
        return Response::json($response);
    }

    // delete category
    public function category_delete(Request $request){

        $auth = \App\User::where('api_token',$request['api_token'])->first();
       // if(!empty($auth)) {
            $record = Category::findOrFail($request['id']);
            $this->deleteFile($record,'image',pathinfo( 'category'));
            $record->delete();
            $response['result'] = '1';
            $response['message'] = 'Delete Category successfully';

       /* }else{
            $response['result'] = '0';
            $response['message'] = 'Invalid Token';
        }*/
        return Response::json($response);
    }


    // list all category
    public function category_list(Request $request){

        $auth = \App\User::where('api_token',$request['api_token'])->first();
       // if(!empty($auth)){

            $records = Category::orderBy('id','DESC')->paginate();

            $response['result'] = '1';
            $response['message'] = 'success';
            $response['records'] = $records;

       /* }else{
            $response['result'] = '0';
            $response['message'] = 'Invalid Token';
        }*/
        return Response::json($response);
    }


    //category images upload
    public function category_images_add(Request $request){

        $auth = \App\User::where('api_token',$request['api_token'])->first();
        //if(!empty($auth)) {
            $category_image =  Image::create([
                'status' =>  'Active',
                'preview_image'  =>  $this->uploadFile($request, null, 'preview_image', 'preview_image'),
                'frame_image'  =>  $this->uploadFile($request, null, 'frame_image', 'frame_image'),
                'category_id'  =>   $request['category_id']

            ]);
            $response['result'] = '1';
            $response['message'] = 'Category image Added successfully';
            $response['record'] = Image::find($category_image->id);

        /*}else{
            $response['result'] = '0';
            $response['message'] = 'Invalid Token';
        }*/
        return Response::json($response);
    }

    //category images delete
    public function category_images_delete(Request $request){

        $auth = \App\User::where('api_token',$request['api_token'])->first();
     //   if(!empty($auth)) {
          $record = Image::findOrFail($request['id']);
            if(!empty($record)){
                $this->deleteFile($record,'preview_image',pathinfo( 'preview_image'));
                $this->deleteFile($record,'frame_image',pathinfo( 'frame_image'));
                $record->delete();
                $response['result'] = '1';
                $response['message'] = 'Delete Category image successfully';
            }else{
                $response['result'] = '1';
                $response['message'] = 'Already record delete';
            }


       /* }else{
            $response['result'] = '0';
            $response['message'] = 'Invalid Token';
        }*/
        return Response::json($response);
    }

    // list all category images
    public function category_images_list(Request $request){

        $auth = \App\User::where('api_token',$request['api_token'])->first();
     //   if(!empty($auth)){

            $records = Image::where('category_id',$request['category_id'])->orderBy('id','DESC')->paginate();

            $response['result'] = '1';
            $response['message'] = 'success';
            $response['records'] = $records;

        /*}else{
            $response['result'] = '0';
            $response['message'] = 'Invalid Token';
        }*/
        return Response::json($response);
    }


    public function favourite(Request $request)
    {

        $auth = \App\User::where('api_token', $request['api_token'])->whereNotNull('api_token')->first();
        if ( !empty($auth) && !empty($request['image_id'])) {

            $check = Favourite::where('image_id', $request['image_id'])->where('user_id', $auth['id'])->first();

            $favourite = Image::with('user')->find($request['image_id']);
            if (!empty($check)) {
                $check->delete();
                $response['result'] = '1';
                $response['message'] = 'UnFavourite successfully';
                $var = 'UnFavourite';
            } else {
                Favourite::create([
                    'user_id' => $auth->id,
                    'image_id' => $request['image_id']
                ]);
                $response['result'] = '1';
                $response['message'] = 'Favourite successfully';
                $var = 'Favourite';
            }
            //  $response['record'] = $auth;

            //START pushnotification section
//            if(!empty($favourite['user']['device_id']) && $favourite['user']['device'] == 'android'){
//
//                $push = new PushNotification('fcm');
//                $push->setMessage([
//                    'notification' => [
//                        'title' => 'your video '.$var,
//                        'body' => $auth['name']." " .$var . ' your video' ,
//                        'sound' => 'default'
//                    ],
//                    'data' => [
//                        'extraPayLoad1' => 'value1',
//                        'extraPayLoad2' => 'value2'
//                    ]
//                ])
//                    ->setDevicesToken($favourite['user']['device_id'])
//                    ->send();
//
//                //END push notification section
//            }
//
//        } else {
//            $response['result'] = '0';
//            $response['message'] = 'Invalid Token';
       }

        return Response::json($response);
    }

    public function favourite_list(Request $request)
    {

        return $auth = \App\User::where('api_token', $request['api_token'])->whereNotNull('api_token')->first();
        if (!empty($auth)) {

            $records = Favourite::where('user_id', $auth['id'])->get();


            $response['result'] = '1';
            $response['message'] = 'success';
            $response['records'] = $records;

        } else {
            $response['result'] = '0';
            $response['message'] = 'Invalid Token';
        }
        return Response::json($response);
    }
}
