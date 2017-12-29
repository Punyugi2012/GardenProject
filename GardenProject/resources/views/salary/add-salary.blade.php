@extends('layouts.app')
@section('title', 'เพิ่มการจ่ายเงินเดือน')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>เพิ่มการจ่ายเงินเดือน</h3>
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
            <form action="{{url('/salaries')}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="employee">ชื่อ-นามสกุล:</label>
                    <select class="custom-select form-control" name="employee" id="employee" required>
                        <option value="" selected>เลือกชื่อ-นามสกุล</option>
                        @foreach ($employees as $employee)
                            <option value="{{$employee->idEmployee}}">{{$employee->name}}-{{$employee->surname}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_time">วันที่:</label>
                            <input type="datetime-local" id="date_time" name="date_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="round">รอบ:</label>
                            <input type="text" id="round" name="round" class="form-control" placeholder="จากวันที่-ถึงวันที่ เดือน ปี, เช่น 1-31 ธ.ค. 60" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount_money">จำนวนเงิน:</label>
                            <input type="number" id="amount_money" name="amount_money" class="form-control" placeholder="จำนวนเงิน" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cost">ค่าเสียหาย:</label>
                            <input type="number" id="cost" name="cost" class="form-control" placeholder="จำนวนค่าเสียหาย" required>
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