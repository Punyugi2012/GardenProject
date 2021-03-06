@extends('layouts.app')
@section('title', 'แก้ไขการมอบหมายงาน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/assignments')}}">การมอบหมายงาน</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขการมอบหมายงาน</li>
    </ol>
</nav>
@endsection
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
            <a href="{{url('/assignmentTypes')}}" class="btn btn-success">เพิ่มประเภทมอบหมายงาน</a>
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
                            <label for="status">สถานะ:</label>
                            <select class="custom-select form-control" id="status" name="status" required>
                                <option value="success" {{$assignment->status == 'success' ? 'selected' : ''}}>เรียบร้อยแล้ว</option>
                                <option value="unsuccess" {{$assignment->status == 'unsuccess' ? 'selected' : ''}}>ยังไม่เรียบร้อยแล้ว</option>
                            </select>
                        </div>
                    </div>
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