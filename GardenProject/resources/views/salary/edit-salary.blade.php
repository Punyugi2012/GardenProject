@extends('layouts.app')
@section('title', 'แก้ไขการง่ายเงินเดือน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/salaries')}}">การจ่ายเงินเดือน</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขการง่ายเงินเดือน</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>แก้ไขการง่ายเงินเดือน</h3>
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
            <form action="{{url('/salaries/'.$salary->idSalary)}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="employee">ชื่อ-นามสกุล:</label>
                    <select class="custom-select form-control" name="employee" id="employee" required>
                        @foreach ($employees as $employee)
                            <option value="{{$employee->idEmployee}}" {{$salary->idEmployee == $employee->idEmployee ? 'selected' : ''}}>{{$employee->name}}-{{$employee->surname}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">วันที่:</label>
                            <input type="date" id="date" name="date" class="form-control" value="{{$salary->date}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="time">เวลา:</label>
                            <input type="time" id="time" name="time" class="form-control" value="{{$salary->time}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="round">รอบ:</label>
                            <input type="text" id="round" name="round" class="form-control" value="{{$salary->round}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount_money">จำนวนเงิน (บาท):</label>
                            <input type="number" step=any id="amount_money" name="amount_money" class="form-control" value="{{$salary->amount_money}}"required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cost">ค่าเสียหาย (บาท):</label>
                            <input type="number" step=any id="cost" name="cost" class="form-control" value="{{$salary->cost}}" required>
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