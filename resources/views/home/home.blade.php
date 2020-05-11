@extends('home.template')
@section('css')
<style type="text/css">
  .info-box-text{
    font-size: 1.75rem;
    padding: 25px 0;
    text-transform: none;
    letter-spacing: 0.1rem;
    /*font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif;*/
  }

  .pointer:hover{
    cursor: pointer;
  }

  .button-date{
    text-align: center;
    width: 50%;
    margin: 0 auto;
    padding: 10px;
    width: 100px;
  }
  .button-date:hover{
    cursor: pointer;
    background: #0AB690;
    color:#fff;
  }

  .button-letter{
    text-align: center;
    width: 50%;
    margin: 0 auto;
    padding: 10px;
    width: 200px;
  }
  .button-letter:hover{
    cursor: pointer;
    background: #0AB690;
    color:#fff;
  }
</style>
@endsection
@section('content-header')
 <h1>
        Home
        <small>Sisanti Geulis</small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#"></a></li>
        <li></li> -->
      </ol>
@endsection
@section('content')
    <div class="row" id="row-arsip">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box pointer" onclick="clickArsip('surat_masuk')">
            <span class="info-box-icon bg-aqua"><i class="fa fa-pencil-square-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Arsip Surat Masuk</span>
              <!-- <span class="info-box-number">90<small>%</small></span> -->
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box pointer" onclick="clickArsip('surat_keluar')"> 
            <span class="info-box-icon bg-red"><i class="fa fa-send"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Arsip Surat Keluar</span>
              <!-- <span class="info-box-number">41,410</span> -->
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <!-- <div class="clearfix visible-sm-block"></div> -->

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box pointer" onclick="clickArsip('nota_dinas')"> 
            <span class="info-box-icon bg-yellow"><i class="fa fa-sticky-note-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Arsip Nota Dinas</span>
              <!-- <span class="info-box-number">760</span> -->
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
    <div class="box" id="box-arsip" style="display: none;">
        <div class="box-header with-border">
          <h3 class="box-title" id="box-title-arsip">Title</h3>

          <div class="box-tools pull-right" >
            <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
              <i class="fa fa-minus"></i></button> -->
            <!-- <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
              <i class="fa fa-times"></i></button> -->
              <button type="button" class="btn btn-box-tool" onclick="hideArsip();">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body" id="body-arsip">
          <!-- <img src="{{asset('file_assets/img/logo_pemkab_bogor.png') }}" style="margin:0 auto;display: block;"> -->
        </div>
        <div class="overlay div_loading" id="loading"><i class="fa fa-refresh fa-spin"></i></div>
        <!-- /.box-body -->
        <!-- <div class="box-footer">
          Ini footer
        </div> -->
        <!-- /.box-footer-->
      </div>
@endsection

@section('outside-content')
<div class="modal fade" id="modal-suratmasuk" role="dialog" style="z-index: 1050;">
   <div class="modal-dialog">
      <div class="box box-success">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title" style="font-weight:bold;">Detail Surat Masuk</h4>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label>Nomor Surat</label>
                  <input type="text" name="nomor_surat" class="form-control" id="sm_nomor_surat" disabled="disabled" placeholder="Nomor Surat">
               </div>
               <div class="form-group">
                  <label>Tanggal Surat</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="tanggal_surat" class="form-control pull-right" id="sm_tanggal_surat" disabled="disabled" placeholder="Tanggal Surat">
                  </div>
               </div>
               <div class="form-group">
                  <label>Perihal</label>
                  <input type="text" name="perihal" class="form-control" id="sm_perihal" disabled="disabled" placeholder="Perihal">
               </div>

               <div class="form-group">
                  <label>Asal Surat</label>
                  <input type="text" name="asal_surat" class="form-control" id="sm_asal_surat" disabled="disabled" placeholder="Asal Surat">
               </div>

               <div class="form-group">
                  <label>Lampiran</label>
                  <input type="text" name="lampiran" class="form-control" id="sm_lampiran" disabled="disabled" placeholder="Lampiran">
               </div>

               <div class="form-group">
                  <label for="exampleInputFile">File Dokumen</label>
                  <!-- <input type="file" id="file_dokumen"> -->
                  <div id="sm_file"></div>
                </div>

                <div class="form-group">
                  <label>Disposisi</label>
                  <!-- <select class="form-control" name="id_user_camat" id="sm_id_user_camat" disabled="disabled">

                  </select> -->
                  <input type="text" name="lampiran" class="form-control" id="sm_id_user_camat" disabled="disabled" placeholder="Lampiran">
               </div>
               <div class="form-group">
                  <label>Ringkasan Surat</label>
                  <textarea class="form-control" rows="2" placeholder="Ringkasan surat ..." id="sm_ringkasan_surat" disabled="disabled"></textarea>
               </div>
               <div class="form-group">
                  <label>Catatan</label>
                  <textarea class="form-control" rows="2" placeholder="Catatan ..." id="sm_catatan" disabled="disabled"></textarea>
               </div>
               <!-- <input type="hidden" id="note_breach_date" name="note_breach_date" /> -->
               <input type="hidden" id="sm_id_surat_masuk" name="id_surat_masuk" />
               <input type="hidden" id="sm_id_user" name="id_user" />
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
  @if(\Session::has('alert'))
                    <script type="text/javascript">
                      alert("{{Session::get('alert')}}");
                    </script>
  @endif

  <script type="text/javascript">
    function clickArsip(jenis){
      $('#loading').show();
      $('#box-arsip').show();
      $('#row-arsip').hide();
      $('#body-arsip').html("");
      link_api = "{{url('/api')}}"+'/';
      if (jenis=='surat_masuk') {
        $('#box-title-arsip').html('Arsip Surat Masuk');
        link_api+='getdistinctdatesuratmasuk';
      }else if (jenis=='surat_keluar') {
        $('#box-title-arsip').html('Arsip Surat Keluar');
      }else if (jenis=='nota_dinas') {
        $('#box-title-arsip').html('Arsip Nota Dinas');
      }

      $.ajax({
                url: link_api,
                type: "GET",
                data: {
                },
                beforeSend: function() {
                  
                },
                success: function(dt) {
                  // dt = JSON.parse(data);
                  console.log(dt);
                  content = '';
                  for (var i = 0; i < dt.length; i++) {
                    if (i%4==0) {
                      content+='<div class="row">';  
                    }
                    content+='<div class="col-sm-3">';
                      content+='<div class="button-date" onclick="clickDate(\''+dt[i].tanggal+'\',\''+jenis+'\')">'+
                                '<i class="fa fa-folder-o" style="font-size:3rem;"></i>'+
                                '<p>'+dt[i].tanggal+'</p>'+
                                '</div>';
                    content+='</div>';
                    if (i%4==3) {
                      content+='</div>';
                    }
                  }
                  
                  $('#body-arsip').html(content);
                },
                complete: function() {
                  $('#loading').hide();
                },
                error: function() {
                    alert("Memproses data gagal !");
                }
            });
    }

    function clickDate(tanggal,jenis){
      $('#body-arsip').html("");
       $('#loading').show();

      link_api = "{{url('/api')}}"+'/';
      if (jenis=='surat_masuk') {
        link_api+='getlistsuratmasukbydate';
      }else if (jenis=='surat_keluar') {

      }else if (jenis=='nota_dinas') {

      }

      $.ajax({
                url: link_api+'/'+tanggal,
                type: "GET",
                data: {
                },
                beforeSend: function() {
                  
                },
                success: function(dt) {
                  // dt = JSON.parse(data);
                  console.log(dt);
                  content = '';
                  for (var i = 0; i < dt.length; i++) {
                    func_onclick = '';
                    if (jenis=='surat_masuk') {
                      func_onclick='modalSuratMasuk(\''+dt[i].id+'\')';
                    }else if (jenis=='surat_keluar') {

                    }else if (jenis=='nota_dinas') {

                    }

                    if (i%4==0) {
                      content+='<div class="row">';  
                    }
                    content+='<div class="col-sm-3">';
                      content+='<div class="button-letter" onclick="'+func_onclick+'">'+
                                '<i class="fa fa-envelope" style="font-size:3rem;"></i>'+
                                '<p>'+dt[i].perihal+' ('+dt[i].nomor_surat+')</p>'+
                                '</div>';
                    content+='</div>';
                    if (i%4==3) {
                      content+='</div>';
                    }
                  }
                  
                  $('#body-arsip').html(content);
                },
                complete: function() {
                  $('#loading').hide();
                },
                error: function() {
                    alert("Memproses data gagal !");
                }
            });
    }

    function modalSuratMasuk(id){
      $.ajax({
                url: "{{url('/api/getsuratmasuk')}}"+'/'+id,
                type: "GET",
                data: {
                },
                beforeSend: function() {
                  $('#sm_nomor_surat').val("");
                  $('#sm_tanggal_surat').val("");
                  $('#sm_perihal').val("");
                  $('#sm_asal_surat').val("");
                  $('#sm_lampiran').val("");
                  $('#sm_file_dokumen').val("");
                  $('#sm_catatan').val("");
                  $('#sm_ringkasan_surat').val("");
                  $('#sm_id_surat_masuk').val("");
                  $('#sm_id_user_camat').val("");
                  $('#sm_file').html('<i style="color:#ff0000;">Belum ada file</i>');
                },
                success: function(dt) {
                  // dt = JSON.parse(data);
                  console.log(dt);
                  


                      $('#sm_nomor_surat').val(dt[0].nomor_surat);
                      $('#sm_tanggal_surat').val(dt[0].tanggal_surat);
                      $('#sm_perihal').val(dt[0].perihal);
                      $('#sm_asal_surat').val(dt[0].asal_surat);
                      $('#sm_lampiran').val(dt[0].lampiran);
                      if (dt[0].file_dokumen!=""&&dt[0].file_dokumen!=null) {
                        lk = "{{url('/')}}"+"/"+dt[0].file_dokumen;
                        $('#sm_file').html('<a href="'+lk+'" target="_blank"><i class="fa fa-file-pdf-o"></i> '+dt[0].file_dokumen+'</a>');
                      }
                      
                      $('#sm_catatan').val(dt[0].catatan);
                      $('#sm_ringkasan_surat').val(dt[0].ringkasan_surat);

                      $('#sm_id_surat_masuk').val(id);
                      $('#sm_id_user_camat').val(dt[0].nama_lengkap_camat+' ('+dt[0].username_camat+')');
                      $('#sm_id_user').val(dt[0].id_user);
                      $('#modal-suratmasuk').modal('show');
                },
                complete: function() {
                  
                },
                error: function() {
                    alert("Memproses data gagal !");
                }
            });
      
    }

    function modalSuratKeluar(id){

    }

    function modalNotaDinas(id){

    }

    function hideArsip(){
      $('#row-arsip').show();
      $('#box-arsip').hide();
    }
  </script>
@endsection