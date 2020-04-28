<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\ModelUser;
use App\ModelNotifMasuk;
use App\ModelSuratMasuk;
use Illuminate\Support\Str;
use Auth;
use Carbon\Carbon;
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
            'firebase' => $firebase,
            'user_id' => $data->id
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
    $user_id = $request->user_id;
    $firebase = $request->firebase;
    $title = $request->title;
    $body =  $request->body;
    $jenis = $request->jenis;
    $id_surat_masuk = $request->id_surat_masuk;


    $fields = array (
            'to' => $firebase,
            'notification' => array (
                "title"     => $title,
                "body"      => $body
            )
        );

    //========
    $data =  new ModelNotifMasuk();
    $data->user_id = $request->user_id;
    $data->title = $request->title;
    $data->body = $request->body;
    $data->jenis = $request->jenis;
    $data->id_surat_masuk = $request->id_surat_masuk;
    $data->status_read = 0;
    $data->created_at = Carbon::now();
    $data->updated_at = Carbon::now();
    $data->save();
    //========

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


  public function getMail($user_id) {
    $data = ModelNotifMasuk::where('user_id',$user_id)->orderBy('created_at', 'asc')->get();
    return [
      'data' => $data
    ];
  }

  public function getMailUnread($user_id) {
    $data = ModelNotifMasuk::where('user_id',$user_id)->where('status_read', 0)->get();
    return [
      'data' => $data
    ];
  }

  public function updateStatusRead($id) {
    $data = ModelNotifMasuk::where('id',$id)->update([
      'status_read' => 1
    ]);
    if($data) {
      return [
        'status' => 'Success'
      ];
    } else {
      return [
        'status' => 'Failed'
      ];
    }
  }

  public function detailSuratMasuk($id) {
    $data = ModelSuratMasuk::where('id',$id)->first();
    return [
      'status' => 'Success',
      'data' => $data
    ];
  }


}
