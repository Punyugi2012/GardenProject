@extends('layouts.app')
@section('title', 'แก้ไขการลงเวลาทำงาน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/attendances')}}">การลงเวลาทำงาน</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขการลงเวลาทำงาน</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>แก้ไขการลงเวลาทำงาน</h3>
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
            <form action="{{url('/attendances/'.$attendance->idAttendance)}}" method="POST" autocomplete="off"> 
                {{ csrf_field() }}
                {{ method_field('PUT')}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="date">วันที่:</label>
                            <input type="date" id="date" name="date" value="{{$attendance->date}}" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="employee">ชื่อ-นามสกุล:</label>
                        <select class="custom-select form-control" name="employee" id="employee" required>
                            <option value="" selected>เลือกชื่อ-นามสกุล</option>
                            @foreach ($employees as $employee)
                                <option value="{{$employee->idEmployee}}" {{$attendance->idEmployee == $employee->idEmployee ? 'selected':''}}>{{$employee->name}}-{{$employee->surname}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_time">เวลาเข้าทำงาน:</label>
                            <input type="time" id="start_time" name="start_time" value="{{$attendance->start_time}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="finish_time">เวลาออกทำงาน:</label>
                            <input type="time" id="finish_time" name="finish_time" value="{{$attendance->finish_time}}" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">ยืนยัน</button>
                    <button type="reset" class="btn btn-warning">รีเซ็ต</button>
                </div>
            </form>
        </div>
    <div>
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