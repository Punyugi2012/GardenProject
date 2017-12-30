@extends('layouts.app')
@section('title', 'แก้ไขการง่ายเงินเดือน')
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_time">วันที่:</label>
                            <input type="datetime-local" id="date_time" name="date_time" value="{{$dateTime}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="round">รอบ:</label>
                            <input type="text" id="round" name="round" class="form-control" value="{{$salary->round}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount_money">จำนวนเงิน:</label>
                            <input type="number" step=any id="amount_money" name="amount_money" class="form-control" value="{{$salary->amount_money}}"required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cost">ค่าเสียหาย:</label>
                            <input type="number" step=any id="cost" name="cost" class="form-control" value="{{$salary->cost}}" required>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-light">ยืนยัน</button>
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