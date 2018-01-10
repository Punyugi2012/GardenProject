@extends('layouts.app')
@section('title', 'รูปภาพโซน')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รูปภาพโซน</h3>
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
            <form action="{{url('/zones/'.$zone->idZone.'/images')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="profile_image">รูปสวน:
                            <img id="image_upload_preview" src="#" alt="zone image" style="widht:200px;height:200px">
                    </label>
                    <input type="file" id="zone_image" name="zone_image" class="form-control"  accept="image/*" style="width:30%"required>
                </div>
                <button type="submit" class="btn btn-light">บันทึก</button>
            </form>
            @foreach ($zone->images as $image)
                <div class="text-center" style="margin-top:10px"> 
                    <a href="{{ asset('images/'.$image->pathFile) }}" data-lity>
                        <img src="{{ asset('images/'.$image->pathFile) }}" style="width:500px;height:500px" class="img-thumbnail">
                    </a>
                    <div style="margin-top:10px">
                        <form action="{{url('/image_zone/'.$image->idZoneImage.'/zone/'.$zone->idZone)}}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-light">ลบ</button>
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
            $("#zone_image").change(function () {
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