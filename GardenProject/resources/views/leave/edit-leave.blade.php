@extends('layouts.app')
@section('title', 'แก้ไขการลางาน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/leaves')}}">การลางาน</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขการลางาน</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>แก้ไขการลางาน</h3>
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
            <form action="{{url('/leaves/'.$leave->idTakeLeave)}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="employee">ชื่อ-นามสกุล:</label>
                    <select class="custom-select form-control" name="employee" id="employee" required>
                        @foreach ($employees as $employee)
                            <option value="{{$employee->idEmployee}}" {{$leave->idEmployee == $employee->idEmployee ? 'selected':''}}>{{$employee->name}}-{{$employee->surname}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="from_date">จากวันที่:</label>
                            <input type="date" id="from_date" name="from_date" value="{{$leave->from_date}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="to_date">ถึงวันที่:</label>
                            <input type="date" id="to_date" name="to_date" value="{{$leave->to_date}}" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="type">ประเภท:</label>
                    <select class="custom-select form-control" name="type" id="type" required>
                        <option value="vacationleave" {{$leave->type == 'vacationleave' ? 'selected':''}}>ลาพักร้อน</option>
                        <option value="personalleave" {{$leave->type == 'personalleave' ? 'selected':''}}>ลากิจ</option>
                        <option value="maternityleave" {{$leave->type == 'maternityleave' ? 'selected':''}}>ลาครอด</option>
                        <option value="sickleave" {{$leave->type == 'sickleave' ? 'selected':''}}>ลาป่วย</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cause">สาเหตุ</label>
                    <textarea class="form-control" id="cause" rows="3" name="cause" required>
                        {{$leave->cause}}
                    </textarea>
                </div>
                <div class="text-center">
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