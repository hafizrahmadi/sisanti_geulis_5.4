@extends('home.template')
@section('css')
<style type="text/css">
  .td_limit {
     max-width: 50px;
      text-overflow: ellipsis;
      overflow: hidden;
      white-space: nowrap;
  }

  /*th, td { white-space: nowrap; }*/
    div.dataTables_wrapper {
        width: 100%;
        /*margin: 0 auto;*/
    }
</style>
@endsection
@section('content-header')
    <h1>Laporan Absen Pegawai</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Laporan Absen Pegawai</li>
      </ol>
@endsection
@section('content')
    <!-- Default box -->
    <div class="box" >
        <div class="box-header with-border">
            <h3 class="box-title">Data Absen Pegawai</h3>
            <div class="box-tools pull-right">
                <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button> -->
                <!-- <a href="javascript:modalForm('Tambah Surat Masuk','','');"><button class="btn btn-sm btn-teal"><i class="fa fa-pencil-square-o" style=""></i> Tambah Surat Masuk</button></a> -->
            </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id="tablex" class="table table-bordered table-striped " style="width: 100%;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NPK</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan</th>
                        <th>Pangkat</th>
                        <th>Status Absensi</th>
                        <th class="no-sort text-center" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                </tbody>
            </table>
            </div><!-- /.box-body -->

        </div>
        <div class="overlay div_loading" id="loading"><i class="fa fa-refresh fa-spin"></i></div>
        <!-- <div class="box-footer">

        </div> --><!-- /.box-footer-->
    </div><!-- /.box -->
@endsection

@section('outside-content')
<div class="modal fade" id="modal-detail" role="dialog" style="z-index: 1050;">
   <div class="modal-dialog">
      <div class="box box-success">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title" id="modal_detail_title" style="font-weight:bold;"></h4>
            </div>
            <div class="modal-body" id="modal-body">
               
            </div>
            <div class="modal-footer">
               <!-- <button type="button" class="btn btn-sm btn-default" title="Reset" id="appendix1_reset"><i class="fa fa-undo"></i></button> -->
               <button type="button" class="btn btn-sm btn-teal" title="Save" id="btn_excel"><i class="fa fa-file-excel-o"></i> Ekspor File Excel</button>
            </div>
         </div>
      </div>
      <!-- /.box -->
   </div>
</div>



@endsection

@section('script')
<link rel="stylesheet" href="{{asset('file_assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.css') }}">
<!-- DataTables -->
<script src="{{asset('file_assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{asset('file_assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>


<script src="{{asset('file_assets/jquery.table2excel.js')}}"></script>

<script type="text/javascript">
    var tablex = null;
    $(document).ready(function() {
      getListAbsen();
      // getListCamat();
    });

   

  function getListAbsen(){
    $('#tbody').html("");
    $.ajax({
                url: "{{url('/api/getlistabsen')}}",
                type: "GET",
                data: {
                },
                beforeSend: function() {
                  // console.log(tablex);

                  if (tablex!=null) {
                    tablex.destroy();
                  }
                  $('#loading').show();
                },
                success: function(dt) {
                  // dt = JSON.parse(data);

                  console.log(dt);
                  content = '';
                  for (var i = 0; i < dt.length; i++) {
                    // hhh = '';
                    // if (dt[i].status_read_admin==0) {
                    //   hhh = '&nbsp;<a href="javascript:readAbsen('+dt[i].id_Absen+')">'+
                    //                    '<button class="btn btn-xs btn-teal" title="Baca Absen"><i class="fa fa-eye" style=""></i></button>'+
                    //                    '</a>';
                    // }
                    
                    content+='<tr>'+
                                '<td>'+(i+1)+'</td>'+
                                // '<td id="id_user_'+(i+1)+'" data-val="'+dt[i].id+'">'+dt[i].id+'</td>'+
                                '<td>'+dt[i].npk+'</td>'+
                                '<td>'+dt[i].nama_lengkap+'</td>'+
                                '<td>'+dt[i].nama_jabatan+'</td>'+
                                '<td>'+dt[i].pangkat+'</td>'+
                                '<td>'+dt[i].status_absen+'</td>'+
                                '<td class="text-center">'+
                                      '<div class="btn-group" >'+
                                      // '<a href="javascript:modalForm(\'Edit Surat Masuk\',\''+(i+1)+'\',\''+dt[i].id+'\')">'+
                                      //  '<button class="btn btn-xs btn-teal" title="Edit"><i class="fa fa-pencil" style=""></i></button>'+
                                      //  '</a>&nbsp;'+
                                       '<a href="javascript:modalDetail(\'Riwayat Absensi '+dt[i].nama_lengkap+'\',\''+dt[i].id+'\',\''+dt[i].npk+'\',\''+dt[i].nama_lengkap+'\')">'+
                                       '<button class="btn btn-xs btn-teal" title="Lihat detail surat masuk"><i class="fa fa-search" style=""></i></button>'+
                                       '</a>'+
                                       // hhh+
                                      '</div>'+
                                  '</td>'+
                              '</tr>';
                  }
                  $('#tbody').html(content);
                },
                complete: function() {

                  tablex = $('#tablex').DataTable({
                      //  scrollX:        true,
                      //  scrollCollapse: true,
                      //  fixedColumns:   {
                      //     leftColumns: 0,
                      //     rightColumns: 3,
                      // },
                      // paging:         false,
                      "columnDefs": [
                      { "targets": 6, "orderable": false},
                      // { "targets": 9, "orderable": false},{ "targets": 10, "orderable": false},
                    ]
                    // "paging": true,
                    // "lengthChange": false,
                    // "searching": false,
                    // "ordering": false,
                    // "info": true,
                    // "autoWidth": false,

                  });
                  $('#loading').hide();
                },
                error: function() {
                    alert("Memproses data gagal !");
                }
            });
  }


  function modalDetail(title,id,npk,nama){
        var table_riwayat = null;
        if (id!='') {
           $.ajax({
                url: "{{url('/api/riwayat_absen')}}"+"/"+id,
                type: "GET",
                data: {
                  // 'id':id
                },
                beforeSend: function() {

                },
                success: function(dt) {
                  // dt = JSON.parse(data);

                  console.log(dt);
                  data = dt.data;
                  var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                  
                  content = '<table id="table_riwayat" class="table table-bordered table-striped " style="width: 100%;">'+
                      '<thead>'+
                          '<tr>'+
                              '<th>No.</th>'+
                              '<th>Nama</th>'+
                              '<th>Status Absen</th>'+
                              '<th>Tanggal</th>'+
                              '<th>Waktu</th>'+
                          '</tr>'+
                      '</thead>'+
                      '<tbody id="tbody-riwayat">';
                  for (var i = 0; i < data.length; i++) {
                    var d = new Date(data[i].tanggal_absen);
                    var dayName = days[d.getDay()];
                    content+='<tr>'+
                              '<td>'+(i+1)+'</td>'+
                              '<td>'+nama+'</td>'+
                              '<td>'+data[i].status_absen+'</td>'+
                              '<td>'+data[i].tanggal_absen+' ('+dayName+')</td>'+
                              '<td>'+data[i].jam_absen+'</td>'+
                              '</tr>';
                  }
                  content+='</tbody>'+'</table>';
                  $('#modal-body').html(content);
                  $('#modal-detail').modal('show');
                  $('#modal_detail_title').html(title);
                  $('#btn_excel').attr('onclick', 'exportExcel(\''+npk+'\',\''+nama+'\')');
                },
                complete: function() {
                   table_riwayat = $('#table_riwayat').DataTable({
                      //  scrollX:        true,
                      //  scrollCollapse: true,
                      //  fixedColumns:   {
                      //     leftColumns: 0,
                      //     rightColumns: 3,
                      // },
                      // paging:         false,
                    //   "columnDefs": [
                    //   { "targets": 6, "orderable": false},
                    // ]
                    // "paging": true,
                    // "lengthChange": false,
                    // "searching": false,
                    // "ordering": false,
                    // "info": true,
                    // "autoWidth": false,

                  });
                },
                error: function() {
                    alert("Memproses data gagal !");
                }
            });
        }
  }

  function exportExcel(npk,nama){
    $("#table_riwayat").table2excel({
 // exclude CSS class
    exclude: ".noExl",
    name: "Worksheet Name",
    filename: "riwayat_absen_"+npk+"_"+nama+".xls", //do not include extension
    // fileext: ".xls" // file extension
  });

  }

  function readAbsen(id){
    $.ajax({
               url: "{{url('/api/readAbsen')}}",
               type: "POST",
               data: {
                    _token: '{{csrf_token()}}',
                  'id': id,
               },
               beforeSend: function() {
                 console.log({
                   _token: '{{csrf_token()}}',
                  'id': id,
                 });
                // console.log('baca Absen ID : '+id);
               },
               success: function(data) {
                    // alert(data);
                    console.log(data);
                    status = data.status;
                    if (status == 'success') {
                      alert(status);
                    }else{
                      alert(status+' : '+data.detail);
                    }
               },
               complete: function() {
                 getListAbsen();
                 getListNotifAbsen();
               },
               error: function() {
                   alert("Memproses data gagal !");
               }
           });
  }


  function getListCamat(){
    $('#tbody').html("");
    $.ajax({
                url: "{{url('/api/getlistcamat')}}",
                type: "GET",
                data: {
                },
                beforeSend: function() {
                  // console.log(tablex);

                },
                success: function(dt) {
                  // dt = JSON.parse(data);

                  console.log(dt);
                  content = '';
                   content+='<option value="">Pilih Camat</option>';
                  for (var i = 0; i < dt.length; i++) {
                    content+='<option value="'+dt[i].id+'">'+dt[i].username +' ('+dt[i].nama_lengkap+' : '+dt[i].nama_jabatan+')</option>';
                  }
                  $('#id_user_camat').html(content);
                  $('#det_id_user_camat').html(content);
                },
                complete: function() {

                },
                error: function() {
                    alert("Memproses data gagal !");
                }
            });
  }

</script>
@endsection
