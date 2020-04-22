@extends('home.template')

@section('content-header')
 <h1>
        Blank page
        <small>it all starts here</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
@endsection
@section('content')
    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Title</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <img src="{{asset('file_assets/img/logo_pemkab_bogor.png') }}" style="margin:0 auto;display: block;">
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          Ini footer
        </div>
        <!-- /.box-footer-->
      </div>
@endsection

@section('script')
  @if(\Session::has('alert'))
                    <script type="text/javascript">
                      alert("{{Session::get('alert')}}");
                    </script>
  @endif
@endsection