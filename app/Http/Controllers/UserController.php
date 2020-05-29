<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\ModelUser;
use App\ModelJabatan;
use App\ModelOrganisasi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    public function index(){
        if(!Session::get('login')){
            // return redirect('/')->with('alert','Kamu harus login dulu');
            return $this->login();
        }
        else{
            return redirect('home');
        }
    }

    public function login(){
        return view('login');
    }

    public function loginPost(Request $request){

        $username = $request->username;
        $password = $request->password;

        $data = ModelUser::where('username',$username)->first();
        if($data){ //apakah email tersebut ada atau tidak
            // if(Hash::check($password,$data->password)){
            if ($password==$data->password) {
                Session::put('id_user',$data->id);
                Session::put('username',$data->username);
                Session::put('nama_lengkap',$data->nama_lengkap);
                Session::put('pangkat',$data->pangkat);
                Session::put('jabatan',$data->jabatan);
                Session::put('npk',$data->npk);
                Session::put('role',$data->role);
                Session::put('token',$data->token);
                Session::put('login',TRUE);

                $nama_jabatan = '';
                if ($data->jabatan!=null||$data->jabatan!='') {
                    $jbt = ModelJabatan::where('id',$data->jabatan)->first();
                    $nama_jabatan = $jbt->nama_jabatan;
                }
                Session::put('nama_jabatan',$nama_jabatan);
                return redirect('home')->with('alert','Halo '.session('username').' ! Selamat bekerja sama dengan SISANTI GEULIS :)');
            }
            else{
                return redirect('/')->with('alert','Username atau Password, Salah !');
            }
        }
        else{
            return redirect('/')->with('alert','Username atau Password, Salah!');
        }
    }

    public function logout(){
        Session::flush();
        return redirect('/')->with('alert','Anda sudah logout');
    }

    public function masteruser(){
        return view('home/masteruser');
    }

    public function getListUser(){
        $sel = DB::connection('mysql')->select("SELECT a.id,a.username,a.password,a.npk,a.nama_lengkap,a.pangkat,a.golongan,a.jabatan,a.role,a.token,a.firebase,b.nama_jabatan, c.leader_id as atasan, c.under_id as bawahan
            from tb_user a left join tb_jabatan b on a.jabatan = b.id 
            left join tb_organisasi c on c.id = a.id
            order by 1 asc");
        // $sel = ModelUser::all();
        // return json_encode($sel);
        // return $sel;
        return response()->json($sel);
    }

    public function getListAbsen(){
        $arr_absen = array();
        $sel = DB::connection('mysql')->select("SELECT a.id,a.username,a.password,a.npk,a.nama_lengkap,a.pangkat,a.golongan,a.jabatan,a.role,a.token,a.firebase,b.nama_jabatan from tb_user a left join tb_jabatan b on a.jabatan = b.id order by 1 asc;");

        for ($i=0; $i < count($sel); $i++) { 
            $id = $sel[$i]->id;
            $sss = DB::connection('mysql')->select("SELECT * from tb_absen where user_id='$id' order by created_at desc limit 1;");
            $status_absen = '';
            if (count($sss)>0) {
                $status_absen = $sss[0]->status_absen." : ".$sss[0]->tanggal_absen." (".$sss[0]->jam_absen.")";
            }
            
            // dd($status_absen);
            $arr_absen[] = array(
                                'id'=>$sel[$i]->id,
                                'username'=>$sel[$i]->username,
                                'npk'=>$sel[$i]->npk,
                                'nama_lengkap'=>$sel[$i]->nama_lengkap,
                                'pangkat'=>$sel[$i]->pangkat,
                                'golongan'=>$sel[$i]->golongan,
                                'jabatan'=>$sel[$i]->jabatan,
                                'nama_jabatan'=>$sel[$i]->nama_jabatan,
                                'status_absen'=>$status_absen
                                );
        }
        // $sel = ModelUser::all();
        // return json_encode($sel);
        // return $sel;
        return response()->json($arr_absen);
    }

    public function addUserPost(Request $request){
        $this->validate($request, [
            // 'name' => 'required|min:4',
            // 'email' => 'required|min:4|email|unique:users',
            'username'=>'required',
            'password' => 'required',
            'conf_password' => 'required|same:password',
            'role'=>'required',
        ]);
        if ($request->id_user == '') {
            $data =  new ModelUser();
            $data->username = $request->username;
            $data->password = $request->password;
            $data->npk = $request->npk;
            $data->nama_lengkap = $request->nama_lengkap;
            $data->pangkat = $request->pangkat;
            $data->golongan = $request->golongan;
            $data->jabatan = $request->jabatan;
            $data->role = $request->role;
            $data->token = "-"; //sementara
            // $data->password = bcrypt($request->password);
            // $data->password = $request->password;
            return json_encode($data->save());
        }else{
            $yy = ModelOrganisasi::where('id',$request->id_user)->get();
            // $ak = true;
            if (count($yy)>0) {
              
              ModelOrganisasi::where('id',$request->id_user)->update(['leader_id'=>$request->atasan,'under_id'=>$request->bawahan]);
            }else{
                $oo = new ModelOrganisasi();
                $oo->id = $request->id_user;
                $oo->leader_id = $request->atasan;
                $oo->under_id = $request->bawahan;
                $oo->save();
            }

            $xx = ModelUser::where('id',$request->id_user)->update(['username'=>$request->username,'password'=>$request->password,'npk'=>$request->npk,'nama_lengkap'=>$request->nama_lengkap,'pangkat'=>$request->pangkat,'golongan'=>$request->golongan,'jabatan'=>$request->jabatan,'role'=>$request->role]);
            return json_encode($xx);
        }


        // return redirect('login')->with('alert-success','Kamu berhasil Register');
    }


    public function deleteUser(Request $request){
    $data = ModelUser::where('id',$request->id);

    return json_encode($data->delete());
    }

    public function getListJabatan(){
        $sel = DB::connection('mysql')->select("SELECT * from tb_jabatan;");
        return json_encode($sel);
    }
}
