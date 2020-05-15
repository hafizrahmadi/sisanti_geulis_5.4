@extends('home.template')
@section('css')
<style type="text/css">
  .td_limit {
     max-width: 50px;
      text-overflow: ellipsis;
      overflow: hidden;
      white-space: nowrap;
  }
</style>
@endsection
@section('content-header')
    <h1>Absen Karyawan</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Absen Karyawan</li>
      </ol>
@endsection
@section('content')
    <!-- Default box -->
    <div class="box" >
        <div class="box-header with-border">
            <h3 class="box-title">Absen {{session('username')}}</h3>
            <div class="box-tools pull-right">
                <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button> -->
            </div>
        </div>
        <div class="box-body" id="body-absen">

        </div>
        <div class="box-footer" id="footer-absen">
                
        </div>
        <div class="overlay div_loading" id="loading"><i class="fa fa-refresh fa-spin"></i></div>
        <!-- <div class="box-footer">

        </div> --><!-- /.box-footer-->
    </div><!-- /.box -->
@endsection

@section('outside-content')
    
@endsection

@section('script')
<link rel="stylesheet" href="{{asset('file_assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.css') }}">
<!-- DataTables -->
<script src="{{asset('file_assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{asset('file_assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<script type="text/javascript">
    var status_absen = null;
    $(document).ready(function() {
        getStatusAbsen();
        // getListJabatan();

    });

  function getStatusAbsen(){
    $.ajax({
                url: "{{url('/api/status_absen/')}}"+"/"+"{{session('id_user')}}",
                type: "GET",
                data: {
                },
                beforeSend: function() {
                  $('#loading').show();
                },
                success: function(dt) {
                  // dt = JSON.parse(data);
                  console.log(dt);
                  content = '';
                  if (dt.status=='Failed') {
                    content+='<div class="form-group">'+
                      '<label for="exampleInputEmail1">Nama</label>'+
                      '<div>'+"{{session('nama_lengkap')}}"+'</div>'+
                    '</div>';
                    content+='<div class="form-group">'+
                      '<label for="exampleInputEmail1">NPK</label>'+
                      '<div>'+"{{session('npk')}}"+'</div>'+
                    '</div>';
                    content+='<div class="form-group">'+
                      '<label for="exampleInputEmail1">Jabatan</label>'+
                      // '<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">'+
                      '<div>'+"{{session('nama_jabatan')}}"+'</div>'+
                    '</div>';
                    content+='<div class="form-group">'+
                      '<label for="exampleInputEmail1">Status Absen</label>'+
                      // '<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">'+
                      '<div>Belum ada absen</div>'+
                    '</div>';
                    content+='<div class="form-group">'+
                      '<label for="exampleInputEmail1">Absen Terakhir</label>'+
                      // '<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">'+
                      '<div>Belum ada absen</div>'+
                    '</div>';
                  }else if (dt.status=='Success') {
                    content+='<div class="form-group">'+
                      '<label for="exampleInputEmail1">Nama</label>'+
                      '<div>'+"{{session('nama_lengkap')}}"+'</div>'+
                    '</div>';
                    content+='<div class="form-group">'+
                      '<label for="exampleInputEmail1">NPK</label>'+
                      '<div>'+"{{session('npk')}}"+'</div>'+
                    '</div>';
                    content+='<div class="form-group">'+
                      '<label for="exampleInputEmail1">Jabatan</label>'+
                      // '<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">'+
                      '<div>'+"{{session('nama_jabatan')}}"+'</div>'+
                    '</div>';
                    content+='<div class="form-group">'+
                      '<label for="exampleInputEmail1">Status Absen</label>'+
                      // '<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">'+
                      '<div>'+dt.data.status_absen+'</div>'+
                    '</div>';
                    content+='<div class="form-group">'+
                      '<label for="exampleInputEmail1">Absen Terakhir</label>'+
                      // '<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">'+
                      '<div>'+dt.data.tanggal_absen+' ('+dt.data.jam_absen+')</div>'+
                    '</div>';
                  }

                  $('#body-absen').html(content);

                  ctn = '';
                  if (dt.status=='Failed') {
                    status_absen= 'Masuk';
                    ctn+='<button type="submit" onclick="submitAbsen()" class="btn btn-teal"><i class="fa fa-sign-in"></i> Absen Masuk</button>';
                  }else{
                    if (dt.data.status_absen=='Masuk') {
                      status_absen= 'Keluar';
                      ctn+='<button type="submit" onclick="submitAbsen()" class="btn btn-teal"><i class="fa fa-sign-in"></i> Absen Keluar</button>';
                    }else{
                      status_absen= 'Masuk';
                      ctn+='<button type="submit" onclick="submitAbsen()" class="btn btn-teal"><i class="fa fa-sign-in"></i> Absen Masuk</button>';
                    }
                    
                  }

                  $('#footer-absen').html(ctn);
                },
                complete: function() {

                  $('#loading').hide();
                },
                error: function() {
                    alert("Memproses data gagal !");
                }
            });
  }

  function submitAbsen(){
    $.ajax({
               url: "{{url('/api/post_absen/')}}",
               type: "POST",
               data: {
                    _token: '{{csrf_token()}}',
                  'user_id': "{{session('id_user')}}",
                  'status_absen':status_absen
               },
               beforeSend: function() {
                 console.log({
                   _token: '{{csrf_token()}}',
                  'user_id': "{{session('id_user')}}",
                  'status_absen':status_absen
                 });


               },
               success: function(data) {
                    // alert(data);
                    if (data.status=='Success') {
                        alert('Absen berhasil!');
                    }else{
                        alert('Absen gagal!');
                    }
               },
               complete: function() {
                 getStatusAbsen();
               },
               error: function() {
                   alert("Memproses data gagal !");
               }
           });
  }
</script>
@endsection
