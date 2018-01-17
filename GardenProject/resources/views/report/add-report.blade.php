@extends('layouts.app')
@section('title', 'เพิ่มการรายงาน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item" aria-current="page"><a href="{{url('/reports')}}">การรายงาน</a></li>
        <li class="breadcrumb-item active" aria-current="page">เพิ่มการรายงาน</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="card-header">
            <h3>เพิ่มการรายงาน</h3>
        </div>
        <div class="card-body">
            <form action="{{url('/reports')}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employee">พนักงาน:</label>
                            <select class="custom-select form-control" id="employee" name="employee">
                                <option value="">เลือกพนักงาน</option>
                                @foreach ($employees as $employee)
                                    <option value="{{$employee->idEmployee}}">{{$employee->name}}-{{$employee->surname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="assignment">การมอบหมายงาน:</label>
                            <select class="custom-select form-control" id="assignment" name="assignment">
                                <option value="">การมอบหมายงาน</option>
                                @foreach ($assignments as $assignment)
                                    <option value="{{$assignment->idAssignment}}">เลขที่การมอบหมายงาน {{$assignment->idAssignment}}, เวลา {{formatDateThai($assignment->time)}} วันที่ {{formatDateThai($assignment->date)}}, ประเภท {{$assignment->name}}, สถานะ {{$assignment->status == 'success'? 'เรียบร้อยแล้ว' : 'ยังไม่เรียบร้อย'}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">วันที่:</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="time">เวลา:</label>
                            <input type="time" id="time" name="time" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="type">ประเภท:</label>
                            <select class="custom-select form-control" id="type" name="type" required>
                                <option value="">เลือกประเภท</option>
                                <option value="permission">ขออนุญาติเบิกเครื่องตัดหญ้า</option>
                                <option value="report">รายงาน</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="detail">รายละเอียด:</label>
                    <textarea class="form-control" id="detail" name="detail" placeholder="รายละเอียด" required></textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                    <button type="reset" class="btn btn-warning">รีเซ็ต</button>
                </div>
            </form>
        </div>
    </div>
@endsection