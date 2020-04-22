<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login Admin KN Ngada</title>
  <script src="{{asset('file_assets/mylogin/js/jquery.min.js')}}"></script>
  <script src="{{asset('file_assets/adminlte/dist/js/adminlte.min.js')}}"></script>
  <link rel="stylesheet" type="text/css" href="{{asset('file_assets/mylogin/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('file_assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('file_assets/adminlte/dist/css/AdminLTE.css')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('file_assets/mylogin/css/my-login.css')}}">
<link rel="shortcut icon" href="{{asset('file_assets/img/logo_pemkab_bogor.png') }}">
  <style type="text/css">

  body{
    background: #0AB690 !important;
  }

    .my-login-page .brand {
        /*width: 130px;*/
        /* height: 90px; */
        /*overflow: hidden;*/
        /* border-radius: 50%; */
        /* margin: 0 auto; */
        margin: 60px auto;
        /* box-shadow: 0 0 40px rgba(0,0,0,.05); */

    }

    .overlay{
          z-index: 50;
          background: rgba(255, 255, 255, 0.7);
          border-radius: 3px;
              position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    }

    .overlay>.fa{
      position: absolute;
    top: 50%;
    left: 50%;
    margin-left: -15px;
    margin-top: -15px;
    color: #000;
    font-size: 30px;
    }

    .form-control:focus {
      border-color: #0AB690;
      box-shadow: none;
    }

    .my-login-page .footer {

      color: #fff !important;
      /*text-shadow:
       3px 3px 0 #000, 
    -1px -1px 0 #000,
     1px -1px 0 #000,
     -1px 1px 0 #000,
      1px 1px 0 #000;*/
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
  </style>
</head>
<body class="my-login-page">
  <section class="h-100">
    <div class="container h-100">
      <div class="row justify-content-md-center h-100">
        <div class="card-wrapper">
          <div class="brand">
            <img src="{{asset('file_assets/img/logo_sisanti_geulis_landscape.png')}}" style="height: 100px; width: auto; display: block; margin: auto">
          </div>
          <div class="card fat">
            <div class="card-body">
              <h4 style="" class="card-title text-center">Login SISANTI GEULIS</h4>
              <form method="POST" id="form-login" action="{{url('/loginpost')}}">
                {{ csrf_field() }}
                @if(\Session::has('alert'))
                    <div class="alert alert-danger">
                        <div>{{Session::get('alert')}}</div>
                    </div>
                @endif
                <div class="form-group">
                  <label for="username">Username</label>
                  <input id="username" type="text" class="form-control" name="username" value="" required autofocus>
                </div>
                <div class="form-group">
                  <label for="password">Password
                  </label>
                  <input id="password" type="password" class="form-control" name="password" required data-eye>
                </div>
                <div class="form-group no-margin">
                  <button type="submit" id="input-submit" class="btn btn-teal btn-block" style="cursor: pointer;">
                    Login
                  </button>
                </div>
              </form>
              <div class="overlay" id="submit_loading" style="display: none;"><i class="fa fa-refresh fa-spin"></i></div>
            </div>

          </div>
          <div class="footer">
            SISANTI GEULIS | Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="modal modal-success fade in" id="modal-success" style="">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">

            <h4 class="modal-title">Login Success!</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <p id="msg-login" style="text-align: center;"></p>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

  <script src="{{asset('file_assets/mylogin/bootstrap/js/bootstrap.js')}}"></script>
  <script src="{{asset('file_assets/adminlte/dist/js/adminlte.min.js')}}"></script>
  <script src="{{asset('file_assets/mylogin/js/my-login.js')}}"></script>

  <script type="text/javascript">
    $('#password').keydown(function(event){
          var keyCode = (event.keyCode ? event.keyCode : event.which);
          if (keyCode == 13) {
              // $('#input-submit').trigger('click');
              $('#form-login').submit();
          }
      });
    
  </script>
</body>
</html>
