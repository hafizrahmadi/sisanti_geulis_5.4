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
    <h1>Catat Nota Dinas</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Catat Nota Dinas</li>
      </ol>
@endsection
@section('content')
    <!-- Default box -->
    <div class="box" >
        <div class="box-header with-border">
            <h3 class="box-title">Data Nota Dinas</h3>
            <div class="box-tools pull-right">
                <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button> -->
                <a href="javascript:modalForm('Tambah Nota Dinas','','');"><button class="btn btn-sm btn-teal"><i class="fa fa-pencil-square-o" style=""></i> Tambah Nota Dinas</button></a>
            </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id="tablex" class="table table-bordered table-striped " style="width: 100%;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal Nodin</th>
                        <th>Nomor Nodin</th>
                        <th>Perihal</th>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Lampiran</th>
                        <th>Sifat</th>
                        <th>Jenis</th>
                        <th class="text-center">File</th>
                        <th class="no-sort text-center" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                </tbody>
            </table>
            </div><!-- /.box-body -->

        </div>
        <!-- <div class="overlay div_loading" id="loading"><i class="fa fa-refresh fa-spin"></i></div> -->
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
                  <label>Nomor Nodin</label>
                  <input type="text" name="nomor" class="form-control" id="nomor" placeholder="Nomor Nodin">
               </div>
               <div class="form-group">
                  <label>Tanggal Nodin <span style="color:#ff0000;">*</span></label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="tanggal" class="form-control pull-right" id="tanggal" placeholder="Tanggal Nodin">
                  </div>
               </div>
               <div class="form-group">
                  <label>Perihal <span style="color:#ff0000;">*</span></label>
                  <input type="text" name="perihal" class="form-control" id="perihal" placeholder="Perihal">
               </div>

               <div class="form-group">
                  <label>Asal Nodin <span style="color:#ff0000;">*</span></label>
                  <input type="text" name="asal" class="form-control" id="asal" placeholder="Asal Nodin">
               </div>

               <div class="form-group">
                  <label>Tujuan Nodin <span style="color:#ff0000;">*</span></label>
                  <input type="text" name="tujuan" class="form-control" id="tujuan" placeholder="Tujuan Nodin">
               </div>

               <div class="form-group">
                  <label>Lampiran</label>
                  <input type="text" name="lampiran" class="form-control" id="lampiran" placeholder="Lampiran">
               </div>

               <div class="form-group">
                  <label>Isi Ringkas</label>
                  <textarea class="form-control" rows="2" placeholder="Isi Ringkas ..." id="isi_ringkas"></textarea>
               </div>

               <div class="form-group">
                  <label>Tembusan</label>
                  <textarea class="form-control" rows="2" placeholder="Tembusan ..." id="tembusan"></textarea>
               </div>

               <div class="form-group">
                  <label for="exampleInputFile">File Dokumen</label>
                  <input type="file" id="file_dokumen">
                  <p class="help-block text-sm" style="color:#ff0000" id="p_file_dokumen">Format file .pdf</p>
                </div>

              <div class="form-group">
                  <label>Sifat Nodin <span style="color:#ff0000;">*</span></label>
                  <select class="form-control" name="sifat" id="sifat">
                    <option value="">Pilih Sifat Nodin</option>
                    <option value="biasa">Biasa</option>
                    <option value="penting">Penting</option>
                    <option value="segera">Segera</option>
                  </select>
              </div>

              <div class="form-group">
                  <label>Jenis Nodin <span style="color:#ff0000;">*</span></label>
                  <select class="form-control" name="jenis" id="jenis">
                    <option value="">Pilih Jenis Nodin</option>
                    <option value="inisiatif">Inisiatif</option>
                    <option value="disposisi">Disposisi</option>
                  </select>
               </div>

               <div class="form-group" id="div_surat_masuk" style="display: none;">
                  <label>Surat Masuk</label>
                  <select class="form-control" name="id_surat_masuk" id="id_surat_masuk">
                    <option value="">Pilih Surat Masuk</option>
                  </select>
               </div>

               <input type="hidden" id="id_nodin" name="id_nodin" />
            </div>
            <div class="modal-footer">
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
                  <label>Nomor Nodin</label>
                  <input type="text" name="nomor" class="form-control" id="det_nomor" placeholder="Nomor Nodin" disabled="disabled">
               </div>
               <div class="form-group">
                  <label>Tanggal Nodin <span style="color:#ff0000;">*</span></label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="tanggal" class="form-control pull-right" id="det_tanggal" placeholder="Tanggal Nodin" disabled="disabled">
                  </div>
               </div>
               <div class="form-group">
                  <label>Perihal <span style="color:#ff0000;">*</span></label>
                  <input type="text" name="perihal" class="form-control" id="det_perihal" placeholder="Perihal" disabled="disabled">
               </div>

               <div class="form-group">
                  <label>Asal Nodin <span style="color:#ff0000;">*</span></label>
                  <input type="text" name="asal" class="form-control" id="det_asal" placeholder="Asal Nodin" disabled="disabled">
               </div>

               <div class="form-group">
                  <label>Tujuan Nodin <span style="color:#ff0000;">*</span></label>
                  <input type="text" name="tujuan" class="form-control" id="det_tujuan" placeholder="Tujuan Nodin" disabled="disabled">
               </div>

               <div class="form-group">
                  <label>Lampiran</label>
                  <input type="text" name="lampiran" class="form-control" id="det_lampiran" placeholder="Lampiran" disabled="disabled">
               </div>

               <div class="form-group">
                  <label>Isi Ringkas</label>
                  <textarea class="form-control" rows="2" placeholder="Isi Ringkas ..." id="det_isi_ringkas" disabled="disabled"></textarea>
               </div>

               <div class="form-group">
                  <label>Tembusan</label>
                  <textarea class="form-control" rows="2" placeholder="Tembusan ..." id="det_tembusan" disabled="disabled"></textarea>
               </div>

               <div class="form-group">
                  <label for="exampleInputFile">File Dokumen</label>
                  <div id="det_file"></div>
                </div>

              <div class="form-group">
                  <label>Sifat Nodin <span style="color:#ff0000;">*</span></label>
                  <select class="form-control" name="sifat" id="det_sifat" disabled="disabled">
                    <option value="">Pilih Sifat Nodin</option>
                    <option value="biasa">Biasa</option>
                    <option value="penting">Penting</option>
                    <option value="segera">Segera</option>
                  </select>
              </div>

              <div class="form-group">
                  <label>Jenis Nodin <span style="color:#ff0000;">*</span></label>
                  <select class="form-control" name="jenis" id="det_jenis" disabled="disabled">
                    <option value="">Pilih Jenis Nodin</option>
                    <option value="inisiatif">Inisiatif</option>
                    <option value="disposisi">Disposisi</option>
                  </select>
               </div>

               <div class="form-group" id="det_div_surat_masuk">
                  <label>Surat Masuk</label>
                  <select class="form-control" name="id_surat_masuk" id="det_id_surat_masuk" disabled="disabled">
                    <option value="">Pilih Surat Masuk</option>
                  </select>
               </div>
               
               <input type="hidden" id="det_id_nodin" name="id_nodin" disabled="disabled" />
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
      getListNotaDinas();
      getListSuratMasuk();
      $('#tanggal').datepicker({
            format: 'yyyy-mm-dd',
            // todayHighlight: true,
            autoclose: true,
            // startDate: '2017-12-18',
            endDate:'d',
        });
      $('#jenis').change(function(){
        if ($(this).val()=="disposisi") {
          // alert($(this).val());
          $('#div_surat_masuk').show();
        }else{
          $('#div_surat_masuk').hide();
        }
      });

      
    });


  function getListNotaDinas(){
    $('#tbody').html("");
    $.ajax({
                url: "{{url('/api/getlistnotadinas')}}",
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
                      ctn_file = '<a class="btn btn-xs btn-teal" title="Lihat file dokumen Nota Dinas" href="'+link_file+dt[i].file_dokumen+'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
                    }

                    // if (dt[i].status==0) {
                    //   ctn_notif = '<a href="javascript:sendNotif(\''+(i+1)+'\',\''+dt[i].id+'\',\''+dt[i].id_user+'\',\''+dt[i].id_user_camat+'\',\''+dt[i].firebase+'\')">'+
                    //                    '<button class="btn btn-xs btn-teal" title="Kirim Notifikasi"><i class="fa fa-bell" style=""></i></button>'+
                    //                    '</a>';
                    // }else if (dt[i].status==1) {
                    //   ctn_notif = '<span class="text-success"><i class="fa fa-check-square"></i> Notif Terkirim</span>';
                    // }else if (dt[i].status==2) {
                    //   ctn_notif = '<span class="text-success"><i class="fa fa-eye"></i> Notif Terbaca</span>';
                    // }
                    
                    content+='<tr>'+
                                '<td>'+(i+1)+'</td>'+
                                '<td id="tanggal_'+(i+1)+'" data-val="'+dt[i].tanggal+'">'+dt[i].tanggal+'</td>'+
                                '<td id="nomor_'+(i+1)+'" data-val="'+dt[i].nomor+'">'+dt[i].nomor+'</td>'+
                                '<td id="perihal_'+(i+1)+'" data-val="'+dt[i].perihal+'">'+dt[i].perihal+'</td>'+
                                '<td id="asal_'+(i+1)+'" data-val="'+dt[i].asal+'">'+dt[i].asal+'</td>'+
                                '<td id="tujuan_'+(i+1)+'" data-val="'+dt[i].tujuan+'">'+dt[i].tujuan+'</td>'+
                                '<td id="lampiran_'+(i+1)+'" data-val="'+dt[i].lampiran+'">'+dt[i].lampiran+'</td>'+
                                '<td id="sifat_'+(i+1)+'" data-val="'+dt[i].sifat+'">'+capitalize(dt[i].sifat)+'</td>'+
                                '<td id="jenis_'+(i+1)+'" data-val="'+dt[i].jenis+'" data-isi="'+dt[i].isi_ringkas+'" data-tem="'+dt[i].tembusan+'" data-idsm="'+dt[i].id_surat_masuk+'">'+
                                  capitalize(dt[i].jenis)+
                                '</td>'+
                                '<td class="text-center" id="file_dokumen_'+(i+1)+'" data-val="'+dt[i].file_dokumen+'">'+ctn_file+'</td>'+
                                '<td class="text-center">'+
                                      '<div class="btn-group" >'+
                                      '<a href="javascript:modalForm(\'Edit Nota Dinas\',\''+(i+1)+'\',\''+dt[i].id+'\')">'+
                                       '<button class="btn btn-xs btn-teal" title="Edit"><i class="fa fa-pencil" style=""></i></button>'+
                                       '</a>&nbsp;'+
                                       '<a href="javascript:modalDetail(\'Detail Nota Dinas\',\''+(i+1)+'\',\''+dt[i].id+'\')">'+
                                       '<button class="btn btn-xs btn-teal" title="Lihat detail surat"><i class="fa fa-search" style=""></i></button>'+
                                       '</a>&nbsp;'+
                                       '<a href="javascript:deleteNotaDinas('+dt[i].id+')"  onclick="return conf();">'+
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
                      { "targets": 9, "orderable": false},
                      { "targets": 10, "orderable": false},

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

  function modalForm(title,index,id){
        $('#nomor').val("");
        $('#tanggal').val("");
        $('#perihal').val("");
        $('#asal').val("");
        $('#tujuan').val("");
        $('#lampiran').val("");
        $('#isi_ringkas').val("");
        $('#tembusan').val("");
        $('#file_dokumen').val("");
        $('#sifat').val("");
        $('#jenis').val("");
        $('#id_surat_masuk').val("");
        $('#id_nodin').val("");
        $('#p_file_dokumen').html("Format file .pdf");

        $('#modal_title').html(title);

        if (id!='') {
          $('#nomor').val($('#nomor_'+index).attr('data-val'));
          $('#tanggal').val($('#tanggal_'+index).attr('data-val'));
          $('#perihal').val($('#perihal_'+index).attr('data-val'));
          $('#asal').val($('#asal_'+index).attr('data-val'));
          $('#tujuan').val($('#tujuan_'+index).attr('data-val'));
          $('#lampiran').val($('#lampiran_'+index).attr('data-val'));
          $('#isi_ringkas').val($('#jenis_'+index).attr('data-isi'));
          $('#tembusan').val($('#jenis_'+index).attr('data-tem'));
          // $('#file_dokumen').val($('#file_dokumen_'+index).attr('data-val'));

          $('#sifat').val($('#sifat_'+index).attr('data-val'));
          $('#jenis').val($('#jenis_'+index).attr('data-val'));
          $('#id_surat_masuk').val($('#jenis_'+index).attr('data-idsm'));
          $('#id_nodin').val(id);
          if ($('#file_dokumen_'+index).attr('data-val')!="") {
            $('#p_file_dokumen').html("Format file .pdf | Current File : "+$('#file_dokumen_'+index).attr('data-val'));
          }
        }
        $('#btn_save').attr('onclick', 'modalSave()');
        $('#modal').modal('show');
  }

  function modalSave(){

    var nomor = $('#nomor').val();
    var tanggal = $('#tanggal').val();
    var perihal = $('#perihal').val();
    var asal = $('#asal').val();
    var tujuan = $('#tujuan').val();
    var lampiran = $('#lampiran').val();
    var isi_ringkas = $('#isi_ringkas').val();
    var tembusan = $('#tembusan').val();
    var file_dokumen = $('#file_dokumen').prop('files')[0];
    var sifat = $('#sifat').val();
    var jenis = $('#jenis').val();
    var id_surat_masuk = $('#id_surat_masuk').val();
    var id_nodin = $('#id_nodin').val();

    if (tanggal!=''&&perihal!=''&&asal!=''&&tujuan!=''&&sifat!=''&&jenis!='') {
      var form_data = new FormData();
      form_data.append('_token', '{{csrf_token()}}');
      form_data.append('nomor',nomor);
      form_data.append('tanggal',tanggal);
      form_data.append('perihal',perihal);
      form_data.append('asal',asal);
      form_data.append('tujuan',tujuan);
      form_data.append('lampiran',lampiran);
      form_data.append('isi_ringkas',isi_ringkas);
      form_data.append('tembusan',tembusan);
      form_data.append('file_dokumen',file_dokumen);
      form_data.append('sifat',sifat);
      form_data.append('jenis',jenis);
      form_data.append('id_surat_masuk',id_surat_masuk);
      form_data.append('id',id_nodin);
       console.log(
                  ...form_data
                 );

        $.ajax({
               url: "{{url('/api/addnotadinas')}}",
               type: "POST",
               processData: false,
               contentType: false,
               data:
                  form_data
               ,
               beforeSend: function() {
                 // console.log(
                 //  form_data
                 // );
                 if (id_nodin=='') {
                   console.log('Tambah data nodin : '+perihal);
                 }else{
                   console.log('Update data nodin : '+id_nodin+' | perihal : '+perihal);
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
                    
                    $('#modal').modal('hide');
               },
               complete: function() {
                 getListNotaDinas();
               },
               error: function() {
                   alert("Memproses data gagal !");
               }
           });
    }else{
        alert('Lengkapi form!');
    }
  }

  function deleteNotaDinas(id){
    $.ajax({
               url: "{{url('/api/deletenotadinas')}}",
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

                console.log('Delete Nota Dinas : '+id);


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
                 getListNotaDinas();
               },
               error: function() {
                   alert("Memproses data gagal !");
               }
           });
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

                },
                success: function(dt) {
                  // dt = JSON.parse(data);

                  console.log(dt);
                  content = '';
                   content+='<option value="">Pilih Surat Masuk</option>';
                  for (var i = 0; i < dt.length; i++) {
                    content+='<option value="'+dt[i].id+'">'+dt[i].nomor_surat +' : '+dt[i].perihal+' ('+dt[i].tanggal_surat+')</option>';
                  }
                  $('#id_surat_masuk').html(content);
                  $('#det_id_surat_masuk').html(content);
                },
                complete: function() {

                },
                error: function() {
                    alert("Memproses data gagal !");
                }
            });
  }

  function modalDetail(title,index,id){
        $('#det_nomor').val("");
        $('#det_tanggal').val("");
        $('#det_perihal').val("");
        $('#det_asal').val("");
        $('#det_tujuan').val("");
        $('#det_lampiran').val("");
        $('#det_isi_ringkas').val("");
        $('#det_tembusan').val("");
        $('#det_sifat').val("");
        $('#det_jenis').val("");
        $('#det_id_surat_masuk').val("");
        $('#det_id_nodin').val("");

        $('#det_file').html('<i style="color:#ff0000;">Belum ada file</i>');
        $('#modal_detail_title').html(title);

         

        if (id!='') {
            $('#det_nomor').val($('#nomor_'+index).attr('data-val'));
            $('#det_tanggal').val($('#tanggal_'+index).attr('data-val'));
            $('#det_perihal').val($('#perihal_'+index).attr('data-val'));
            $('#det_asal').val($('#asal_'+index).attr('data-val'));
            $('#det_tujuan').val($('#tujuan_'+index).attr('data-val'));
            $('#det_lampiran').val($('#lampiran_'+index).attr('data-val'));
            $('#det_isi_ringkas').val($('#jenis_'+index).attr('data-isi'));
            $('#det_tembusan').val($('#jenis_'+index).attr('data-tem'));
            $('#det_sifat').val($('#sifat_'+index).attr('data-val'));
            $('#det_jenis').val($('#jenis_'+index).attr('data-val'));
            $('#det_id_surat_masuk').val($('#jenis_'+index).attr('data-idsm'));
            $('#det_id_nodin').val(id);
            if ($('#file_dokumen_'+index).attr('data-val')!=""&&$('#file_dokumen_'+index).attr('data-val')!=null) {
              lk = "{{url('/')}}"+"/"+$('#file_dokumen_'+index).attr('data-val');
              $('#det_file').html('<a href="'+lk+'" target="_blank"><i class="fa fa-file-pdf-o"></i> '+$('#file_dokumen_'+index).attr('data-val')+'</a>');
            }
        }


          if ($('#det_jenis').val()=="disposisi") {
            $('#det_div_surat_masuk').show();
          }else{
            $('#det_div_surat_masuk').hide();
          }
        $('#modal-detail').modal('show');
  }

</script>
@endsection
