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
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่พนักงาน</th>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>เบอร์โทรศัพท์</th>
                        <th>เพศ</th>
                        <th>สัญชาติ</th>
                        <th>วันที่เริ่มทำงาน</th>
                        <th>รูปประจำตัว</th>
                        <th>เงินเดือน (บาท)</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{$employee->idEmployee}}</td>
                            <td>{{$employee->name}}</td>
                            <td>{{$employee->surname}}</td>
                            <td>{{$employee->phone}}</td>
                            <td>{{getGenderThai($employee->gender)}}</td>
                            <td>{{formatNationalityThai($employee->nationality)}}</td>
                            <td>{{formatDateThai($employee->date_worked)}}</td>
                            <td>
                                <a href="{{ asset('images/'.$employee->profile_image) }}" data-lity>
                                    <img src="{{ asset('images/resize/'.$employee->profile_image) }}" style="width:50px;height:50px">
                                </a>
                            </td>
                            <td>{{$employee->salary}}</td>
                            <td>
                                <a href="#" class="btn btn-light">ดูรายละเอียด</a>
                                <a href="{{url('employees/'.$employee->idEmployee.'/edit')}}" class="btn btn-light">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deleteEmployee{{$loop->index}}" class="btn btn-light">ลบ</button>
                                <div class="modal fade" id="deleteEmployee{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/employees/'.$employee->idEmployee)}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
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
    @elseif(session()->has('deleted'))
        <script type="text/javascript">
            swal({
                title: "<?php echo session()->get('deleted'); ?>",
                text: "ผลการทำงาน",
                timer: 10000,
                type: 'success',
                showConfirmButton: false
            });
        </script>
    @endif
@endsection