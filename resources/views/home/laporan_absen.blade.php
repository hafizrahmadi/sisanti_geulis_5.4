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
            <div class="modal-body">
               <div class="form-group">
                  <label>Nomor Surat</label>
                  <input type="text" name="nomor_surat" class="form-control" id="det_nomor_surat" disabled="disabled" placeholder="Nomor Surat">
               </div>
               <div class="form-group">
                  <label>Tanggal Surat</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="tanggal_surat" class="form-control pull-right" id="det_tanggal_surat" disabled="disabled" placeholder="Tanggal Surat">
                  </div>
               </div>
               <div class="form-group">
                  <label>Perihal</label>
                  <input type="text" name="perihal" class="form-control" id="det_perihal" disabled="disabled" placeholder="Perihal">
               </div>

               <div class="form-group">
                  <label>Asal Surat</label>
                  <input type="text" name="asal_surat" class="form-control" id="det_asal_surat" disabled="disabled" placeholder="Asal Surat">
               </div>

               <div class="form-group">
                  <label>Lampiran</label>
                  <input type="text" name="lampiran" class="form-control" id="det_lampiran" disabled="disabled" placeholder="Lampiran">
               </div>

               <div class="form-group">
                  <label for="exampleInputFile">File Dokumen</label>
                  <!-- <input type="file" id="file_dokumen"> -->
                  <div id="det_file"></div>
                </div>

                <div class="form-group">
                  <label>Absen</label>
                  <select class="form-control" name="id_user_camat" id="det_id_user_camat" disabled="disabled">

                  </select>
               </div>
               <div class="form-group">
                  <label>Ringkasan Surat</label>
                  <textarea class="form-control" rows="2" placeholder="Ringkasan surat ..." id="det_ringkasan_surat" disabled="disabled"></textarea>
               </div>
               <div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" rows="2" placeholder="Catatan ..." id="det_catatan" disabled="disabled"></textarea>
               </div>
               <!-- <input type="hidden" id="note_breach_date" name="note_breach_date" /> -->
               <input type="hidden" id="id_surat_masuk" name="det_id_surat_masuk" />
               <input type="hidden" id="id_user" name="det_id_user" value="{{session('id_user')}}" />
            </div>
            <div class="modal-footer">
               <!-- <button type="button" class="btn btn-sm btn-default" title="Reset" id="appendix1_reset"><i class="fa fa-undo"></i></button> -->
               <!-- <button type="button" class="btn btn-sm btn-teal" title="Save" id="btn_save"><i class="fa fa-save"></i></button> -->
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
                                       '<a href="javascript:modalDetail(\'Detail Absensi\',\''+dt[i].id+'\')">'+
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

  function modalDetail(title,id){
        $('#det_nomor_surat').val("");
        $('#det_tanggal_surat').val("");
        $('#det_perihal').val("");
        $('#det_asal_surat').val("");
        $('#det_lampiran').val("");
        $('#det_file_dokumen').val("");
        $('#det_catatan').val("");
        $('#det_ringkasan_surat').val("");
        $('#det_id_surat_masuk').val("");
        $('#det_id_user_camat').val("");
        $('#modal_detail_title').html(title);
        $('#det_file').html('<i style="color:#ff0000;">Belum ada file</i>');

        if (id!='') {
           $.ajax({
                url: "{{url('/api/getsuratmasuk')}}"+"/"+id,
                type: "GET",
                data: {
                  // 'id':id
                },
                beforeSend: function() {

                },
                success: function(dt) {
                  // dt = JSON.parse(data);

                  console.log(dt);
                  dtx = dt[0];
                  $('#det_nomor_surat').val(dtx.nomor_surat);
                  $('#det_tanggal_surat').val(dtx.tanggal_surat);
                  $('#det_perihal').val(dtx.perihal);
                  $('#det_asal_surat').val(dtx.asal_surat);
                  $('#det_lampiran').val(dtx.lampiran);
                  if (dtx.file_dokumen!=""&&dtx.file_dokumen!=null) {
                    lk = "{{url('/')}}"+"/"+dtx.file_dokumen;
                    $('#det_file').html('<a href="'+lk+'" target="_blank"><i class="fa fa-file-pdf-o"></i> '+dtx.file_dokumen+'</a>');
                  }
                  
                  $('#det_catatan').val(dtx.catatan);
                  $('#det_ringkasan_surat').val(dtx.ringkasan_surat);

                  $('#det_id_surat_masuk').val(dtx.id);
                  $('#det_id_user_camat').val(dtx.id_user_camat);
                  $('#modal-detail').modal('show');
                },
                complete: function() {

                },
                error: function() {
                    alert("Memproses data gagal !");
                }
            });

            
        }
        
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
