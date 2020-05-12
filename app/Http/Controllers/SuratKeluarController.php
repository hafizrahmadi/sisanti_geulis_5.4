<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\ModelUser;
use App\ModelSuratKeluar;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;


class SuratKeluarController extends Controller
{

    public function catatSuratKeluar(){
        // echo session('id_user');
        return view('home/catatsuratkeluar');
    }

    public function getListSuratKeluar(){
        // $sel = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.id_user, b.username, b.nama_lengkap, a.file_dokumen, a.catatan, a.created_at, a.updated_at
        //     from tb_surat_masuk a left join tb_user b on a.id_user = b.id order by 1 asc;");
        $sel = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.file_dokumen, a.catatan, a.ringkasan_surat, a.status, a.created_at,
             a.id_user, b.username, b.nama_lengkap, 
             a.created_at, a.updated_at
            from tb_surat_keluar a left join tb_user b on a.id_user = b.id 
            where a.deleted_at is null
            order by 1 desc;");


        // $sel = ModelUser::all();
        // return json_encode($sel);
        return response()->json($sel);
    }

    public function getSuratKeluar(Request $request){
        $id = $request->id;
         $sel = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.file_dokumen, a.catatan, a.ringkasan_surat, a.status, a.created_at,
             a.id_user, b.username, b.nama_lengkap, 
             a.created_at, a.updated_at
            from tb_surat_keluar a left join tb_user b on a.id_user = b.id 
            where a.id = $id ;");


        // $sel = ModelUser::all();
        // return json_encode($sel);
        return response()->json($sel);
    }

    public function addSuratKeluar(Request $request){

        if ($request->hasFile('file_dokumen')) {
            $this->validate($request, [
                // 'name' => 'required|min:4',
                // 'email' => 'required|min:4|email|unique:users',
                'nomor_surat'=>'required',
                'tanggal_surat' => 'required',
                'perihal' => 'required',
                'asal_surat'=>'required',
                'lampiran'=>'required',
                'file_dokumen'=>'file|mimes:pdf',
            ]);
        }else{
            $this->validate($request, [
            // 'name' => 'required|min:4',
            // 'email' => 'required|min:4|email|unique:users',
            'nomor_surat'=>'required',
            'tanggal_surat' => 'required',
            'perihal' => 'required',
            'asal_surat'=>'required',
            'lampiran'=>'required',
        ]);
        }
        
        if ($request->id == '') {
            $data =  new ModelSuratKeluar();
            $data->nomor_surat = $request->nomor_surat;
            $data->tanggal_surat = $request->tanggal_surat;
            $data->perihal = $request->perihal;
            $data->asal_surat = $request->asal_surat;
            $data->lampiran = $request->lampiran;
            $data->id_user = $request->id_user;
            $data->status = 0;
            
            $status_upload = true;
            $fullpath = '';
            if ($request->hasFile('file_dokumen')) {
                $file = $request->file('file_dokumen');
                $nama_file = $file->getClientOriginalName();
                $tujuan = 'file_suratkeluar';
                $aa = $file->move($tujuan,$nama_file);
                $fullpath = $tujuan.'/'.$nama_file;
                if (!$aa) {
                    $status_upload = false;
                    $fullpath = '';
                }
            }

            $data->file_dokumen = $fullpath;
            $data->ringkasan_surat = $request->ringkasan_surat;
            $data->catatan = $request->catatan;

            if ($status_upload) {    
                if ($data->save()) {
                    return response()->json(['status'=>'success']);
                }else{
                    return response()->json(['status'=>'failed','detail'=>'saving data failed']);    
                }
            }else{
                return response()->json(['status'=>'failed','detail'=>'upload file failed']);
            }
            
        }else{
            $fullpath = '';
            $status_upload = true;
            $tujuan = 'file_suratkeluar';
            $file_dokumen_lama = '';
            if ($request->hasFile('file_dokumen')) {
                $az = ModelSuratKeluar::where('id',$request->id)->first();
                $file_dokumen_lama = $az->file_dokumen;

                $file = $request->file('file_dokumen');
                $nama_file = $file->getClientOriginalName();
                
                $fullpath = $tujuan.'/'.$nama_file;
                $aa = $file->move($tujuan,$nama_file);
                if (!$aa) {
                    $status_upload = false;
                    $fullpath = '';
                }
            }

            //==== cek status surat keluar
            $dt = ModelSuratKeluar::where('id',$request->id)->first();
            $status_code = $dt['status'];
            //=====

            if ($fullpath!='') {
               File::delete($file_dokumen_lama);
               // ===== ketika surat keluar revisi
               $status_code_new = $status_code;
               if ($status_code==1||$status_code==3||$status_code==5) {
                   $status_code_new = 0;
               }
               // =====
                $xx = ModelSuratKeluar::where('id',$request->id)->update(['nomor_surat'=>$request->nomor_surat,'tanggal_surat'=>$request->tanggal_surat,'perihal'=>$request->perihal,'asal_surat'=>$request->asal_surat,'lampiran'=>$request->lampiran,'id_user'=>$request->id_user,'file_dokumen'=>$fullpath,'catatan'=>$request->catatan,'ringkasan_surat'=>$request->ringkasan_surat,'status'=>$status_code_new]);
            }else{
                $xx = ModelSuratKeluar::where('id',$request->id)->update(['nomor_surat'=>$request->nomor_surat,'tanggal_surat'=>$request->tanggal_surat,'perihal'=>$request->perihal,'asal_surat'=>$request->asal_surat,'lampiran'=>$request->lampiran,'id_user'=>$request->id_user,'catatan'=>$request->catatan,'ringkasan_surat'=>$request->ringkasan_surat]);
            }
            
            if ($status_upload) {   
                if ($xx) {
                    return response()->json(['status'=>'success']);
                }else{
                    return response()->json(['status'=>'failed','detail'=>'saving data failed']);
                }
            }else{
                return response()->json(['status'=>'failed','detail'=>'upload file failed']);
            }
            // return json_encode($xx);
        }


        // return redirect('login')->with('alert-success','Kamu berhasil Register');
    }

    public function deleteSuratKeluar(Request $request){
        $data = ModelSuratKeluar::find($request->id)->first();
        // $tujuan = 'file_suratkeluar';
        // File::delete($data->file_dokumen);
        $xx = $data->delete();
        if ($xx) {
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'failed','detail'=>'delete data failed']);
        }
    }

    public function forceDeleteSuratKeluar(Request $request){ 
        // coming soon
        // File::delete($data->file_dokumen);
    }

    public function getListKasiKasubag(){
        $sel = DB::connection('mysql')->select("SELECT a.id,a.username,a.password,a.npk,a.nama_lengkap,a.pangkat,a.golongan,a.jabatan,a.role,a.token,a.firebase,b.nama_jabatan from tb_user a left join tb_jabatan b on a.jabatan = b.id  where a.role = 'kasi' or a.role='kasubag' order by 1 asc;");
        // return json_encode($sel);
        return response()->json($sel);
    }

    public function getListSekcam(){
        $sel = DB::connection('mysql')->select("SELECT a.id,a.username,a.password,a.npk,a.nama_lengkap,a.pangkat,a.golongan,a.jabatan,a.role,a.token,a.firebase,b.nama_jabatan from tb_user a left join tb_jabatan b on a.jabatan = b.id  where a.role = 'sekcam' order by 1 asc;");
        // return json_encode($sel);
        return response()->json($sel);
    }

    public function getListCamat(){
        $sel = DB::connection('mysql')->select("SELECT a.id,a.username,a.password,a.npk,a.nama_lengkap,a.pangkat,a.golongan,a.jabatan,a.role,a.token,a.firebase,b.nama_jabatan from tb_user a left join tb_jabatan b on a.jabatan = b.id  where a.role = 'camat' order by 1 asc;");
        // return json_encode($sel);
        return response()->json($sel);
    }

    public function getListNotifDisposisi(){
        $sel = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.file_dokumen, a.catatan, a.ringkasan_surat,
            a.id_user, b.username, b.nama_lengkap,
            a.id_user_camat, c.username as username_camat, c.nama_lengkap as nama_lengkap_camat, c.firebase, a.status_read_camat,
            a.created_at, a.updated_at, d.id as id_disposisi, d.catatan as catatan_disposisi,d.instruksi,d.status_read_admin,
            d.dari_user_id,e.username as dari_username,e.pangkat as dari_pangkat, d.untuk_user_id, f.username as untuk_username, f.pangkat as untuk_pangkat,d.created_at as waktu_disposisi
            from tb_surat_masuk a left join tb_user b on a.id_user = b.id
            left join tb_user c on a.id_user_camat = c.id
            left join tb_feeback_surat_masuk d on d.id_surat_masuk = a.id
            left join tb_user e on d.dari_user_id = e.id
            left join tb_user f on d.untuk_user_id = f.id
            where d.id is not null
            and d.status_read_admin = 0
            GROUP BY d.id order by d.id desc;");

         // $sel = DB::connection('mysql')->select("SELECT * from tb_feeback_surat_masuk d  where d.id is not null and d.status_read_admin = 0 order by 1 asc;");
        return response()->json($sel);
    }

    public function getListDisposisi(){
        $sel = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.file_dokumen, a.catatan, a.ringkasan_surat,
            a.id_user, b.username, b.nama_lengkap,
            a.id_user_camat, c.username as username_camat, c.nama_lengkap as nama_lengkap_camat, c.firebase, a.status_read_camat,
            a.created_at, a.updated_at, d.id as id_disposisi, d.catatan as catatan_disposisi,d.instruksi,d.status_read_admin,
            d.dari_user_id,e.username as dari_username,e.pangkat as dari_pangkat, d.untuk_user_id, f.username as untuk_username, f.pangkat as untuk_pangkat,d.created_at as waktu_disposisi
            from tb_surat_masuk a left join tb_user b on a.id_user = b.id
            left join tb_user c on a.id_user_camat = c.id
            left join tb_feeback_surat_masuk d on d.id_surat_masuk = a.id
            left join tb_user e on d.dari_user_id = e.id
            left join tb_user f on d.untuk_user_id = f.id
            where d.id is not null
            GROUP BY d.id order by d.id desc;");

         // $sel = DB::connection('mysql')->select("SELECT * from tb_feeback_surat_masuk d  where d.id is not null and d.status_read_admin = 0 order by 1 asc;");
        return response()->json($sel);
    }

    function readDisposisi(Request $request){
        $id_disposisi = $request->id;
        $update = DB::connection('mysql')->table('tb_feeback_surat_masuk')->where('id',$id_disposisi)
                        ->update(['status_read_admin'=>1]);

        if ($update) {
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'failed','detail'=>'update data failed']);
        }
    }

    function getDistinctDateSuratKeluar(){
        $sel = DB::connection('mysql')->select("SELECT distinct date(created_at) tanggal from tb_surat_keluar where  deleted_at is null order by 1 desc;");
        return response()->json($sel);
    }

    function getListSuratKeluarByDate(Request $request){
        $date = $request->date;
        $sel = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.file_dokumen, a.catatan, a.ringkasan_surat, a.status, a.created_at,
             a.id_user, b.username, b.nama_lengkap, 
             a.created_at, a.updated_at
            from tb_surat_keluar a left join tb_user b on a.id_user = b.id 
            where date(a.created_at) = '$date'");
        return response()->json($sel);   
    }
}
