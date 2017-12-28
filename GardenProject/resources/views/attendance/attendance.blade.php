@extends('layouts.app')
@section('title', 'การลงเวลาทำงาน')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>การลงเวลาทำงาน</h3>
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
            <form action="{{url('/attendances')}}" method="POST" autocomplete="off"> 
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">วันที่:</label>
                            <input type="date" id="date" name="date" value="{{$today}}" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="employee">ชื่อ-นามสกุล:</label>
                        <select class="custom-select form-control" name="employee" id="employee" required>
                            <option value="" selected>เลือกชื่อ-นามสกุล</option>
                            @foreach ($employees as $employee)
                                <option value="{{$employee->idEmployee}}">{{$employee->name}}-{{$employee->surname}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_time">เวลาเข้าทำงาน:</label>
                            <input type="time" id="start_time" name="start_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="finish_time">เวลาออกทำงาน:</label>
                            <input type="time" id="finish_time" name="finish_time" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-light">ยืนยัน</button>
                </div>
            </form>
            <br>
            <table id="table_id" class="display">
                <thead>
                    <tr>
                        <th>วันที่</th>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>เวลาเข้าทำงาน</th>
                        <th>เวลาออกงาน</th>
                        <th>จำนวนเวลา(ชม.)</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                        <tr>
                            <td>{{formatDateThai($attendance->date)}}</td>
                            <td>{{$attendance->name}}</td>
                            <td>{{$attendance->surname}}</td>
                            <td>{{formatDateThai($attendance->start_time)}} น.</td>
                            <td>{{formatDateThai($attendance->finish_time)}} น.</td>
                            <td>{{$attendance->amount_time}} ชม.</td>
                            <td>
                                <form class="d-inline">
                                    <a href="#" class="btn btn-light">ลบ</a>
                                </form>
                                <a href="{{url('/attendances/'.$attendance->idAttendance.'/edit')}}" class="btn btn-light">แก้ไข</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('footer')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#table_id').DataTable();
        });
    </script>
@endsection