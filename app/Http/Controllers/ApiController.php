<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\ModelUser;
use App\ModelNotifMasuk;
use App\ModelSuratMasuk;
use App\ModelSuratKeluar;
use App\ModelInstruksiCamat;
use App\ModelFeedbackSuratMasuk;
use App\ModelDisposisiSurat;
use App\ModelAbsen;
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
    } else {
      return ['status' => 'Failed'];
    }
  }

  public function profile($id) {

    $data = DB::table('tb_user')
    ->select('tb_user.id','tb_user.username','tb_user.npk','tb_user.nama_lengkap', 'tb_user.jabatan', 'tb_jabatan.nama_jabatan', 'tb_user.token','tb_user.firebase')
    ->join('tb_jabatan','tb_user.jabatan','=','tb_jabatan.id')
    ->where('tb_user.id', $id)
    ->get();
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

    

    if ($jenis==1) { // surat masuk
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

      // ===== nyimpen ke tb disposisi surat (disposisi baru)
      $data = new ModelDisposisiSurat();
      $data->id_surat = $request->id_surat_masuk;
      $data->jenis_surat = $jenis;
      $data->catatan = "Surat masuk baru";
      $data->instruksi = "Untuk diketahui";
      $data->dari_user_id = $request->id_admin;
      $data->untuk_user_id = $request->user_id;
      $data->status_read_admin = 1;
      $data->created_at = Carbon::now();
      $response = $data->save();
      // ==== end nyimpen ke tb disposisi surat (disposisi baru)

      // ===== update status surat masuk =====
      // cek role user id untuk kebutuhan status surat masuk/keluar
      $dt = ModelUser::where('id',$request->user_id)->first();
      $role = $dt['role'];
      $status_code = null;
      // kalo pake untuk_user_id
      if ($role=='camat') {
        $status_code = 1;
      }
      // else if ($role=='sekcam') {
      //   $status_code = 2;
      // }else if ($role=='kasi'||$role=='kasubag') {
      //   $status_code = 4;
      // }

      $xx = ModelSuratMasuk::where('id',$request->id_surat_masuk)->update(['status'=>$status_code]);
      // ===== end update status surat masuk =====
    }else if ($jenis==2) { // surat keluar
      $dari_user_id = $request->dari_user_id;
      $untuk_user_id = $request->untuk_user_id;
      $id_surat = $request->id_surat;


       //======== notif masuk
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

      $data = new ModelDisposisiSurat();
      $data->id_surat = $id_surat;
      $data->jenis_surat = $jenis;
      $data->catatan = "Surat keluar baru";
      $data->instruksi = "Untuk diperiksa";
      $data->dari_user_id = $dari_user_id;
      $data->untuk_user_id = $untuk_user_id;
      $data->status_read_admin = 1;
      $data->created_at = Carbon::now();
      $response = $data->save();

      // ===== update status surat keluar =====
      // cek role user id untuk kebutuhan status surat masuk/keluar
      $dt = ModelUser::where('id',$request->untuk_user_id)->first();
      $role_untuk = $dt['role'];
      $dtz = ModelUser::where('id',$request->dari_user_id)->first();
      $role_dari = $dtz['role'];
      $status_code = null;
      // kalo pake untuk_user_id
      if (($role_untuk=='kasi'||$role_untuk=='kasubag')&&$role_dari=='admin') {
        $status_code = 0.5;
      }else if (($role_dari=='kasi'||$role_dari=='kasubag')&&$role_untuk=='admin') {
        $status_code = 1;
      }else if (($role_dari=='kasi'||$role_dari=='kasubag')&&$role_untuk=='sekcam') {
        $status_code = 2;
      }else if ($role_dari=='sekcam'&&$role_untuk=='admin') {
        $status_code = 3;
      }else if ($role_dari=='sekcam'&&$role_untuk=='camat') {
        $status_code = 4;
      }else if ($role_dari=='camat'&&$role_untuk=='admin') {
        $status_code = 5;
      }
      $xx = ModelSuratKeluar::where('id',$request->id_surat)->update(['status'=>$status_code]);
      // ===== end update status surat keluar =====
      
      // ===== nyimpen ke tb disposisi surat (disposisi baru)
    }

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
    $data = ModelNotifMasuk::where('user_id',$user_id)->orderBy('id', 'desc')->get();
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

  public function detailSuratKeluar($id) {
    $data = ModelSuratKeluar::where('id',$id)->first();
    return [
      'status' => 'Success',
      'data' => $data
    ];
  }

  public function instruksiCamat() {
    $data = ModelInstruksiCamat::all();
    return [
      'status' => 'Success',
      'data' => $data
    ];
  }


  public function postInstruksi(Request $request) {
    $jenis_surat = $request->jenis_surat;
    $id_surat = $request->id_surat;
    $catatan = $request->catatan;
    $instruksi   = $request->instruksi  ;
    $dari_user_id =  $request->dari_user_id;
    $untuk_user_id = $request->untuk_user_id;

    $data = new ModelDisposisiSurat();
    $data->jenis_surat = $request->jenis_surat;
    $data->id_surat = $request->id_surat;
    $data->catatan = $request->catatan;
    $data->instruksi = $request->instruksi;
    $data->dari_user_id = $request->dari_user_id;
    $data->untuk_user_id = $request->untuk_user_id;
    $data->status_read_admin = 0;
    $data->created_at = Carbon::now();
    $response = $data->save();

    if ($jenis_surat==1) {
      $dt = ModelUser::where('id',$request->untuk_user_id)->first();
      $role_untuk = $dt['role'];
      $dtz = ModelUser::where('id',$request->dari_user_id)->first();
      $role_dari = $dtz['role'];
      $status_code = null;

      if ($role_untuk=='camat') {
        $status_code = 1;
      }else if ($role_untuk=='sekcam') {
        $status_code = 2;
      }else if ($role_untuk=='kasi'||$role_untuk=='kasubag') {
        $status_code = 3;
      }
      $xx = ModelSuratMasuk::where('id',$request->id_surat)->update(['status'=>$status_code]);
    }else if ($jenis_surat==2) {
      $dt = ModelUser::where('id',$request->untuk_user_id)->first();
      $role_untuk = $dt['role'];
      $dtz = ModelUser::where('id',$request->dari_user_id)->first();
      $role_dari = $dtz['role'];
      $status_code = null;
      if (($role_untuk=='kasi'||$role_untuk=='kasubag')&&$role_dari=='admin') {
        $status_code = 0.5;
      }else if (($role_dari=='kasi'||$role_dari=='kasubag')&&$role_untuk=='admin') {
        $status_code = 1;
      }else if (($role_dari=='kasi'||$role_dari=='kasubag')&&$role_untuk=='sekcam') {
        $status_code = 2;
      }else if ($role_dari=='sekcam'&&$role_untuk=='admin') {
        $status_code = 3;
      }else if ($role_dari=='sekcam'&&$role_untuk=='camat') {
        $status_code = 4;
      }else if ($role_dari=='camat'&&$role_untuk=='admin') {
        $status_code = 5;
      }
      $xx = ModelSuratKeluar::where('id',$request->id_surat)->update(['status'=>$status_code]);
    }

    if($response) {
      return [
        'status' => 'Success'
      ];
    } else {
      return [
        'status' => 'Failed'
      ];
    }

    
  }

  public function organisasi($leader_id) {
    $data = DB::table('tb_user')
    ->select('tb_user.id','tb_user.username','tb_user.npk','tb_user.nama_lengkap', 'tb_user.token','tb_user.firebase')
    ->join('tb_organisasi','tb_user.id','=','tb_organisasi.under_id')
    ->where('tb_organisasi.leader_id', $leader_id)
    ->get();

    return [
      'status' => 'Success',
      'data' => $data
    ];
  }


  public function listdisposisi() {
    $sel = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.file_dokumen, a.catatan, a.ringkasan_surat,
        a.id_user, b.username, b.nama_lengkap,
        a.id_user_camat, c.username as username_camat, c.nama_lengkap as nama_lengkap_camat, c.firebase, a.status,
        a.created_at, a.updated_at, d.id as id_disposisi, d.catatan as catatan_disposisi,d.instruksi,d.status_read_admin,
        d.dari_user_id,e.username as dari_username,e.pangkat as dari_pangkat, d.untuk_user_id, f.username as untuk_username, f.pangkat as untuk_pangkat,d.created_at as waktu_disposisi
        from tb_surat_masuk a left join tb_user b on a.id_user = b.id
        left join tb_user c on a.id_user_camat = c.id
        left join tb_disposisi_surat d on d.id_surat = a.id
        left join tb_user e on d.dari_user_id = e.id
        left join tb_user f on d.untuk_user_id = f.id
        where d.id is not null
        GROUP BY d.id order by d.id desc;");

     // $sel = DB::connection('mysql')->select("SELECT * from tb_feeback_surat_masuk d  where d.id is not null and d.status_read_admin = 0 order by 1 asc;");
    return response()->json($sel);
  }

   public function getListNotifDisposisi(){
     $listd = array();
      $sel = DB::connection('mysql')->select("SELECT d.id,d.jenis_surat,d.id_surat,d.catatan,d.instruksi,d.dari_user_id,e.username as dari_username,e.pangkat as dari_pangkat, d.untuk_user_id, f.username as untuk_username, f.pangkat as untuk_pangkat,d.status_read_admin,d.created_at,d.updated_at
        from tb_disposisi_surat d
        left join tb_user e on d.dari_user_id = e.id
        left join tb_user f on d.untuk_user_id = f.id
        where d.status_read_admin = 0
        ORDER BY id desc;");
      for ($i=0; $i < count($sel); $i++) { 
        $id_disposisi = $sel[$i]->id;
        $jenis_surat = $sel[$i]->jenis_surat;
        $id_surat = $sel[$i]->id_surat;
        $catatan_disposisi = $sel[$i]->catatan;
        $instruksi = $sel[$i]->instruksi;
        $dari_user_id = $sel[$i]->dari_user_id;
        $dari_username = $sel[$i]->dari_username;
        $dari_pangkat = $sel[$i]->dari_pangkat;
        $untuk_user_id = $sel[$i]->untuk_user_id;
        $untuk_username = $sel[$i]->untuk_username;
        $untuk_pangkat = $sel[$i]->untuk_pangkat;
        $status_read_admin = $sel[$i]->status_read_admin;
        $waktu_disposisi = $sel[$i]->created_at;
        $nomor_surat = '';
        $tanggal_surat = '';
        $perihal = '';
        $asal_surat = '';
        $lampiran = '';
        $file_dokumen = '';
        $catatan_surat = '';
        $ringkasan_surat = '';
        if ($jenis_surat==1) {
          $les = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.file_dokumen, a.catatan, a.ringkasan_surat, 
             a.id_user, b.username, b.nama_lengkap, 
             a.id_user_camat, c.username as username_camat, c.nama_lengkap as nama_lengkap_camat, c.firebase, a.status,
             a.created_at, a.updated_at, a.deleted_at
            from tb_surat_masuk a left join tb_user b on a.id_user = b.id left join tb_user c on a.id_user_camat = c.id 
            where a.id = $id_surat
            and a.deleted_at is null ;");
        }else if ($jenis_surat==2) {
          $les = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.file_dokumen, a.catatan, a.ringkasan_surat, a.status, a.created_at,
             a.id_user, b.username, b.nama_lengkap, 
             a.created_at, a.updated_at
            from tb_surat_keluar a left join tb_user b on a.id_user = b.id 
            where a.id = $id_surat ;");
        }
        if (count($les)>0) {
            $nomor_surat = $les[0]->nomor_surat;
            $tanggal_surat = $les[0]->tanggal_surat;
            $perihal = $les[0]->perihal;
            $asal_surat = $les[0]->asal_surat;
            $lampiran = $les[0]->lampiran;
            $file_dokumen = $les[0]->file_dokumen;
            $catatan_surat = $les[0]->catatan;
            $ringkasan_surat = $les[0]->ringkasan_surat;
          }
        $listd[] = array(
                        'id_disposisi'=>$id_disposisi,
                        'jenis_surat'=>$jenis_surat,
                        'id_surat'=>$id_surat,
                        'catatan_disposisi'=>$catatan_disposisi,
                        'instruksi'=>$instruksi,
                        'dari_user_id'=>$dari_user_id,
                        'dari_username'=>$dari_username,
                        'dari_pangkat'=>$dari_pangkat,
                        'untuk_user_id'=>$untuk_user_id,
                        'untuk_username'=>$untuk_username,
                        'untuk_pangkat'=>$untuk_pangkat,
                        'status_read_admin'=>$status_read_admin,
                        'waktu_disposisi'=>$waktu_disposisi,
                        'nomor_surat'=>$nomor_surat,
                        'tanggal_surat'=>$tanggal_surat,
                        'perihal'=>$perihal,
                        'asal_surat'=>$asal_surat,
                        'lampiran'=>$lampiran,
                        'file_dokumen'=>$file_dokumen,
                        'catatan_surat'=>$catatan_surat,
                        'ringkasan_surat'=>$ringkasan_surat,
                      );
      }
        return response()->json($listd);
    }

    public function getListDisposisi(Request $request){
      $listd = array();
      $sel = DB::connection('mysql')->select("SELECT d.id,d.jenis_surat,d.id_surat,d.catatan,d.instruksi,d.dari_user_id,e.username as dari_username,e.pangkat as dari_pangkat, d.untuk_user_id, f.username as untuk_username, f.pangkat as untuk_pangkat,d.status_read_admin,d.created_at,d.updated_at
        from tb_disposisi_surat d
        left join tb_user e on d.dari_user_id = e.id
        left join tb_user f on d.untuk_user_id = f.id
        ORDER BY id desc;");
      for ($i=0; $i < count($sel); $i++) { 
        $id_disposisi = $sel[$i]->id;
        $jenis_surat = $sel[$i]->jenis_surat;
        $id_surat = $sel[$i]->id_surat;
        $catatan_disposisi = $sel[$i]->catatan;
        $instruksi = $sel[$i]->instruksi;
        $dari_user_id = $sel[$i]->dari_user_id;
        $dari_username = $sel[$i]->dari_username;
        $dari_pangkat = $sel[$i]->dari_pangkat;
        $untuk_user_id = $sel[$i]->untuk_user_id;
        $untuk_username = $sel[$i]->untuk_username;
        $untuk_pangkat = $sel[$i]->untuk_pangkat;
        $status_read_admin = $sel[$i]->status_read_admin;
        $waktu_disposisi = $sel[$i]->created_at;
        $nomor_surat = '';
        $tanggal_surat = '';
        $perihal = '';
        $asal_surat = '';
        $lampiran = '';
        $file_dokumen = '';
        $catatan_surat = '';
        $ringkasan_surat = '';
        if ($jenis_surat==1) {
          $les = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.file_dokumen, a.catatan, a.ringkasan_surat, 
             a.id_user, b.username, b.nama_lengkap, 
             a.id_user_camat, c.username as username_camat, c.nama_lengkap as nama_lengkap_camat, c.firebase, a.status,
             a.created_at, a.updated_at, a.deleted_at
            from tb_surat_masuk a left join tb_user b on a.id_user = b.id left join tb_user c on a.id_user_camat = c.id 
            where a.id = $id_surat
            and a.deleted_at is null ;");
        }else if ($jenis_surat==2) {
          $les = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.file_dokumen, a.catatan, a.ringkasan_surat, a.status, a.created_at,
             a.id_user, b.username, b.nama_lengkap, 
             a.created_at, a.updated_at
            from tb_surat_keluar a left join tb_user b on a.id_user = b.id 
            where a.id = $id_surat ;");
        }
        if (count($les)>0) {
            $nomor_surat = $les[0]->nomor_surat;
            $tanggal_surat = $les[0]->tanggal_surat;
            $perihal = $les[0]->perihal;
            $asal_surat = $les[0]->asal_surat;
            $lampiran = $les[0]->lampiran;
            $file_dokumen = $les[0]->file_dokumen;
            $catatan_surat = $les[0]->catatan;
            $ringkasan_surat = $les[0]->ringkasan_surat;
          }
        $listd[] = array(
                        'id_disposisi'=>$id_disposisi,
                        'jenis_surat'=>$jenis_surat,
                        'id_surat'=>$id_surat,
                        'catatan_disposisi'=>$catatan_disposisi,
                        'instruksi'=>$instruksi,
                        'dari_user_id'=>$dari_user_id,
                        'dari_username'=>$dari_username,
                        'dari_pangkat'=>$dari_pangkat,
                        'untuk_user_id'=>$untuk_user_id,
                        'untuk_username'=>$untuk_username,
                        'untuk_pangkat'=>$untuk_pangkat,
                        'status_read_admin'=>$status_read_admin,
                        'waktu_disposisi'=>$waktu_disposisi,
                        'nomor_surat'=>$nomor_surat,
                        'tanggal_surat'=>$tanggal_surat,
                        'perihal'=>$perihal,
                        'asal_surat'=>$asal_surat,
                        'lampiran'=>$lampiran,
                        'file_dokumen'=>$file_dokumen,
                        'catatan_surat'=>$catatan_surat,
                        'ringkasan_surat'=>$ringkasan_surat,
                      );
      }

        return response()->json($listd);
    }

    function readDisposisi(Request $request){
        $id_disposisi = $request->id;
        $update = DB::connection('mysql')->table('tb_disposisi_surat')->where('id',$id_disposisi)
                        ->update(['status_read_admin'=>1]);

        if ($update) {
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'failed','detail'=>'update data failed']);
        }
    }

  public function checkRole(Request $request){
    $id = $request->id;
    $dt = ModelUser::where('id',$id)->first();
    $role = $dt['role'];
   // if ($role=='kasi'||$role=='kasubag') {
   //      $status_code = 0;
   //    }else if ($role=='sekcam') {
   //      $status_code = 2;
   //    }else if ($role=='camat') {
   //      $status_code = 4;
   //    }
    return response($role);
  }


  public function postAbsen(Request $request) {
    $current_timestamp = Carbon::now();
    $data = new ModelAbsen();
    $data->user_id = $request->user_id;
    $data->tanggal_absen = $current_timestamp;
    $data->jam_absen = $current_timestamp;
    $data->status_absen = $request->status_absen;
    $data->save();
    return [
      'status' => 'Success'
    ];
  }

  public function statusabsen($user_id) {
    $data = DB::table('tb_user')
            ->select('tb_user.username','tb_absen.status_absen', 'tb_absen.tanggal_absen', 'tb_absen.jam_absen')
            ->join('tb_absen', 'tb_absen.user_id', '=', 'tb_user.id')
            ->where('tb_user.id', $user_id)
            ->latest('tb_absen.created_at')
            ->first();

    if($data) {
      return [
        'status' => 'Success',
        'data' => $data
      ];
    } else {
      return [
        'status' => 'Failed',
        'data' => $data
      ];
    }
  }

  public function riwayatabsen($user_id){
    $data = DB::table('tb_user')
            ->select('tb_user.username','tb_absen.status_absen', 'tb_absen.tanggal_absen', 'tb_absen.jam_absen')
            ->join('tb_absen', 'tb_absen.user_id', '=', 'tb_user.id')
            ->where('tb_user.id', $user_id)->get( );
    if($data) {
      return [
        'status' => 'Success',
        'data' => $data
      ];
    } else {
      return [
        'status' => 'Failed',
        'data' => $data
      ];
    }
  }

}
