@extends('layouts.app')
@section('title', 'เพิ่มโซน')
@section('content')
 <div class="card" style="margin-top:10px">
     <div class="card-header">
         <h3>เพิ่มโซน</h3>
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
        <form action="{{url('/zones')}}" method="POST" autocomplete="off">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="area">พื้นที่:</label>
                        <input type="number" step="any" id="area" name="area" class="form-control" placeholder="พื้นที่ ตรม." required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="size">ขนาด:</label>
                        <input type="number" step="any" id="size" name="size" class="form-control" placeholder="ขนาด ไร่" required>
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
    @endif
@endsection
