@extends('layouts.app')
@section('title', 'รายละเอียดพนักงาน')
@section('content')
    <style>
        h4 {
            margin-top: 100px;
        }
    </style>
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายละเอียดพนักงาน</h3>
        </div>
        <div class="card-body">
            <div class="text-center">
                <a href="{{ asset('images/'.$employee->profile_image) }}" data-lity>
                    <img class="rounded" src="{{asset('/images/'.$employee->profile_image)}}" style="width:200px;height:200px">
                </a>
            </div>
            <p>ชื่อ: {{$employee->name}}</p>
            <p>นามสกุล: {{$employee->surname}}</p>
            <p>เบอร์โทรศัพท์: {{$employee->phone}}<p>
            <p>สัญชาติ: {{formatNationalityThai($employee->nationality)}}</p>
            <p>วันที่เข้าทำงาน: {{formatDateThai($employee->date_worked)}}</p>
            <p>เงินเดือน: {{$employee->salary}} บาท</p>
            <p>เพศ: {{getGenderThai($employee->gender)}}</p>
            <h4>ประวัติการเข้าทำงาน</h4>
            <table id="table_idThree" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การลงเวลา</th>
                        <th>วันที่</th>
                        <th>เวลาเข้าทำงาน</th>
                        <th>เวลาออกงาน</th>
                        <th>จำนวนเวลา(ชม.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                        <tr>
                            <td>{{$attendance->idAttendance}}</td>
                            <td>{{formatDateThai($attendance->date)}}</td>
                            <td>{{formatDateThai($attendance->start_time)}} น.</td>
                            <td>{{formatDateThai($attendance->finish_time)}} น.</td>
                            <td>{{$attendance->amount_time}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <h4>ประวัติการจ่ายเงินเดือน</h4>
            <table id="table_idOne" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การจ่ายเงินเดือน</th>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th>จำนวนเงิน (บาท)</th>
                        <th>ค่าเสียหาย (บาท)</th>
                        <th>จำนวนเงินสุทธิ (บาท)</th>
                        <th>รอบ</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach ($salaries as $salary)
                    <tr>
                        <td>{{$salary->idSalary}}</td>
                        <td>{{formatDateThai($salary->date)}}</td>
                        <td>{{formatDateThai($salary->time)}} น.</td>
                        <td>{{$salary->amount_money}}</td>
                        <td>{{$salary->cost}}</td>
                        <td>{{$salary->rest_money}}</td>
                        <td>{{$salary->round}}</td>
                    </tr>
                   @endforeach
                </tbody>
            </table>
            <h4>ประวัติการลา</h4>
            <hr>
            <table id="table_idTwo" data-order='[[ 0, "desc" ]]'>
                <thead>
                    <tr>
                        <th>เลขที่การลา</th>
                        <th>จากวันที่</th>
                        <th>ถึงวันที่</th>
                        <th>จำนวน(วัน)</th>
                        <th>ประเภท</th>
                        <th>สาเหตุ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaves as $leave)
                        <tr>
                            <td>{{$leave->idTakeLeave}}</td>
                            <td>{{formatDateThai($leave->from_date)}}</td>
                            <td>{{formatDateThai($leave->to_date)}}</td>
                            <td>{{$leave->amount_day}} วัน</td>
                            <td>{{formatLeaveTypeThai($leave->type)}}</td>
                            <td>{{$leave->cause}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <h4>ประวัติการเบิก</h4>
            <table id="table_idFour" data-order='[[ 0, "desc" ]]'>
                <thead>
                    <tr>
                        <th>เลขที่การเบิก</th>
                        <th>วันที่เบิก</th>
                        <th>เวลาเบิก</th>
                        <th>เลขที่มอบหมายงาน</th>
                        <th>วันที่งาน</th>
                        <th>เวลางาน</th>
                        <th>งาน</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($takes as $take)
                        <tr>
                            <td>{{$take->idTake}}</td>
                            <td>{{formatDateThai($take->date_take)}}</td>
                            <td>{{formatDateThai($take->time_take)}} น.</td>
                            <td>{{$take->assignment->idAssignment}}</td>
                            <td>{{formatDateThai($take->assignment->date)}}</td>
                            <td>{{formatDateThai($take->assignment->time)}} น.</td>
                            <td>{{$take->assignment->name}}</td>
                            <td>
                                <a href="{{url('/employees/take_detail/take/'.$take->idTake)}}" class="btn btn-light">รายละเอียด</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <h4>ประวัติการคืน</h4>
            <table id="table_idSix" data-order='[[ 0, "desc" ]]'>
                <thead>
                    <tr>
                        <th>เลขที่การคืน</th>
                        <th>วันที่คืน</th>
                        <th>เวลาคืน</th>
                        <th>เลขที่การเบิก</th>
                        <th>วันที่เบิก</th>
                        <th>เวลาเบิก</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($returnings as $returning)
                        <tr>
                            <td>{{$returning->idReverting}}</td>
                            <td>{{formatDateThai($returning->date)}}</td>
                            <td>{{formatDateThai($returning->time)}} น.</td>
                            <td>{{$returning->idTake}}</td>
                            <td>{{formatDateThai($returning->date_take)}}</td>
                            <td>{{formatDateThai($returning->time_take)}} น.</td>
                            <td>
                                <a href="{{url('/employees/returning_detail/returning/'.$returning->idReverting)}}" class="btn btn-light">รายละเอียด</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <h4>ประวัติการหักเงิน</h4>
            <table id="table_idFive" data-order='[[ 0, "desc" ]]'>
                <thead>
                    <tr>
                        <th>เลขที่กาหักเงิน</th>
                        <th>วันที่</th>
                        <th>จำนวนเงินรวม (บาท)</th>
                        <th>เลขที่การเบิก</th>
                        <th>วันที่เบิก</th>
                        <th>เวลาเบิก</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deductions as $deduction)
                        <tr>
                            <td>{{$deduction->idDeduction}}</td>
                            <td>{{formatDateThai($deduction->date)}}</td>
                            <td>{{$deduction->total_money}}</td>
                            <td>{{$deduction->idTake}}</td>
                            <td>{{formatDateThai($deduction->date_take)}}</td>
                            <td>{{formatDateThai($deduction->time_take)}} น.</td>
                            <td>
                                <a href="{{url('/employees/deduction_detail/deduction/'.$deduction->idDeduction)}}" class="btn btn-light">รายละเอียด</a>
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
            $('#table_idOne').DataTable();
            $('#table_idTwo').DataTable();
            $('#table_idThree').DataTable();
            $('#table_idFour').DataTable();
            $('#table_idFive').DataTable();
            $('#table_idSix').DataTable();
        });
    </script>
@endsection