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
    <h1>Catat Surat Keluar</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Catat Surat Keluar</li>
      </ol>
@endsection
@section('content')
    <!-- Default box -->
    <div class="box" >
        <div class="box-header with-border">
            <h3 class="box-title">Data Surat Keluar</h3>
            <div class="box-tools pull-right">
                <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button> -->
                <a href="javascript:modalForm('Tambah Surat Keluar','','');"><button class="btn btn-sm btn-teal"><i class="fa fa-pencil-square-o" style=""></i> Tambah Surat Keluar</button></a>
            </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id="tablex" class="table table-bordered table-striped " style="width: 100%;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <!-- <th>ID User</th> -->
                        <th>Nomor Surat</th>
                        <th>Tanggal Surat</th>
                        <th>Perihal</th>
                        <th>Asal Surat</th>
                        <th>Lampiran</th>
                        <th>Catatan</th>
                        <th class="text-center">File</th>
                        <th class="text-center">Status Surat</th>
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
    <!-- Modal -->
<div class="modal fade" id="modal" role="dialog" style="z-index: 1050;">
   <div class="modal-dialog">
      <div class="box box-success">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title" id="modal_title" style="font-weight:bold;"></h4>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>Nomor Surat <span style="color:#ff0000;">*</span></label>
                  <input type="text" name="nomor_surat" class="form-control" id="nomor_surat" placeholder="Nomor Surat">
               </div>
               <div class="form-group">
                  <label>Tanggal Surat <span style="color:#ff0000;">*</span></label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="tanggal_surat" class="form-control pull-right" id="tanggal_surat" placeholder="Tanggal Surat">
                  </div>
               </div>
               <div class="form-group">
                  <label>Perihal <span style="color:#ff0000;">*</span></label>
                  <input type="text" name="perihal" class="form-control" id="perihal" placeholder="Perihal">
               </div>

               <div class="form-group">
                  <label>Asal Surat <span style="color:#ff0000;">*</span></label>
                  <input type="text" name="asal_surat" class="form-control" id="asal_surat" placeholder="Asal Surat">
               </div>

               <div class="form-group">
                  <label>Lampiran</label>
                  <input type="text" name="lampiran" class="form-control" id="lampiran" placeholder="Lampiran">
               </div>

               <div class="form-group">
                  <label for="exampleInputFile">File Dokumen</label>
                  <input type="file" id="file_dokumen">
                  <p class="help-block text-sm" style="color:#ff0000" id="p_file_dokumen">Format file .pdf</p>
                </div>

               <div class="form-group">
                  <label>Ringkasan Surat</label>
                  <textarea class="form-control" rows="2" placeholder="Ringkasan surat ..." id="ringkasan_surat"></textarea>
               </div>
               <div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" rows="2" placeholder="Catatan ..." id="catatan"></textarea>
               </div>
               <!-- <input type="hidden" id="note_breach_date" name="note_breach_date" /> -->
               <input type="hidden" id="id_surat_keluar" name="id_surat_keluar" />
               <input type="hidden" id="id_user" name="id_user" value="{{session('id_user')}}" />
            </div>
            <div class="modal-footer">
               <!-- <button type="button" class="btn btn-sm btn-default" title="Reset" id="appendix1_reset"><i class="fa fa-undo"></i></button> -->
               <button type="button" class="btn btn-sm btn-teal" title="Save" id="btn_save"><i class="fa fa-save"></i></button>
            </div>
         </div>
      </div>
      <!-- /.box -->
   </div>
</div>


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
                  <label>Ringkasan Surat</label>
                  <textarea class="form-control" rows="2" placeholder="Ringkasan surat ..." id="det_ringkasan_surat" disabled="disabled"></textarea>
               </div>
               <div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" rows="2" placeholder="Catatan ..." id="det_catatan" disabled="disabled"></textarea>
               </div>
               <!-- <input type="hidden" id="note_breach_date" name="note_breach_date" /> -->
               <input type="hidden" id="det_id_surat_keluar" name="id_surat_keluar" />
               <input type="hidden" id="det_id_user" name="id_user" value="{{session('id_user')}}" />
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

<div class="modal fade" id="modal-disposisi" role="dialog" style="z-index: 1050;">
   <div class="modal-dialog">
      <div class="box box-success">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title" id="modal_disposisi_title" style="font-weight:bold;"></h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                  <label>Disposisi</label>
                  <select class="form-control" name="id_user_kk" id="dis_id_user_kk" >
                  </select>

                  <input type="hidden" id="dis_id_surat_keluar" name="id_surat_keluar" />
                <input type="hidden" id="dis_id_user" name="id_user" value="{{session('id_user')}}" />
               </div>
            </div>
            <div class="modal-footer">
               <!-- <button type="button" class="btn btn-sm btn-default" title="Reset" id="appendix1_reset"><i class="fa fa-undo"></i></button> -->
               <button type="button" class="btn btn-sm btn-teal" title="Submit" id="btn_save_disposisi"><i class="fa fa-save"></i></button>
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
      getListSuratKeluar();
      $('#tanggal_surat').datepicker({
            format: 'yyyy-mm-dd',
            // todayHighlight: true,
            autoclose: true,
            // startDate: '2017-12-18',
            endDate:'d',
        });
    });

    // $('#dis_id_user_kk').change(function(){
      // alert($('#dis_id_user_kk').find(':selected').data('firebase'));
    // });
    

    function modalForm(title,index,id){
        $('#nomor_surat').val("");
        $('#tanggal_surat').val("");
        $('#perihal').val("");
        $('#asal_surat').val("");
        $('#lampiran').val("");
        $('#file_dokumen').val("");
        $('#catatan').val("");
        $('#ringkasan_surat').val("");
        $('#id_surat_keluar').val("");
        $('#modal_title').html(title);

        if (id!='') {
            $('#nomor_surat').val($('#nomor_surat_'+index).attr('data-val'));
            $('#tanggal_surat').val($('#tanggal_surat_'+index).attr('data-val'));
            $('#perihal').val($('#perihal_'+index).attr('data-val'));
            $('#asal_surat').val($('#asal_surat_'+index).attr('data-val'));
            $('#lampiran').val($('#lampiran_'+index).attr('data-val'));
            $('#p_file_dokumen').html("Format file .pdf | Current File : "+$('#file_dokumen_'+index).attr('data-val'));
            $('#catatan').val($('#catatan_'+index).attr('data-val'));
            $('#ringkasan_surat').val($('#catatan_'+index).attr('data-ringkasan_surat'));

            $('#id_surat_keluar').val(id);
        }
        $('#btn_save').attr('onclick', 'modalSave()');
        $('#modal').modal('show');
  }

  function getListSuratKeluar(){
    $('#tbody').html("");
    $.ajax({
                url: "{{url('/api/getlistsuratkeluar')}}",
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
                    link_file = "{{url('/')}}"+"/";
                    ctn_file = '-';
                    if (dt[i].file_dokumen!=""&&dt[i].file_dokumen!=null) {
                      ctn_file = '<a class="btn btn-xs btn-teal" title="Lihat file dokumen surat keluar" href="'+link_file+dt[i].file_dokumen+'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
                    }

                    ctn_notif = '';
                    if (dt[i].status==0) {
                      ctn_notif = '<span class=""><i class="fa fa-times-circle-o"></i> Notif belum dikirim</span>';
                      ctn_notif += '<br><a href="javascript:modalDisposisi(\'Disposisi Surat Keluar ke Kasi/Kasubag\',\''+(i+1)+'\',\''+dt[i].id+'\',\''+dt[i].status+'\')">'+
                                       '<button class="btn btn-xs btn-teal" title="Kirim Notifikasi"><i class="fa fa-bell" style=""></i> Kirim Notif</button>'+
                                       '</a>';
                    }else if (dt[i].status==0.5) {
                      ctn_notif = '<span class="text-success"><i class="fa fa-check-square"></i> Notif Terkirim ke Kasi/Kasubag</span>';
                    }else if (dt[i].status==1) {
                      ctn_notif = '<span class="text-warnning"><i class="fa fa-times-circle-o"></i> Revisi dari Kasi/Kasubag</span>';
                    }else if (dt[i].status==2) {
                      ctn_notif = '<span class="text-success"><i class="fa fa-eye"></i> Disetujui Kasi/Kasubag</span>';
                      ctn_notif += '<br><a href="javascript:modalDisposisi(\'Disposisi Surat Keluar ke Sekcam \',\''+(i+1)+'\',\''+dt[i].id+'\',\''+dt[i].status+'\')">'+
                                       '<button class="btn btn-xs btn-teal" title="Kirim Notifikasi"><i class="fa fa-bell" style=""></i> Kirim Notif</button>'+
                                       '</a>';
                    }else if (dt[i].status==2.5) {
                      ctn_notif = '<span class="text-success"><i class="fa fa-check-square"></i> Notif Terkirim ke Sekcam</span>';
                    }else if (dt[i].status==3) {
                      ctn_notif = '<span class="text-warnning"><i class="fa fa-times-circle-o"></i> Revisi dari Sekcam</span>';
                    }else if (dt[i].status==4) {
                      ctn_notif = '<span class="text-success"><i class="fa fa-eye"></i> Disetujui Sekcam</span>';
                      ctn_notif += '<br><a href="javascript:modalDisposisi(\'Disposisi Surat Keluar ke Camat \',\''+(i+1)+'\',\''+dt[i].id+'\',\''+dt[i].status+'\')">'+
                                       '<button class="btn btn-xs btn-teal" title="Kirim Notifikasi"><i class="fa fa-bell" style=""></i> Kirim Notif</button>'+
                                       '</a>';
                    }else if (dt[i].status==4.5) {
                      ctn_notif = '<span class="text-success"><i class="fa fa-check-square"></i> Notif Terkirim ke Sekcam</span>';
                    }else if (dt[i].status==5) {
                      ctn_notif = '<span class="text-warnning"><i class="fa fa-times-circle-o"></i> Revisi dari Camat</span>';
                    }else if (dt[i].status==6) {
                      ctn_notif = '<span class="text-success"><i class="fa fa-eye"></i> Disetujui Camat</span>';
                    }
                    
                    content+='<tr>'+
                                '<td>'+(i+1)+'</td>'+
                                // '<td id="id_user_'+(i+1)+'" data-val="'+dt[i].id+'">'+dt[i].id+'</td>'+
                                '<td id="nomor_surat_'+(i+1)+'" data-val="'+dt[i].nomor_surat+'">'+dt[i].nomor_surat+'</td>'+
                                '<td id="tanggal_surat_'+(i+1)+'" data-val="'+dt[i].tanggal_surat+'">'+dt[i].tanggal_surat+'</td>'+
                                '<td id="perihal_'+(i+1)+'" data-val="'+dt[i].perihal+'">'+dt[i].perihal+'</td>'+
                                '<td id="asal_surat_'+(i+1)+'" data-val="'+dt[i].asal_surat+'">'+dt[i].asal_surat+'</td>'+
                                '<td id="lampiran_'+(i+1)+'" data-val="'+dt[i].lampiran+'">'+dt[i].lampiran+'</td>'+
                                '<td id="catatan_'+(i+1)+'" data-val="'+dt[i].catatan+'" data-ringkasan_surat="'+dt[i].ringkasan_surat+'">'+dt[i].catatan+'</td>'+
                                '<td class="text-center" id="file_dokumen_'+(i+1)+'" data-val="'+dt[i].file_dokumen+'">'+ctn_file+'</td>'+
                                '<td class="text-center">'+ctn_notif+'</td>'+
                                '<td class="text-center">'+
                                      '<div class="btn-group" >'+
                                      '<a href="javascript:modalForm(\'Edit Surat Keluar\',\''+(i+1)+'\',\''+dt[i].id+'\')">'+
                                       '<button class="btn btn-xs btn-teal" title="Edit"><i class="fa fa-pencil" style=""></i></button>'+
                                       '</a>&nbsp;'+
                                       '<a href="javascript:modalDetail(\'Detail Surat Keluar\',\''+(i+1)+'\',\''+dt[i].id+'\')">'+
                                       '<button class="btn btn-xs btn-teal" title="Lihat detail surat"><i class="fa fa-search" style=""></i></button>'+
                                       '</a>&nbsp;'+
                                       '<a href="javascript:deleteSuratKeluar('+dt[i].id+')"  onclick="return conf();">'+
                                       '<button class="btn btn-xs btn-teal" title="Delete"><i class="fa fa-trash-o" style=""></i></button>'+
                                       '</a>'+
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
                      { "targets": 7, "orderable": false},{ "targets": 8, "orderable": false},{ "targets": 9, "orderable": false},

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

  function modalSave(){

    var nomor_surat = $('#nomor_surat').val();
    var tanggal_surat = $('#tanggal_surat').val();
    var perihal = $('#perihal').val();
    var asal_surat = $('#asal_surat').val();
    var lampiran = $('#lampiran').val();
    var file_dokumen = $('#file_dokumen').prop('files')[0];
    var catatan = $('#catatan').val();
    var ringkasan_surat = $('#ringkasan_surat').val();
    var id_surat_keluar = $('#id_surat_keluar').val();
    var id_user = $('#id_user').val();

    if (nomor_surat!=''&&tanggal_surat!=''&&perihal!=''&&asal_surat!='') {
      var form_data = new FormData();
      form_data.append('_token', '{{csrf_token()}}');
       form_data.append('id', id_surat_keluar);
       form_data.append('nomor_surat', nomor_surat);
       form_data.append('tanggal_surat', tanggal_surat);
       form_data.append('perihal', perihal);
       form_data.append('asal_surat', asal_surat);
       form_data.append('lampiran', lampiran);
       form_data.append('file_dokumen', file_dokumen);
       form_data.append('catatan', catatan);
       form_data.append('ringkasan_surat', ringkasan_surat);
       form_data.append('id_user', id_user);
       console.log(
                  ...form_data
                 );

        $.ajax({
               url: "{{url('/api/addsuratkeluar')}}",
               type: "POST",
               processData: false,
              contentType: false,
               data:
                  form_data
               ,
               beforeSend: function() {
                 console.log(
                  form_data
                 );
                 if (id_surat_keluar=='') {
                   console.log('Tambah data suratkeluar : '+perihal + ' | no surat : '+nomor_surat);
                 }else{
                   console.log('Update data user ID : '+id_surat_keluar+' | perihal : '+perihal+ ' | no surat : '+nomor_surat);
                 }

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
                    // if (data) {
                    //     if (id_surat_keluar!='') {
                    //         alert('Surat Keluar berhasil diperbarui!');
                    //     }else{
                    //         alert('Surat Keluar berhasil ditambahkan!');
                    //     }

                    //     $('#nomor_surat').val("");
                    //     $('#tanggal_surat').val("");
                    //     $('#perihal').val("");
                    //     $('#asal_surat').val("");
                    //     $('#lampiran').val("");
                    //     $('#file_dokumen').val("");
                    //     $('#catatan').val("");
                    //     $('#id_surat_keluar').val("");
                        $('#modal').modal('hide');
                    // }else{
                    //     alert('Surat Keluar gagal ditambahkan!');
                    // }
               },
               complete: function() {
                 getListSuratKeluar();
               },
               error: function() {
                   alert("Memproses data gagal !");
               }
           });
    }else{
        alert('Lengkapi form!');
    }

  }

  function deleteSuratKeluar(id){
    $.ajax({
               url: "{{url('/api/deletesuratkeluar')}}",
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

                console.log('Delete surat keluar : '+id);


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
                 getListSuratKeluar();
               },
               error: function() {
                   alert("Memproses data gagal !");
               }
           });
  }


  function getListKasiKasubag(){
    $.ajax({
                url: "{{url('/api/getlistkasikasubag')}}",
                type: "GET",
                data: {
                },
                beforeSend: function() {
                  // console.log(tablex);
                  $('#dis_id_user_kk').html("");
                },
                success: function(dt) {
                  // dt = JSON.parse(data);

                  console.log(dt);
                  content = '';
                   content+='<option value="">Pilih Kasi/Kasubag</option>';
                  for (var i = 0; i < dt.length; i++) {
                    content+='<option value="'+dt[i].id+'" data-firebase="'+dt[i].firebase+'">'+dt[i].username +' ('+dt[i].nama_lengkap+' : '+dt[i].nama_jabatan+')</option>';
                  }
                  $('#dis_id_user_kk').html(content);

                },
                complete: function() {

                },
                error: function() {
                    alert("Memproses data gagal !");
                }
            });
  }

  function getListSekcam(){
        $.ajax({
                url: "{{url('/api/getlistsekcam')}}",
                type: "GET",
                data: {
                },
                beforeSend: function() {
                  // console.log(tablex);
                  $('#dis_id_user_kk').html("");
                },
                success: function(dt) {
                  // dt = JSON.parse(data);

                  console.log(dt);
                  content = '';
                   content+='<option value="">Pilih Kasi/Kasubag</option>';
                  for (var i = 0; i < dt.length; i++) {
                    content+='<option value="'+dt[i].id+'" data-firebase="'+dt[i].firebase+'">'+dt[i].username +' ('+dt[i].nama_lengkap+' : '+dt[i].nama_jabatan+')</option>';
                  }
                  $('#dis_id_user_kk').html(content);

                },
                complete: function() {

                },
                error: function() {
                    alert("Memproses data gagal !");
                }
            });
  }

  function getListCamat(){
        $.ajax({
                url: "{{url('/api/getlistcamat')}}",
                type: "GET",
                data: {
                },
                beforeSend: function() {
                  // console.log(tablex);
                  $('#dis_id_user_kk').html("");
                },
                success: function(dt) {
                  // dt = JSON.parse(data);

                  console.log(dt);
                  content = '';
                   content+='<option value="">Pilih Kasi/Kasubag</option>';
                  for (var i = 0; i < dt.length; i++) {
                    content+='<option value="'+dt[i].id+'" data-firebase="'+dt[i].firebase+'">'+dt[i].username +' ('+dt[i].nama_lengkap+' : '+dt[i].nama_jabatan+')</option>';
                  }
                  $('#dis_id_user_kk').html(content);

                },
                complete: function() {

                },
                error: function() {
                    alert("Memproses data gagal !");
                }
            });
  }

  function sendNotif(index,id_surat_keluar,dari_id_user,untuk_id_user,firebase){
    perihal = $('#perihal_'+index).attr('data-val');
    $.ajax({
               url: "{{url('/api/send_notif')}}",
               type: "POST",
               data: {
                  _token: '{{csrf_token()}}',
                  'user_id':untuk_id_user,
                  'dari_id_user':dari_id_user,
                  'firebase':firebase,
                  'title': "SISANTI GEULIS",
                  'body': "Pemberitahuan! Surat keluar baru untuk anda. Perihal : "+perihal,
                  'jenis':2,
                  'id_surat_keluar':id_surat_keluar,
               },
               beforeSend: function() {
                 console.log({
                   _token: '{{csrf_token()}}',
                  'user_id':untuk_id_user,
                  'dari_id_user':dari_id_user,
                  'firebase':firebase,
                  'title': "SISANTI GEULIS",
                  'body': "Pemberitahuan! Surat keluar baru untuk anda. Perihal : "+perihal,
                  'jenis':2,
                  'id_surat_keluar':id_surat_keluar,
                 });

               },
               success: function(data) {
                    // alert(data);
                    // console.log(data);
                    // status = data.status;
                    // if (status == 'success') {
                    //   alert(status);
                    // }else{
                    //   alert(status+' : '+data.detail);
                    // }
                    alert('Notifikasi telah dikirimkan');
               },
               complete: function() {
                getListSuratKeluar();
               },
               error: function() {
                   alert("Memproses data gagal !");
               }
           });
  }

  function modalDetail(title,index,id){
        $('#det_nomor_surat').val("");
        $('#det_tanggal_surat').val("");
        $('#det_perihal').val("");
        $('#det_asal_surat').val("");
        $('#det_lampiran').val("");
        $('#det_file_dokumen').val("");
        $('#det_catatan').val("");
        $('#det_ringkasan_surat').val("");
        $('#det_id_surat_keluar').val("");
        $('#modal_detail_title').html(title);
         $('#det_file').html('<i style="color:#ff0000;">Belum ada file</i>');

        if (id!='') {
            $('#det_nomor_surat').val($('#nomor_surat_'+index).attr('data-val'));
            $('#det_tanggal_surat').val($('#tanggal_surat_'+index).attr('data-val'));
            $('#det_perihal').val($('#perihal_'+index).attr('data-val'));
            $('#det_asal_surat').val($('#asal_surat_'+index).attr('data-val'));
            $('#det_lampiran').val($('#lampiran_'+index).attr('data-val'));
            if ($('#file_dokumen_'+index).attr('data-val')!=""&&$('#file_dokumen_'+index).attr('data-val')!=null) {
              lk = "{{url('/')}}"+"/"+$('#file_dokumen_'+index).attr('data-val');
              $('#det_file').html('<a href="'+lk+'" target="_blank"><i class="fa fa-file-pdf-o"></i> '+$('#file_dokumen_'+index).attr('data-val')+'</a>');
            }
            
            $('#det_catatan').val($('#catatan_'+index).attr('data-val'));
            $('#det_ringkasan_surat').val($('#catatan_'+index).attr('data-ringkasan_surat'));

            $('#det_id_surat_keluar').val(id);
        }
        $('#modal-detail').modal('show');
  }

    function modalDisposisi(title,index,id,status){
        // $('#dis_id_user_kk').val();
        
        $('#modal_disposisi_title').html(title);
        $('#dis_id_surat_keluar').val(id);
        if (status==0) {
          getListKasiKasubag();
        }else if (status==2) {
          getListSekcam();
        }else if (status==4) {
          getListCamat();
        }
        
        $('#btn_save_disposisi').attr('onclick', 'modalSaveDisposisi(\''+index+'\')');
        $('#modal-disposisi').modal('show');
  }

  function modalSaveDisposisi(index){
    id_surat_keluar = $('#dis_id_surat_keluar').val();
    id_user_kk = $('#dis_id_user_kk').val();
    id_user = $('#dis_id_user').val();
    firebase = $('#dis_id_user_kk').find(':selected').data("firebase");
    // alert();

    perihal = $('#perihal_'+index).attr('data-val');
    $.ajax({
               url: "{{url('/api/send_notif')}}",
               type: "POST",
               data: {
                  _token: '{{csrf_token()}}',
                  'untuk_user_id':id_user_kk,
                  'dari_user_id':id_user,
                  'firebase':firebase,
                  'title': "SISANTI GEULIS",
                  'body': "Pemberitahuan! Surat keluar baru untuk anda. Mohon untuk melakukan pemeriksaan. Perihal : "+perihal,
                  'jenis':2,
                  'id_surat':id_surat_keluar,
               },
               beforeSend: function() {
                 console.log({
                   _token: '{{csrf_token()}}',
                  'untuk_user_id':id_user_kk,
                  'dari_user_id':id_user,
                  'firebase':firebase,
                  'title': "SISANTI GEULIS",
                  'body': "Pemberitahuan! Surat keluar baru untuk anda. Mohon untuk melakukan pemeriksaan. Perihal : "+perihal,
                  'jenis':2,
                  'id_surat':id_surat_keluar,
                 });

               },
               success: function(data) {
                    // alert(data);
                    // console.log(data);
                    // status = data.status;
                    // if (status == 'success') {
                    //   alert(status);
                    // }else{
                    //   alert(status+' : '+data.detail);
                    // }
                    alert('Notifikasi telah dikirimkan');
               },
               complete: function() {
                getListSuratKeluar();
               },
               error: function() {
                   alert("Memproses data gagal !");
               }
           });
  }

</script>
@endsection
