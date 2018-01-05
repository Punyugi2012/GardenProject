@extends('layouts.app')
@section('title', 'แก้ไขการมอบหมายงาน')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>แก้ไขการมอบหมายงาน</h3>
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
            <a href="{{url('/assignmentTypes')}}" class="btn btn-light">เพิ่มประเภทมอบหมายงาน</a>
            <br><br>
            <form action="{{url('/assignments/'.$assignment->idAssignment)}}" method="POST" autocomplete="off">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">ประเภทมอบหมายงาน:</label>
                            <select class="custom-select form-control" id="type" name="type" required>
                                @foreach ($assignmentTypes as $type)
                                    <option value="{{$type->idAssignmentType}}" {{$assignment->idAssignmentType == $type->idAssignmentType ? 'selected' : ''}}>{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone">โซน:</label>
                            <select class="custom-select form-control" id="zone" name="zone" required>
                                @foreach ($zones as $zone)
                                    <option value="{{$zone->idZone}}" {{$assignment->idZone == $zone->idZone ? 'selected' : ''}}>{{$zone->idZone}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">วันที่:</label>
                            <input type="date" id="date" name="date" value="{{$assignment->date}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="time">เวลา:</label>
                            <input type="time" id="time" name="time" value="{{$assignment->time}}"  class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amount">จำนวนพนักงาน:</label>
                            <input type="number" id="amount" name="amount" value="{{$assignment->amount_employee}}"  class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-light">บันทึก</button>
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