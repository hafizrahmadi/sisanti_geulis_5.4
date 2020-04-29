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
    <h1>Catat Surat Masuk</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Catat Surat Masuk</li>
      </ol>
@endsection
@section('content')
    <!-- Default box -->
    <div class="box" >
        <div class="box-header with-border">
            <h3 class="box-title">Catat Surat Masuk</h3>
            <div class="box-tools pull-right">
                <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button> -->
                <a href="javascript:modalForm('Tambah Surat Masuk','','');"><button class="btn btn-sm btn-teal"><i class="fa fa-pencil-square-o" style=""></i> Tambah Surat Masuk</button></a>
            </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id="tablex" class="table table-bordered table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <!-- <th>ID User</th> -->
                        <th>Nomor Surat</th>
                        <th>Tanggal Surat</th>
                        <th>Perihal</th>
                        <th>Asal Surat</th>
                        <th>Lampiran</th>
                        <th>File Dokumen</th>
                        <th>Disposisi</th>
                        <th>Catatan</th>
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
                  <label>Disposisi</label>
                  <select class="form-control" name="id_user_camat" id="id_user_camat">

                  </select>
               </div>

               <div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" rows="2" placeholder="Catatan ..." id="catatan"></textarea>
               </div>
               <!-- <input type="hidden" id="note_breach_date" name="note_breach_date" /> -->
               <input type="hidden" id="id_surat_masuk" name="id_surat_masuk" />
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
@endsection

@section('script')
<link rel="stylesheet" href="{{asset('file_assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.css') }}">
<!-- DataTables -->
<script src="{{asset('file_assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{asset('file_assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<script type="text/javascript">
    var tablex = null;
    $(document).ready(function() {
      getListSuratMasuk();
      getListCamat();
      $('#tanggal_surat').datepicker({
            format: 'yyyy-mm-dd',
            // todayHighlight: true,
            autoclose: true,
            // startDate: '2017-12-18',
            endDate:'d',
        });
    });

    function modalForm(title,index,id){
        $('#nomor_surat').val("");
        $('#tanggal_surat').val("");
        $('#perihal').val("");
        $('#asal_surat').val("");
        $('#lampiran').val("");
        $('#file_dokumen').val("");
        $('#catatan').val("");
        $('#id_surat_masuk').val("");
        $('#id_user_camat').val("");
        $('#modal_title').html(title);

        if (id!='') {
            $('#nomor_surat').val($('#nomor_surat_'+index).attr('data-val'));
            $('#tanggal_surat').val($('#tanggal_surat_'+index).attr('data-val'));
            $('#perihal').val($('#perihal_'+index).attr('data-val'));
            $('#asal_surat').val($('#asal_surat_'+index).attr('data-val'));
            $('#lampiran').val($('#lampiran_'+index).attr('data-val'));
            $('#p_file_dokumen').html("Format file .pdf | Current File : "+$('#file_dokumen_'+index).attr('data-val'));
            $('#catatan').val($('#catatan_'+index).attr('data-val'));

            $('#id_surat_masuk').val(id);
            $('#id_user_camat').val($('#id_user_camat_'+index).attr('data-val'));
        }
        $('#btn_save').attr('onclick', 'modalSave()');
        $('#modal').modal('show');
  }

  function getListSuratMasuk(){
    $('#tbody').html("");
    $.ajax({
                url: "{{url('/api/getlistsuratmasuk')}}",
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
                    content+='<tr>'+
                                '<td>'+(i+1)+'</td>'+
                                // '<td id="id_user_'+(i+1)+'" data-val="'+dt[i].id+'">'+dt[i].id+'</td>'+
                                '<td id="nomor_surat_'+(i+1)+'" data-val="'+dt[i].nomor_surat+'">'+dt[i].nomor_surat+'</td>'+
                                '<td id="tanggal_surat_'+(i+1)+'" data-val="'+dt[i].tanggal_surat+'">'+dt[i].tanggal_surat+'</td>'+
                                '<td id="perihal_'+(i+1)+'" data-val="'+dt[i].perihal+'">'+dt[i].perihal+'</td>'+
                                '<td id="asal_surat_'+(i+1)+'" data-val="'+dt[i].asal_surat+'">'+dt[i].asal_surat+'</td>'+
                                '<td id="lampiran_'+(i+1)+'" data-val="'+dt[i].lampiran+'">'+dt[i].lampiran+'</td>'+
                                '<td id="file_dokumen_'+(i+1)+'" data-val="'+dt[i].file_dokumen+'">'+dt[i].file_dokumen+'</td>'+
                                '<td id="id_user_camat_'+(i+1)+'" data-val="'+dt[i].id_user_camat+'">'+dt[i].username_camat +' ('+dt[i].nama_lengkap_camat+')</td>'+
                                '<td id="catatan_'+(i+1)+'" data-val="'+dt[i].catatan+'">'+dt[i].catatan+'</td>'+
                                '<td class="text-center">'+
                                      '<div class="btn-group" >'+
                                      '<a href="javascript:sendNotif(\''+(i+1)+'\',\''+dt[i].id+'\',\''+dt[i].id_user_camat+'\',\''+dt[i].firebase+'\')">'+
                                       '<button class="btn btn-xs btn-teal" title="Kirim Notifikasi"><i class="fa fa-bell" style=""></i></button>'+
                                       '</a>&nbsp;'+
                                       '<a href="javascript:modalForm(\'Edit Surat Masuk\',\''+(i+1)+'\',\''+dt[i].id+'\')">'+
                                       '<button class="btn btn-xs btn-teal" title="Edit"><i class="fa fa-pencil" style=""></i></button>'+
                                       '</a>&nbsp;'+
                                       '<a href="javascript:deleteSuratMasuk('+dt[i].id+')"  onclick="return conf();">'+
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
                      "columnDefs": [
                      { "targets": 6, "orderable": false},{ "targets": 9, "orderable": false}
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
    var id_surat_masuk = $('#id_surat_masuk').val();
    var id_user_camat = $('#id_user_camat').val();
    var id_user = $('#id_user').val();

    if (nomor_surat!=''&&tanggal_surat!=''&&perihal!=''&&asal_surat!=''&&id_user_camat!='') {
      var form_data = new FormData();
      form_data.append('_token', '{{csrf_token()}}');
       form_data.append('id', id_surat_masuk);
       form_data.append('nomor_surat', nomor_surat);
       form_data.append('tanggal_surat', tanggal_surat);
       form_data.append('perihal', perihal);
       form_data.append('asal_surat', asal_surat);
       form_data.append('lampiran', lampiran);
       form_data.append('file_dokumen', file_dokumen);
       form_data.append('catatan', catatan);
       form_data.append('id_user', id_user);
       form_data.append('id_user_camat', id_user_camat);
       console.log(
                  ...form_data
                 );

        $.ajax({
               url: "{{url('/api/addsuratmasuk')}}",
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
                 if (id_surat_masuk=='') {
                   console.log('Tambah data suratmasuk : '+perihal + ' | no surat : '+nomor_surat);
                 }else{
                   console.log('Update data user ID : '+id_surat_masuk+' | perihal : '+perihal+ ' | no surat : '+nomor_surat);
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
                    //     if (id_surat_masuk!='') {
                    //         alert('Surat Masuk berhasil diperbarui!');
                    //     }else{
                    //         alert('Surat Masuk berhasil ditambahkan!');
                    //     }

                    //     $('#nomor_surat').val("");
                    //     $('#tanggal_surat').val("");
                    //     $('#perihal').val("");
                    //     $('#asal_surat').val("");
                    //     $('#lampiran').val("");
                    //     $('#file_dokumen').val("");
                    //     $('#catatan').val("");
                    //     $('#id_surat_masuk').val("");
                        $('#modal').modal('hide');
                    // }else{
                    //     alert('Surat Masuk gagal ditambahkan!');
                    // }
               },
               complete: function() {
                 getListSuratMasuk();
               },
               error: function() {
                   alert("Memproses data gagal !");
               }
           });
    }else{
        alert('Lengkapi form!');
    }

  }

  function deleteSuratMasuk(id){
    $.ajax({
               url: "{{url('/api/deletesuratmasuk')}}",
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

                console.log('Delete surat masuk : '+id);


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
                 getListSuratMasuk();
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
                },
                complete: function() {

                },
                error: function() {
                    alert("Memproses data gagal !");
                }
            });
  }

  function sendNotif(index,id_surat_masuk,id_user_camat,firebase){
    perihal = $('#perihal_'+index).attr('data-val');
    $.ajax({
               url: "{{url('/api/send_notif')}}",
               type: "POST",
               data: {
                  _token: '{{csrf_token()}}',
                  'user_id':id_user_camat,
                  'firebase':firebase,
                  'title': "SISANTI GEULIS",
                  'body': "Pemberitahuan! Surat masuk baru untuk anda. Perihal : "+perihal,
                  'jenis':1,
                  'id_surat_masuk':id_surat_masuk,
               },
               beforeSend: function() {
                 console.log({
                   _token: '{{csrf_token()}}',
                  'user_id':id_user_camat,
                  'firebase':firebase,
                  'title': "SISANTI GEULIS",
                  'body': "Pemberitahuan! Surat masuk baru untuk anda. Perihal : "+perihal,
                  'jenis':1,
                  'id_surat_masuk':id_surat_masuk,
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
                 // getListSuratMasuk();
               },
               error: function() {
                   alert("Memproses data gagal !");
               }
           });
  }

</script>


@endsection
