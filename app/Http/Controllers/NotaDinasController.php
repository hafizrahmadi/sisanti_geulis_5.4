<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\ModelUser;
use App\ModelNotaDinas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;


class NotaDinasController extends Controller
{

    public function catatNotaDinas(){
        // echo session('id_user');
        return view('home/catatnotadinas');
    }

    public function getListNotaDinas(){
        // $sel = DB::connection('mysql')->select("SELECT a.id, a.nomor_surat, a.tanggal_surat, a.perihal, a.asal_surat, a.lampiran, a.id_user, b.username, b.nama_lengkap, a.file_dokumen, a.catatan, a.created_at, a.updated_at
        //     from tb_surat_masuk a left join tb_user b on a.id_user = b.id order by 1 asc;");
        $sel = DB::connection('mysql')->select("SELECT id, tanggal, nomor, asal, sifat, lampiran, perihal, isi_ringkas,
            tujuan, tembusan, file_dokumen, jenis, id_surat_masuk,
             created_at, updated_at,deleted_at
            from tb_nota_dinas
            where deleted_at is null
            order by 1 desc;");


        // $sel = ModelUser::all();
        // return json_encode($sel);
        return response()->json($sel);
    }

    public function getNotaDinas(Request $request){
        $id = $request->id;
         $sel = DB::connection('mysql')->select("SELECT id, tanggal, nomor, asal, sifat, lampiran, perihal, isi_ringkas,
            tujuan, tembusan, file_dokumen, jenis, id_surat_masuk,
             created_at, updated_at,deleted_at
            from tb_nota_dinas
            where deleted_at is null
            and id = $id;");


        // $sel = ModelUser::all();
        // return json_encode($sel);
        return response()->json($sel);
    }

    public function addNotaDinas(Request $request){
        
        // return response()->json($request);
        if ($request->hasFile('file_dokumen')) {
            $this->validate($request, [
                // 'name' => 'required|min:4',
                // 'email' => 'required|min:4|email|unique:users',
                'tanggal' => 'required',
                'perihal' => 'required',
                'asal'=>'required',
                'tujuan'=>'required',
                'sifat'=>'required',
                'jenis'=>'required',
                'file_dokumen'=>'file|mimes:pdf',
            ]);
        }else{
            $this->validate($request, [
            // 'name' => 'required|min:4',
            // 'email' => 'required|min:4|email|unique:users',
            'tanggal' => 'required',
            'perihal' => 'required',
            'asal'=>'required',
            'tujuan'=>'required',
            'sifat'=>'required',
            'jenis'=>'required',
        ]);
        }
        
        if ($request->id == '') {
            $data =  new ModelNotaDinas();
            $data->nomor = $request->nomor;
            $data->tanggal = $request->tanggal;
            $data->perihal = $request->perihal;
            $data->asal = $request->asal;
            $data->tujuan = $request->tujuan;
            $data->lampiran = $request->lampiran;
            $data->isi_ringkas = $request->isi_ringkas;
            $data->tembusan = $request->tembusan;
            $data->sifat = $request->sifat;
            $data->jenis = $request->jenis;
            $data->id_surat_masuk = $request->id_surat_masuk;
            
            $status_upload = true;
            $fullpath = '';
            if ($request->hasFile('file_dokumen')) {
                $file = $request->file('file_dokumen');
                $nama_file = $file->getClientOriginalName();
                $tujuan = 'file_notadinas';
                $aa = $file->move($tujuan,$nama_file);
                $fullpath = $tujuan.'/'.$nama_file;
                if (!$aa) {
                    $status_upload = false;
                    $fullpath = '';
                }
            }

            $data->file_dokumen = $fullpath;

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
            $tujuan = 'file_notadinas';
            $file_dokumen_lama = '';
            if ($request->hasFile('file_dokumen')) {
                $az = ModelNotaDinas::where('id',$request->id)->first();
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
                $xx = ModelNotaDinas::where('id',$request->id)->update([
                    'nomor' => $request->nomor,
                    'tanggal' => $request->tanggal,
                    'perihal' => $request->perihal,
                    'asal' => $request->asal,
                    'tujuan' => $request->tujuan,
                    'lampiran' => $request->lampiran,
                    'isi_ringkas' => $request->isi_ringkas,
                    'tembusan' => $request->tembusan,
                    'sifat' => $request->sifat,
                    'jenis' => $request->jenis,
                    'id_surat_masuk' => $request->id_surat_masuk,
                    'file_dokumen'=>$fullpath
                ]);
            }else{
                $xx = ModelNotaDinas::where('id',$request->id)->update([
                    'nomor' => $request->nomor,
                    'tanggal' => $request->tanggal,
                    'perihal' => $request->perihal,
                    'asal' => $request->asal,
                    'tujuan' => $request->tujuan,
                    'lampiran' => $request->lampiran,
                    'isi_ringkas' => $request->isi_ringkas,
                    'tembusan' => $request->tembusan,
                    'sifat' => $request->sifat,
                    'jenis' => $request->jenis,
                    'id_surat_masuk' => $request->id_surat_masuk,
                ]);
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

    public function deleteNotaDinas(Request $request){
        $data = ModelNotaDinas::find($request->id)->first();
        // $tujuan = 'file_notadinas';
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

   
}
