@extends('layouts.app')
@section('title', 'เพิ่มการจ่ายเงินเดือน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/salaries')}}">การจ่ายเงินเดือน</a></li>
        <li class="breadcrumb-item active" aria-current="page">เพิ่มการจ่ายเงินเดือน</li>
    </ol>
</nav>
@endsection
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
                            <option value="{{$employee->idEmployee}}">{{$employee->name}}-{{$employee->surname}}, เงินเดือน {{$employee->salary}} บาท</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">วันที่:</label>
                            <input type="date" id="date" name="date" class="form-control" placeholder="วันที่" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="time">เวลา:</label>
                            <input type="time" id="time" name="time" class="form-control" placeholder="เวลา" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="round">รอบ:</label>
                            <input type="text" id="round" name="round" class="form-control" placeholder="จากวันที่-ถึงวันที่ เดือน ปี, เช่น 1-31 ธ.ค. 60" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount_money">จำนวนเงิน (บาท):</label>
                            <input type="number" step=any id="amount_money" name="amount_money" class="form-control" placeholder="จำนวนเงิน" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cost">ค่าเสียหาย (บาท):</label>
                            <input type="number" step=any id="cost" name="cost" class="form-control" placeholder="จำนวนค่าเสียหาย" required>
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
