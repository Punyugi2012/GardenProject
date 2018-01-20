@extends('layouts.app')
@section('title', 'รายละเอียดพนักงาน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/employees')}}">พนักงาน</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายละเอียดพนักงาน</li>
    </ol>
</nav>
@endsection
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
                        <th class="bg-info text-light">เวลาเข้าทำงาน</th>
                        <th class="bg-info text-light">เวลาออกงาน</th>
                        <th class="bg-primary text-light">จำนวนเวลา(ชม.)</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="5" style="text-align:right" class="text-success"></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($attendances as $attendance)
                        <tr>
                            <td>{{$attendance->idAttendance}}</td>
                            <td>{{formatDateThai($attendance->date)}}</td>
                            <td class="text-info">{{formatDateThai($attendance->start_time)}} น.</td>
                            <td class="text-info">{{formatDateThai($attendance->finish_time)}} น.</td>
                            <td class="text-primary">{{$attendance->amount_time}}</td>
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
                        <th class="bg-danger text-light">ค่าเสียหาย (บาท)</th>
                        <th class="bg-primary text-light">จำนวนเงินสุทธิ (บาท)</th>
                        <th>รอบ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="7" style="text-align:right" class="text-success"></th>
                    </tr>
                </tfoot>
                <tbody>
                   @foreach ($salaries as $salary)
                    <tr>
                        <td>{{$salary->idSalary}}</td>
                        <td>{{formatDateThai($salary->date)}}</td>
                        <td>{{formatDateThai($salary->time)}} น.</td>
                        <td>{{$salary->amount_money}}</td>
                        <td class="text-danger">{{$salary->cost}}</td>
                        <td class="text-primary">{{$salary->rest_money}}</td>
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
                        <th class="bg-primary text-light">จำนวน(วัน)</th>
                        <th class="bg-info text-light">ประเภท</th>
                        <th>สาเหตุ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="6" style="text-align:right" class="text-success"></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($leaves as $leave)
                        <tr>
                            <td>{{$leave->idTakeLeave}}</td>
                            <td>{{formatDateThai($leave->from_date)}}</td>
                            <td>{{formatDateThai($leave->to_date)}}</td>
                            <td class="text-primary">{{$leave->amount_day}}</td>
                            <td class="text-info">{{formatLeaveTypeThai($leave->type)}}</td>
                            <td>{{$leave->cause}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <h4>ประวัติการมอบหมายงาน</h4>
            <table id="table_idSeven" data-order='[[ 0, "desc" ]]'>
                <thead>
                    <tr>
                        <th>เลขที่มอบหมายงาน</th>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th class="bg-primary text-light">งาน</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignments as $assignment)
                        <tr>
                            <td>{{$assignment->idAssignment}}</td>
                            <td>{{formatDateThai($assignment->date)}}</td>
                            <td>{{formatDateThai($assignment->time)}}</td>
                            <td class="text-primary">{{$assignment->name}}</td>
                            <td>
                                @if ($assignment->status == 'success')
                                    <span class="text-success">เรียบร้อยแล้ว</span>
                                @else
                                    <span class="text-danger">ยังไม่เรียบร้อย</span>
                                @endif
                            </td>
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
                        <th class="bg-info text-light">เลขที่มอบหมายงาน</th>
                        <th class="bg-primary text-light">งาน</th>
                        <th>วันที่งาน</th>
                        <th>เวลางาน</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($takes as $take)
                        <tr>
                            <td>{{$take->idTake}}</td>
                            <td>{{formatDateThai($take->date_take)}}</td>
                            <td>{{formatDateThai($take->time_take)}} น.</td>
                            <td class="text-info">{{$take->assignment->idAssignment}}</td>
                            <td class="text-primary">{{$take->assignment->name}}</td>
                            <td>{{formatDateThai($take->assignment->date)}}</td>
                            <td>{{formatDateThai($take->assignment->time)}} น.</td>
                            <td>
                                <a href='{{url("/employees/take_detail/take/{$take->idTake}?employee={$idEmployee}")}}' class="btn btn-info">รายละเอียด</a>
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
                        <th class="bg-primary text-light">เลขที่การเบิก</th>
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
                            <td class="text-primary">{{$returning->idTake}}</td>
                            <td>{{formatDateThai($returning->date_take)}}</td>
                            <td>{{formatDateThai($returning->time_take)}} น.</td>
                            <td>
                                <a href='{{url("/employees/returning_detail/returning/{$returning->idReverting}?employee={$idEmployee}")}}' class="btn btn-info">รายละเอียด</a>
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
                        <th>เลขที่การหักเงิน</th>
                        <th>วันที่</th>
                        <th class="bg-primary text-light">จำนวนเงินรวม (บาท)</th>
                        <th>เลขที่การเบิก</th>
                        <th>วันที่เบิก</th>
                        <th>เวลาเบิก</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="7" style="text-align:right" class="text-success"></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($deductions as $deduction)
                        <tr>
                            <td>{{$deduction->idDeduction}}</td>
                            <td>{{formatDateThai($deduction->date)}}</td>
                            <td class="text-primary">{{$deduction->total_money}}</td>
                            <td>{{$deduction->idTake}}</td>
                            <td>{{formatDateThai($deduction->date_take)}}</td>
                            <td>{{formatDateThai($deduction->time_take)}} น.</td>
                            <td>
                                <a href='{{url("/employees/deduction_detail/deduction/{$deduction->idDeduction}?employee={$idEmployee}")}}' class="btn btn-info">รายละเอียด</a>
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
            $('#table_idOne').DataTable({
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    total = api
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    pageTotal = api
                        .column( 5, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    $( api.column( 5 ).footer() ).html(
                       'รวมเงินสุทธิ: ' + pageTotal +' บาท (ทั้งหมด '+ total +' บาท)'
                    );
                }
            });
            $('#table_idTwo').DataTable({
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    total = api
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    pageTotal = api
                        .column( 3, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    $( api.column( 3 ).footer() ).html(
                       'รวมจำนวนวัน: ' + pageTotal +' วัน (ทั้งหมด '+ total +' วัน)'
                    );
                }
            });
            $('#table_idThree').DataTable({
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    total = api
                        .column( 4 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    pageTotal = api
                        .column( 4, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    $( api.column( 4 ).footer() ).html(
                       'จำนวนเงินรวม: ' + pageTotal +' บาท (ทั้งหมด '+ total +' บาท)'
                    );
                }
            });
            $('#table_idFour').DataTable();
            $('#table_idFive').DataTable({
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    total = api
                        .column( 2 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    pageTotal = api
                        .column( 2, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    $( api.column( 2 ).footer() ).html(
                       'จำนวนเงินรวม: ' + pageTotal +' บาท (ทั้งหมด '+ total +' บาท)'
                    );
                }
            });
            $('#table_idSix').DataTable();
            $('#table_idSeven').DataTable();
        });
    </script>
@endsection