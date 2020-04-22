<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\ModelUser;
use Illuminate\Support\Str;
use Auth;

/**
 *
 */
class ApiController extends Controller
{

  public function signin(Request $request) {
    //string tokennya
    $token = Str::random(160);

    $username = $request->username;
    $password = $request->password;
    $firebase = $request->firebase;


    $data = ModelUser::where('username',$username)->first();
    if($data){ //apakah email tersebut ada atau tidak
        // if(Hash::check($password,$data->password)){
        if ($password==$data->password) {
          $data->forceFill([
            'token' => $token,
            'firebase' => $firebase
          ])->update();

          return [
            'status' => 'Success',
            'token' => $token,
            'firebase' => $firebase
          ];

        }
        else {
            return ['status' => 'Failed'];
        }
    }
  }

  public function profile($id) {
    $data = ModelUser::where('id',$id)->first();
    return [
      'data' => $data
    ];
  }

  public function sendNotif(Request $request) {
    $firebase = $request->firebase;
    $title = $request->title;
    $body =  $request->body;

    $fields = array (
            'to' => $firebase,
            'notification' => array (
                "title"     => $title,
                "body"      => $body
            )
        );

    $fields = json_encode ( $fields );

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $fields,
      CURLOPT_HTTPHEADER => array(
        "authorization: key=AAAAHNhkvIk:APA91bH1n-OiiN3xBnTiWd0IcR7PdgpYink2fIbJVESNbanr2CmJEcXHIJ7rQH3HaVGXPLVOKGrWAQ3LNHYCGB26a9aPzPkoVNcQRrxG-MVUDZAQJBR6OruJpNP-UpIIPP72lbYgOeD6",
        "cache-control: no-cache",
        "content-type: application/json"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
  }

}
