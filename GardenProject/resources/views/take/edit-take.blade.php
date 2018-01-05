@extends('layouts.app')
@section('title', 'แก้ไขการเบิก')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>แก้ไขการเบิก</h3>
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
            <form action="{{url('/takes/'.$take->idTake)}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employee">พนักงาน:</label>
                            <select class="custom-select form-control" id="employee" name="employee" required>
                                @foreach ($employees as $employee)
                                <option value="{{$employee->idEmployee}}" {{$take->idEmployee == $employee->idEmployee ? 'selected' : ''}}>{{$employee->name}}-{{$employee->surname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="assignment">การมอบหมายงาน:</label>
                            <select class="custom-select form-control" id="assignment" name="assignment" required>
                                @foreach ($assignments as $assignment)
                                    <option value="{{$assignment->idAssignment}}" {{$take->idAssignment == $assignment->idAssignment ? 'selected' : ''}}>{{$assignment->idAssignment}}, {{$assignment->name}}, {{formatDateThai($assignment->time)}} น., {{formatDateThai($assignment->date)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="date">วันที่:</label>
                                <input type="date" id="date" name="date" value="{{$take->date_take}}" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="time">เวลา:</label>
                            <input type="time" id="time" name="time" value="{{$take->time_take}}" class="form-control" required>
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
