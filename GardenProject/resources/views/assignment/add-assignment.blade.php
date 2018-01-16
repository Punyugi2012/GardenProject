@extends('layouts.app')
@section('title', 'เพิ่มการมอบหมายงาน')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>เพิ่มการมอบหมายงาน</h3>
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
            <form action="{{url('/assignments')}}" method="POST" autocomplete="off">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">ประเภทมอบหมายงาน:</label>
                            <select class="custom-select form-control" id="type" name="type" required>
                                <option value="">เลือกประเภทมอบหมายงาน</option>
                                @foreach ($assignmentTypes as $type)
                                    <option value="{{$type->idAssignmentType}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="zone">โซน:</label>
                            <select class="custom-select form-control" id="zone" name="zone" required>
                                <option value="">เลือกโซน</option>
                                @foreach ($zones as $zone)
                                    <option value="{{$zone->idZone}}">{{$zone->idZone}}</option>
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
                            <label for="status">สถานะ:</label>
                            <select class="custom-select form-control" id="status" name="status" required>
                                <option value="success">เรียบร้อยแล้ว</option>
                                <option value="unsuccess" selected>ยังไม่เรียบร้อยแล้ว</option>
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