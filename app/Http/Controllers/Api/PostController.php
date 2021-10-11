<?php

namespace App\Http\Controllers\Api;

use App\Model\About;
use App\Model\Company;
use App\Model\Favourite;
use App\Model\Image;
use App\Model\ImageUpload;
use App\Model\Setting;
use App\Model\UserAction;
use App\Model\Video;
use App\Model\VideoCategory;
use App\Model\VideoUpload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Validator;


class PostController extends Controller
{


    // Latest post
    public function latest_post(Request $request)
    {

        $auth = \App\User::where('api_token', $request['api_token'])->whereNotnull('api_token')->first();
       // if (!empty($auth)) {
            if (!empty(!empty($auth))){

                $query = Image::query();
                $query->with(['favourite' => function ($q) use ($auth) {
                    $q->where('user_id', $auth->id);
                }]);
                if(!empty($request['category_id'])){
                    $query->where('category_id',$request['category_id']);
                }
                $query->withCount(['view','download','share','edit']);
                $query->orderBy('id', 'DESC');
                $records = $query->paginate();


//                $records = Image::with(['favourite' => function ($q) use ($auth) {
//                    $q->where('user_id', $auth->id);
//                }])
//                    ->withCount(['view','download','share','edit'])
//                    ->orderBy('id', 'DESC')
//                    ->paginate();
            }else{

                $query = Image::query();
                $query->withCount(['view','download','share','edit']);
                if(!empty($request['category_id'])){
                    $query->where('category_id',$request['category_id']);
                }
                $query->orderBy('id', 'DESC');
                $records = $query->paginate();


//                $records = Image::withCount(['view','download','share','edit'])
//                    ->orderBy('id', 'DESC')
//                    ->paginate();

            }
            foreach ($records as $key => $record) {

                     $records[$key]['is_my_favorite'] = (!empty($record['favourite'])&&!empty($auth)) ? "1" : "0";
            }

            $response['result'] = '1';
            $response['message'] = 'success';
            $response['records'] = $records;

//        } else {
//            $response['result'] = '0';
//            $response['message'] = 'Invalid Token';
//        }
        return Response::json($response);
    }


    // total_share_download
/*    public function total_share_download(Request $request)
    {

        $auth = \App\User::where('api_token', $request['api_token'])->first();

        if (!empty($auth)) {

            $record = Image::find($request->image_id);
            if (!empty($record)) {
                if ($request['type'] == 'view') {
                    $record->total_view = $record->total_view + 1;

                } else if ($request['type'] == 'share') {
                    $record->total_share = $record->total_share + 1;

                } elseif ($request['type'] == 'download') {
                    $record->total_download = $record->total_download + 1;

                }  elseif ($request['type'] == 'edit') {
                     $record->total_edit = $record->total_edit + 1;

                     }
                $record->save();
                $response['result'] = '1';
                $response['message'] = 'success';
                $response['record'] = $record;
            } else {

                $response['result'] = '0';
                $response['message'] = 'error';
            }


        } else {
            $response['result'] = '0';
            $response['message'] = 'Invalid Token';
        }
        return Response::json($response);
    }*/

    // add user action [download/view/share/edit]
    public function add_user_action(Request $request)
    {

        $auth = \App\User::where('api_token', $request['api_token'])->first();

//        if (!empty($auth)) {

            $check = UserAction::where('image_id', $request['image_id'])->where('type', $request['type'])->first();

            //if (empty($check)) {

                $record = UserAction::create([
                    'image_id' => $request['image_id'],
                    'user_id' => !empty($auth['id'])?$auth['id']:null,
                    'type' => $request['type'],

                ]);

                $response['result'] = '1';
                $response['message'] = 'success';
                $response['records'] = $record;
//            }else{
//
//                $response['result'] = '0';
//                $response['message'] = 'You have Already '.$request['type']. ' this image.';
//            }


//        } else {
//            $response['result'] = '0';
//            $response['message'] = 'Invalid Token';
//
//        }

        return Response::json($response);
    }


    //Download/view/share/edit list

/*    public function all_list(Request $request)
    {

        $auth = \App\User::where('api_token', $request['api_token'])->first();

          if (!empty($auth)) {

            if($request['type'] == 'favourite'){
                $records['favourite'] = Favourite::where('user_id', $auth['id'])->get();

            }else{
                $records[$request['type']] = UserAction::where('type', $request['type'])->where('user_id', $auth['id'])->get();

            }

                $response['result'] = '1';
                $response['message'] = 'success';
                $response['records'] = $records;

        } else {
            $response['result'] = '0';
            $response['message'] = 'Invalid Token';

        }
//        }
        return Response::json($response);
    }*/


    //Active ad list

    public function active_ad(Request $request)
    {
            $records = Setting::get();

            $response['result'] = '1';
            $response['message'] = 'success';
            $response['records'] = $records;


        return Response::json($response);
    }

}
