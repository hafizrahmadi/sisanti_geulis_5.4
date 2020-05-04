<!DOCTYPE html>
<html>
<head>
<title>SISANTI GEULIS</title>
<!-- <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script> -->
<!-- <script type="text/javascript" src="assets/lib/bootstrap/dist/js/bootstrap.min.js"></script> -->

<!-- ADMIN LTE -->
    <!-- jQuery 3 -->
<script src="{{asset('file_assets/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script type="text/javascript">
    jQuery.browser = {};
    (function () {
        jQuery.browser.msie = false;
        jQuery.browser.version = 0;
        if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
            jQuery.browser.msie = true;
            jQuery.browser.version = RegExp.$1;
        }
    })();
</script>
<script type="text/javascript">
        function conf(){
            if(confirm("Anda yakin untuk menghapus ?")){
                return true;

            }else{
                window.close();
                return false;
            }
        }
</script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('file_assets/adminlte/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('file_assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('file_assets/adminlte/dist/js/adminlte.min.js')}}"></script>

<!-- datepicker -->
<script src="{{asset('file_assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>


<script language="javascript" type="text/javascript">
    var prog_percent = 0;
    $.paramUrl = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null){
            return null;
        }else{
            return decodeURI(results[1]) || 0;
        }
    }

    function _(x){
        return document.getElementById(x);
    }
    function _nm(x){
        return document.all(x);
    }


    $(document).ready(function () {
        // cekSession();

        // // download image
        // $("#download_img").click(function() {
     //    html2canvas($("#body"), {
     //      onrendered: function(canvas) {
     //        saveAs(canvas.toDataURL(), 'report.png');
     //      }
     //    });
     //  });

        // function saveAs(uri, filename) {
     //    var link = document.createElement('a');
     //    if (typeof link.download === 'string') {
     //      link.href = uri;
     //      link.download = filename;

     //      //Firefox requires the link to be in the body
     //      document.body.appendChild(link);

     //      //simulate click
     //      link.click();

     //      //remove the link when done
     //      document.body.removeChild(link);
     //    } else {
     //      window.open(uri);
     //    }
     //  }

        // // MENU utama active
        // if ($.paramUrl('mn')!=null)
        //  $('.nav').children('li').eq(parseInt($.paramUrl('mn'))-1).addClass( "active" );

        // $('#report_tabs').scrollTabs();

        // // sub navbar
        // $('.collapse').on('shown.bs.collapse', function (e) {
        //  $('.collapse').not(this).removeClass('in');
        // });
        // $('[data-toggle=collapse]').click(function (e) {
        //  $('[data-toggle=collapse]').parent('li').removeClass('active');
        //  $(this).parent('li').toggleClass('active');
        // });

        // // periode
        // // year
        // setYearMenu();
        // // month
        // master_x = getArrayBln();
        // master_op = '';
        // for (i=0; i<master_x.length; i++){
        //  val_bln = i+1;
        //  if (val_bln<=9)
        //      val_bln = '0'+val_bln;
        //  op_selected = '';
        //  if (i+1==getBln())
        //      op_selected = 'selected="selected"';
        //  master_op += '<option value="'+val_bln+'" '+op_selected+'>'+master_x[i]+'</option>';
        // }
        // $('#periode_m').html(master_op);

        // // dropdown hilang ketika klik di luar (tidak dapat fokus)
        // $('#sub_mn_reports').on("click", function(e){
        //  $(this).next('ul').toggle();
        //  e.stopPropagation();
        //  e.preventDefault();
        // });
    });

   function toggleFixed(){
    // alert($('.sidebar-toggle').data('test'));
    if ($('.sidebar-toggle').data('test')=='A') {
        $('body').addClass('fixed');
        $('.sidebar-toggle').data('test','B');
    }else{
        $('body').removeClass('fixed');
        $('.sidebar-toggle').data('test','A');
    };
   }
   function ucwords(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
    }
</script>



 <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('file_assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('file_assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('file_assets/adminlte/dist/css/AdminLTE.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('file_assets/adminlte/dist/css/skins/_all-skins.css') }}">
  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->

<link rel="shortcut icon" href="{{asset('file_assets/img/logo_sisanti_geulis_notext.png') }}">

<link rel="stylesheet" href="{{asset('file_assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">


<style>
   
    body { padding-right: 0 !important }
    
    /*.navbar .navbar-nav > li > a {
        padding-top:5px !important;
        padding-bottom:5px !important;
        line-height: 30px;
    }*/
    .navbar .navbar-brand{
        padding: 0 15px;
        line-height: 30px;
        height: 30px;
        margin:0;
        margin-top: 10px;
    }
    /*.navbar, .navbar-header {
        min-height:30px !important;
        margin:0;
    }*/

    /* sub navbar */
    .submenu {
        background-color: #e7e7e7;
    }
    .collapsing {
        display:none;
    }

    div.footer {
        color: #FFFFFF;
        padding:10px;
        text-align: right;
        font-weight:bold;
        background: #e7e7e7; /* Old browsers */
        /* IE9 SVG, needs conditional override of 'filter' to 'none' */
        background: -moz-linear-gradient(-45deg, #e7e7e7 0%, #000000 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#e7e7e7), color-stop(100%,#000000)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(-45deg, #e7e7e7 0%,#000000 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(-45deg, #e7e7e7 0%,#000000 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(-45deg, #e7e7e7 0%,#000000 100%); /* IE10+ */
        background: linear-gradient(135deg, #e7e7e7 0%,#000000 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e7e7e7', endColorstr='#000000',GradientType=1 ); /* IE6-8 fallback on horizontal gradient */
    }

    .mn_report_judul{
        font-weight:bold;
        text-align:center;
        font-size:18px;
    }
    .mn_report_judul img{
        width:40px;
        height:40px;
    }

    hr.mn_report_batas {
        border-top: 1px dashed #8c8b8b;
        padding:0;
        margin-top:0;
    }

    .rounded {
      border-radius: 20px 20px 0 0;
    }

    #isi_master{
        padding-top:10px;
        padding-bottom:10px;
    }
    .navbar-nav > .notifications-menu > .dropdown-menu{
        width: 400px !important;
    }

    .btn-teal {
      color: #ffffff;
      background-color: #0AB690;
      border-color: #0AB690;
      box-shadow: none;
    }

    .btn-teal:hover {
        background-color: #09A281;
        border-color: #09A281;
        color: #ffffff;
    }

    /*paginasi datatables*/
    .pagination>.active>a {
        color: #ffffff;
        background-color: #0AB690;
        border-color: #0AB690;
    }

    .pagination>.active>a:hover {
        color: #ffffff;
        background-color: #09A281;
        border-color: #09A281;
    }

    .pagination > a {
        color: #0AB690;
        background-color: #ffffff;
    }

    /*kebutuhan dropdown notif*/
    .navbar-nav > .messages-menu > .dropdown-menu > li .menu > li > a > h4 {
        padding: 0;
        margin: 0 0 0 0px;
        color: #444444;
        font-size: 15px;
        position: relative;
        white-space: pre-wrap;
    }

    .navbar-nav > .messages-menu > .dropdown-menu > li .menu > li > a > p {
      margin: 0 0 0 0px;
      font-size: 13px;
      color: #444444;
      white-space: pre-wrap;
    }

    .navbar-nav > .messages-menu > .dropdown-menu > li .menu > li > a > p.det {
      margin: 0 0 0 0px;
      font-size: 11px;
      color: #888888;
      white-space: pre-wrap;
    }
</style>
@yield('css')
<link rel="stylesheet" href="{{asset('file_assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.css') }}">
<!-- DataTables -->
<script src="{{asset('file_assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{asset('file_assets/adminlte/bower_components/datatables.net/js/dataTables.fixedColumns.min.js') }}"></script>

<script src="{{asset('file_assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script> -->


</head>

<body id="body" class="hold-transition skin-teal sidebar fixed">
    <div class="wrapper">

     <header class="main-header">
        <!-- Logo         -->
        <a href="#" class="logo" style="">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SG</b></span>
          <!-- logo for regular state and mobile devices -->

          <span class="logo-lg" style="letter-spacing: 1px; font-size:20px;"><img src="{{asset('file_assets/img/logo_sisanti_geulis_landscape2.png')}}" style="height: 50px;"> </span>
        </a>
         <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <!-- <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" onclick="toggleFixed()" data-test="A">
            <span class="sr-only">Toggle navigation</span>
          </a> -->
          <form class="navbar-form navbar-left form-inline" id="judul_hal">

          </form>
         <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
            <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning" id="label-notif"></span>
                </a>
                <ul class="dropdown-menu" id="dropdown-notif">
                  <li class="header">You have 4 messages</li>
                  <li>
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="{{asset('file_assets/img/user.png')}}" class="img-circle" alt="User Image">
                          </div>
                          <h4>
                            Support Team
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li>
              <li class="dropdown user user-menu ">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="{{asset('file_assets/img/user.png')}}" class="user-image" alt="User Image">
                  <span class="hidden-xs" id="user-name">{{session('username')}}</span>
                </a>
                <ul class="dropdown-menu">
                      <!-- User image -->
                      <li class="user-header">
                        <img src="{{asset('file_assets/img/user.png')}}" class="img-circle" alt="User Image">

                        <p id="user-name-detail">
                          {{session('username')}}
                        </p>
                      </li>
                      <!-- Menu Footer-->
                      <li class="user-footer">

                        <div class="pull-left">
                          <!-- <a href="" class="btn btn-default btn-flat"><i class="fa fa-home"></i> Home</a> -->
                        </div>
                        
                        <div class="pull-right">
                            <a href="{{url('/logout')}}" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                        </div>

                      </li>
                    </ul>
                </li>

            </ul>
          </div>
          

        </nav>
      </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu tree" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

            <!-- <form class="sidebar-menu"> -->
                  <!-- <li><a href="#"><i class="fa fa-inbox"></i> <span>Inbox</span></a></li>
                  <li><a href="#"><i class="fa fa-send-o"></i> <span>Outbox</span></a></li> -->
                  <!-- <li><a href="#"><i class="fa fa-bell"></i> <span>Notification</span></a></li> -->
                  <li><a href="{{url('/masteruser')}}"><i class="fa fa-user"></i> <span>Master User</span></a></li>
                  <li><a href="{{url('/catatsuratmasuk')}}"><i class="fa fa-pencil-square-o"></i> <span>Catat Surat Masuk</span></a></li>
                  <li><a href="javascript:alert('coming soon!');"><i class="fa fa-archive" style=""></i> Arsip Surat Masuk</a></li>
                  <li><a href="javascript:alert('coming soon!');"><i class="fa fa-sticky-note-o" style=""></i> Nota Dinas</a></li>
                  <li><a href="{{url('/list_disposisi')}}"><i class="fa fa-mail-forward" style=""></i> List Disposisi</a></li>
                  <li><a href="{{url('/catatsuratkeluar')}}"><i class="fa fa-send"></i> <span>Catat Surat Keluar</span></a></li>
              <!-- </form> -->


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <section class="content-header">
     @yield('content-header')
    </section>
    <!-- Main content -->
    <section class="content">
        @yield('content')
    </section>

    @yield('outside-content')
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
  <footer class="main-footer text-sm" style="padding:5px 15px;">
    <div class="pull-left hidden-xs">
      <b>SISANTI GEULIS | Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</b>
    </div>
    <strong>&nbsp;</strong>
  </footer>




</div>
<script type="text/javascript">
  $(document).ready(function() {
    getListNotifDisposisi();
     // setInterval(getListNotifDisposisi,5000);
    });
  function getListNotifDisposisi(){
    $('#tbody').html("");
    $.ajax({
                url: "{{url('/api/getlistnotifdisposisi')}}",
                type: "GET",
                data: {
                },
                beforeSend: function() {
                  // console.log(tablex);

                },
                success: function(dt) {
                  // dt = JSON.parse(data);

                  console.log(dt);
                  // content = '';
                  //  content+='<option value="">Pilih Camat</option>';
                  // for (var i = 0; i < dt.length; i++) {
                  //   content+='<option value="'+dt[i].id+'">'+dt[i].username +' ('+dt[i].nama_lengkap+' : '+dt[i].nama_jabatan+')</option>';
                  // }
                  content = '';

                  content+='<li class="header">Ada '+dt.length+' Notifikasi Disposisi</li>';
                  for (var i = 0; i < dt.length; i++) {
                    link = "{{url('/list_disposisi')}}";
                  content+=
                  '<li>'+
                    '<ul class="menu">'+
                      '<li>'+
                        '<a href="'+link+'">'+
                          '<h4>'+
                            '<i class="fa fa-mail-forward"></i> '+'Surat Masuk : '+dt[i].perihal+' ('+')'+
                            // '<small><i class="fa fa-clock-o"></i> 5 mins</small>'+
                          '</h4>'+
                          '<p>Telah didisposisikan dari '+dt[i].dari_username+', untuk '+dt[i].untuk_username+'.</p>'+
                          '<p class="det">Catatan : '+dt[i].catatan_disposisi+'</p>'+
                          '<p class="det">Instruksi : '+dt[i].instruksi+'</p>'+
                        '</a>'+
                      '</li>'+
                    '</ul>'+
                  '</li>';
                }
                content+='<li class="footer"><a href="#">Lihat Semua Disposisi</a></li>';
                  $('#label-notif').html(dt.length);
                  $('#dropdown-notif').html(content);
              },
              complete: function() {
              },
              error: function() {
                  alert("Load data notif disposisi gagal !");
              }
          });
  }

</script>
@yield('script')
</body>
</html>
