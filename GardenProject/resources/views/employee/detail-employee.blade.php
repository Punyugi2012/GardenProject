@extends('layouts.app')
@section('title', 'รายละเอียดพนักงาน')
@section('content')
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
            <hr>
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
            <table id="table_idFour" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การเบิก</th>
                        <th>เลขที่มอบหมายงาน</th>
                        <th>วันที่</th>
                        <th>เวลา</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($takes as $take)
                        <tr>
                            <td>{{$take->idTake}}</td>
                            <td>{{$take->idAssignment}}</td>
                            <td>{{formatDateThai($take->date_take)}}</td>
                            <td>{{formatDateThai($take->time_take)}} น.</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <h4>ประวัติการหักเงิน</h4>
            <table id="table_idFive" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่กาหักเงิน</th>
                        <th>วันที่</th>
                        <th>จำนวนเงินรวม (บาท)</th>
                        <th>เลขที่การเบิก</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deductions as $deduction)
                        <tr>
                            <td>{{$deduction->idDeduction}}</td>
                            <td>{{formatDateThai($deduction->date)}}</td>
                            <td>{{$deduction->total_money}}</td>
                            <td>{{$deduction->idTake}}</td>
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
        });
    </script>
@endsection