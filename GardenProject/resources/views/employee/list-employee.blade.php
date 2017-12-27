@extends('layouts.app')
@section('title', 'รายการพนักงาน')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายการพนักงาน</h3>
        </div>
        <div class="card-body">
            <div>
                <a href="{{url('employees/create')}}" class="btn btn-light">เพิ่มพนักงาน</a>
            </div>
            <br>
            <table id="table_id" class="display">
                <thead>
                    <tr>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>เบอร์โทรศัพท์</th>
                        <th>เพศ</th>
                        <th>สัญชาติ</th>
                        <th>วันที่เริ่มทำงาน</th>
                        <th>รูปประจำตัว</th>
                        <th>เงินเดือน</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{$employee->name}}</td>
                            <td>{{$employee->surname}}</td>
                            <td>{{$employee->phone}}</td>
                            <td>{{$employee->gender}}</td>
                            <td>{{$employee->nationality}}</td>
                            <td>{{formatDateThai($employee->date_worked)}}</td>
                            <td>
                                <a href="{{ asset('images/'.$employee->profile_image) }}" data-lity>
                                    <img src="{{ asset('images/resize/'.$employee->profile_image) }}" style="width:50px;height:50px">
                                </a>
                            </td>
                            <td>{{$employee->salary}}</td>
                            <td>
                                <a href="{{url('employees/'.$employee->idEmployee.'/edit')}}" class="btn btn-light">แก้ไข</a>
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
@if (session()->has('added'))
    <script type="text/javascript">
        swal({
            title: "<?php echo session()->get('added'); ?>",
            text: "ผลการทำงาน",
            timer: 10000,
            type: 'success',
            showConfirmButton: false
        });
    </script>
 @endif
@endsection