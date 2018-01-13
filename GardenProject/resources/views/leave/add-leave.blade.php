@extends('layouts.app')
@section('title', 'เพิ่มการลางาน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/leaves')}}">การลางาน</a></li>
        <li class="breadcrumb-item active" aria-current="page">เพิ่มการลางาน</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>เพิ่มการลางาน</h3>
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
            <form action="{{url('/leaves')}}" method="POST" autocomplete="off">
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
                            <label for="from_date">จากวันที่:</label>
                            <input type="date" id="from_date" name="from_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="to_date">ถึงวันที่:</label>
                            <input type="date" id="to_date" name="to_date" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="type">ประเภท:</label>
                    <select class="custom-select form-control" name="type" id="type" required>
                        <option value="" selected>เลือกประเภท</option>
                        <option value="vacationleave">ลาพักร้อน</option>
                        <option value="personalleave">ลากิจ</option>
                        <option value="maternityleave">ลาครอด</option>
                        <option value="sickleave">ลาป่วย</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cause">สาเหตุ</label>
                    <textarea class="form-control" id="cause" rows="3" name="cause" placeholder="สาเหตุ" required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-light">บันทึก</button>
                    <button type="reset" class="btn btn-light">ล้าง</button>
                </div>
            </form>
        </div>
    </div>
@endsection