<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\ModelUser;
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
                Session::put('username',$data->username);
                Session::put('role',$data->role);
                Session::put('token',$data->token);
                Session::put('login',TRUE);
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

    public function masteruser(Request $request){
        return view('register');
    }

    public function getListUser(){
        $sel = DB::connection('mysql')->select("SELECT a.id,a.username,a.password,a.npk,a.nama_lengkap,a.pangkat,a.golongan,a.jabatan,a.role,a.token,a.firebase,b.nama_jabatan from tb_user a left join tb_jabatan b on a.jabatan = b.id order by 1 asc;");
        // $sel = ModelUser::all();
        return json_encode($sel);
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
            $xx = ModelUser::where('id',$request->id_user)->update(['username'=>$request->username,'password'=>$request->password,'npk'=>$request->npk,'nama_lengkap'=>$request->nama_lengkap,'pangkat'=>$request->pangkat,'golongan'=>$request->golongan,'jabatan'=>$request->jabatan,'role'=>$request->role]);
            return json_encode($xx);
        }


        // return redirect('login')->with('alert-success','Kamu berhasil Register');
    }

    public function deleteUser(Request $request){
    $data = ModelUser::find($request->id);

    return json_encode($data->delete());
    }

    public function getListJabatan(){
        $sel = DB::connection('mysql')->select("SELECT * from tb_jabatan;");
        return json_encode($sel);
    }
}
