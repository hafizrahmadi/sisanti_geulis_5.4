<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\ModelUser;
use App\ModelSuratMasuk;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;


class SuratMasukController extends Controller
{

    public function catatSuratMasuk(){
        // echo session('id_user');
        return view('home/catatsuratmasuk');
    }

    public function getListSuratMasuk(){
        // $sel = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.id_user, b.username, b.nama_lengkap, a.file_dokumen, a.catatan, a.created_at, a.updated_at
        //     from tb_surat_masuk a left join tb_user b on a.id_user = b.id order by 1 asc;");
        $sel = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.file_dokumen, a.catatan, a.ringkasan_surat, 
             a.id_user, b.username, b.nama_lengkap, 
             a.id_user_camat, c.username as username_camat, c.nama_lengkap as nama_lengkap_camat, c.firebase, a.status,
             a.created_at, a.updated_at, a.deleted_at
            from tb_surat_masuk a left join tb_user b on a.id_user = b.id left join tb_user c on a.id_user_camat = c.id 
            where a.deleted_at is null
            order by 1 desc;");


        // $sel = ModelUser::all();
        // return json_encode($sel);
        return response()->json($sel);
    }

    public function getSuratMasuk(Request $request){
        $id = $request->id;
         $sel = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.file_dokumen, a.catatan, a.ringkasan_surat, 
             a.id_user, b.username, b.nama_lengkap, 
             a.id_user_camat, c.username as username_camat, c.nama_lengkap as nama_lengkap_camat, c.firebase, a.status,
             a.created_at, a.updated_at, a.deleted_at
            from tb_surat_masuk a left join tb_user b on a.id_user = b.id left join tb_user c on a.id_user_camat = c.id 
            where a.id = $id
            and a.deleted_at is null
            ;");


        // $sel = ModelUser::all();
        // return json_encode($sel);
        return response()->json($sel);
    }

    public function addSuratMasuk(Request $request){
        // $id_user = session('id_user');
        
        // if ($id_user!==null) {
        //     return response()->json($id_user);
        // }else{
        //     return response()->json(['status'=>'failed','detail'=>'no session']);
        // }

        
        // return response()->json($request);
        if ($request->hasFile('file_dokumen')) {
            $this->validate($request, [
                // 'name' => 'required|min:4',
                // 'email' => 'required|min:4|email|unique:users',
                'nomor_surat'=>'required',
                'tanggal_surat' => 'required',
                'perihal' => 'required',
                'asal_surat'=>'required',
                // 'lampiran'=>'required',
                'id_user_camat'=>'required',
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
            // 'lampiran'=>'required',
            'id_user_camat'=>'required',
        ]);
        }
        
        if ($request->id == '') {
            $data =  new ModelSuratMasuk();
            $data->nomor_surat = $request->nomor_surat;
            $data->tanggal_surat = $request->tanggal_surat;
            $data->perihal = $request->perihal;
            $data->asal_surat = $request->asal_surat;
            $data->lampiran = $request->lampiran;
            $data->id_user = $request->id_user;
            $data->id_user_camat = $request->id_user_camat;
            $data->status = null;
            
            $status_upload = true;
            $fullpath = '';
            if ($request->hasFile('file_dokumen')) {
                $file = $request->file('file_dokumen');
                $nama_file = $file->getClientOriginalName();
                $tujuan = 'file_suratmasuk';
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
            $tujuan = 'file_suratmasuk';
            $file_dokumen_lama = '';
            if ($request->hasFile('file_dokumen')) {
                $az = ModelSuratMasuk::where('id',$request->id)->first();
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

            if ($fullpath!='') {
               File::delete($file_dokumen_lama);
                $xx = ModelSuratMasuk::where('id',$request->id)->update(['nomor_surat'=>$request->nomor_surat,'tanggal_surat'=>$request->tanggal_surat,'perihal'=>$request->perihal,'asal_surat'=>$request->asal_surat,'lampiran'=>$request->lampiran,'id_user'=>$request->id_user,'file_dokumen'=>$fullpath,'catatan'=>$request->catatan,'ringkasan_surat'=>$request->ringkasan_surat,'id_user_camat'=>$request->id_user_camat]);
            }else{
                $xx = ModelSuratMasuk::where('id',$request->id)->update(['nomor_surat'=>$request->nomor_surat,'tanggal_surat'=>$request->tanggal_surat,'perihal'=>$request->perihal,'asal_surat'=>$request->asal_surat,'lampiran'=>$request->lampiran,'id_user'=>$request->id_user,'catatan'=>$request->catatan,'ringkasan_surat'=>$request->ringkasan_surat,'id_user_camat'=>$request->id_user_camat]);
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

    public function deleteSuratMasuk(Request $request){
        $data = ModelSuratMasuk::where('id',$request->id)->first();
        // $tujuan = 'file_suratmasuk';
        // File::delete($data->file_dokumen);
        $xx = $data->delete();
        if ($xx) {
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'failed','detail'=>'delete data failed']);
        }
    }

    public function forceDeleteSuratMasuk(Request $request){ 
        // coming soon
        // File::delete($data->file_dokumen);
    }

    public function getListCamat(){
        $sel = DB::connection('mysql')->select("SELECT a.id,a.username,a.password,a.npk,a.nama_lengkap,a.pangkat,a.golongan,a.jabatan,a.role,a.token,a.firebase,b.nama_jabatan from tb_user a left join tb_jabatan b on a.jabatan = b.id  where a.role = 'camat' order by 1 asc;");
        // return json_encode($sel);
        return response()->json($sel);
    }


    function getDistinctDateSuratMasuk(){
        $sel = DB::connection('mysql')->select("SELECT distinct date(created_at) tanggal from tb_surat_masuk where deleted_at is null order by 1 desc;");
        return response()->json($sel);
    }

    function getListSuratMasukByDate(Request $request){
        $date = $request->date;
        $sel = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.file_dokumen, a.catatan, a.ringkasan_surat, 
             a.id_user, b.username, b.nama_lengkap, 
             a.id_user_camat, c.username as username_camat, c.nama_lengkap as nama_lengkap_camat, c.firebase, a.status,
             a.created_at, a.updated_at, a.deleted_at
            from tb_surat_masuk a left join tb_user b on a.id_user = b.id left join tb_user c on a.id_user_camat = c.id 
            where date(a.created_at) = '$date'");
        return response()->json($sel);   
    }
}
