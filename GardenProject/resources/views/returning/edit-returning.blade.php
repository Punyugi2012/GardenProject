@extends('layouts.app')
@section('title', 'แก้ไขการคืน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href='{{url("/takes")}}'>เบิกอุปกรณ์</a></li>
        <li class="breadcrumb-item"><a href='{{url("/returnings?take={$take->idTake}")}}'>การคืนอุปกรณ์</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขการคืนอุปกรณ์</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>แก้ไขการคืน</h3>
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
            <form action='{{url("/returnings/$returning->idReverting")}}' method="POST" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employee">พนักงาน:</label>
                            <select class="custom-select form-control" id="employee" name="employee" required>
                                @foreach ($employees as $employee)
                                <option value="{{$employee->idEmployee}}" {{$returning->idEmployee == $employee->idEmployee ? 'selected' : ''}}>{{$employee->name}}-{{$employee->surname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="take">การเบิก:</label>
                            <select class="custom-select form-control" id="take" name="take" required>
                                <option value="{{$take->idTake}}">เลขที่การเบิก {{$take->idTake}}, เวลา {{formatDateThai($take->time_take)}} น. วันที่ {{formatDateThai($take->date_take)}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="date">วันที่:</label>
                                <input type="date" id="date" name="date" value="{{$returning->date}}" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="time">เวลา:</label>
                            <input type="time" id="time" name="time" value="{{$returning->time}}" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">ยืนยัน</button>
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