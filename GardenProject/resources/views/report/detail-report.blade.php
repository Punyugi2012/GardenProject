@extends('layouts.app')
@section('title', 'รูปภาพการายงาน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item" aria-current="page"><a href="{{url('/reports')}}">การรายงาน</a></li>
        <li class="breadcrumb-item active" aria-current="page">รูปภาพการรายงาน</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รูปภาพการรายงาน</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{url('/reports/'.$idReport.'/images')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="report_image">รูปภาพรายงาน:
                            <img id="image_upload_preview" src="#" alt="report image" style="widht:200px;height:200px">
                    </label>
                    <input type="file" id="report_image" name="report_image" class="form-control"  accept="image/*" style="width:30%"required>
                </div>
                <button type="submit" class="btn btn-primary">บันทึก</button>
            </form>
            @foreach ($images as $image)
                <div class="text-center" style="margin-top:10px"> 
                    <a href="{{ asset('images/'.$image->pathFile) }}" data-lity>
                        <img src="{{ asset('images/'.$image->pathFile) }}" style="width:500px;height:500px" class="img-thumbnail">
                    </a>
                    <div style="margin-top:10px">
                        <form action="{{url('/image_report/'.$image->idReportImage.'/report/'.$idReport)}}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-warning">ลบ</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('footer')
    <script type="text/javascript">
        $(document).ready( function () {   
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
        
                    reader.onload = function (e) {
                        $('#image_upload_preview').attr('src', e.target.result);
                    }
        
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#report_image").change(function () {
                readURL(this);
            });
        });
    </script>
    @if (session()->has('added'))
        <script type="text/javascript">
            swal({
                title: "<?php echo session()->get('added'); ?>",
                text: "ผลการทำงาน",
                timer: 10000,
                type: 'success',
                showConfirmButton: false
            });
        </script>
    @elseif (session()->has('deleted'))
        <script type="text/javascript">
            swal({
                title: "<?php echo session()->get('deleted'); ?>",
                text: "ผลการทำงาน",
                timer: 10000,
                type: 'success',
                showConfirmButton: false
            });
        </script>
    @endif
@endsection