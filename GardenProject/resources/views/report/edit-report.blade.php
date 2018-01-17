@extends('layouts.app')
@section('title', 'แก้ไขการรายงาน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item" aria-current="page"><a href="{{url('/reports')}}">การรายงาน</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขการรายงาน</li>
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
            <h3>แก้ไขการรายงาน</h3>
        </div>
        <div class="card-body">
            <form action="{{url('/reports/'.$report->idReport)}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT')}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employee">พนักงาน:</label>
                            <select class="custom-select form-control" id="employee" name="employee">
                                @foreach ($employees as $employee)
                                    <option value="{{$employee->idEmployee}}" {{$report->idEmployee == $employee->idEmployee ? 'selected' : ''}}>{{$employee->name}}-{{$employee->surname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="assignment">การมอบหมายงาน:</label>
                            <select class="custom-select form-control" id="assignment" name="assignment">
                                @foreach ($assignments as $assignment)
                                    <option value="{{$assignment->idAssignment}}" {{$report->idAssignment == $report->idAssignment ? 'selected' : ''}}>เลขที่การมอบหมายงาน {{$assignment->idAssignment}}, เวลา {{formatDateThai($assignment->time)}} วันที่ {{formatDateThai($assignment->date)}}, ประเภท {{$assignment->name}}, สถานะ {{$assignment->status == 'success'? 'เรียบร้อยแล้ว' : 'ยังไม่เรียบร้อย'}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">วันที่:</label>
                            <input type="date" id="date" name="date" class="form-control" value="{{$report->date_report}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="time">เวลา:</label>
                            <input type="time" id="time" name="time" class="form-control" value="{{$report->time_report}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="type">ประเภท:</label>
                            <select class="custom-select form-control" id="type" name="type" required>
                                <option value="permission" {{$report->type == 'permission' ? 'selected' : ''}}>ขออนุญาติเบิกเครื่องตัดหญ้า</option>
                                <option value="report"  {{$report->type == 'report' ? 'selected' : ''}}>รายงาน</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="detail">รายละเอียด:</label>
                    <textarea class="form-control" id="detail" name="detail" placeholder="รายละเอียด" required>{{$report->detail}}</textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
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