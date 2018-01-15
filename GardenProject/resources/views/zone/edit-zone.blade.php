@extends('layouts.app')
@section('title', 'แก้ไขโซน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/zones')}}">โซน</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขโซน</li>
    </ol>
</nav>
@endsection
@section('content')
 <div class="card" style="margin-top:10px">
     <div class="card-header">
         <h3>แก้ไขโซน</h3>
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
        <form action="{{url('/zones/'.$zone->idZone)}}" method="POST" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="area">พื้นที่:</label>
                        <input type="number" step="any" id="area" name="area" class="form-control" value="{{$zone->area}}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="size">ขนาด:</label>
                        <input type="number" step="any" id="size" name="size" class="form-control" value="{{$zone->size}}" required>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">บันทึก</button>
                <button type="reset" class="btn btn-warning">รีเซ็ต</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('footer')
@if (session()->has('edited'))
<script type="text/javascript">
    swal({
        title: "<?php echo session()->get('edited'); ?>",
        text: "ผลการทำงาน",
        timer: 10000,
        type: 'success',
        showConfirmButton: false
    });
</script>
@endif
@endsection