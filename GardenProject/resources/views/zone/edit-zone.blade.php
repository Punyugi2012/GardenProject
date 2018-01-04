@extends('layouts.app')
@section('title', 'แก้ไขโซน')
@section('content')
 <div class="card" style="margin-top:10px">
     <div class="card-header">
         <h3>แก้ไขโซน</h3>
     </div>
    <div class="card-body">
        <form action="{{url('/zones/'.$zone->idZone)}}" method="POST" enctype="multipart/form-data" autocomplete="off">
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
                <button type="submit" class="btn btn-light">บันทึก</button>
                <button type="reset" class="btn btn-light">ล้าง</button>
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