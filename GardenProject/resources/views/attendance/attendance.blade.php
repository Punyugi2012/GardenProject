@extends('layouts.app')
@section('title', 'การลงเวลาทำงาน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item active" aria-current="page">การลงเวลาทำงาน</li>
    </ol>
</nav>
@endsection
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="employee">พนักงาน:</label>
                            <select class="custom-select form-control" name="employee" id="employee" required>
                                <option value="" selected>เลือกพนักงาน</option>
                                @foreach ($employees as $employee)
                                    <option value="{{$employee->idEmployee}}">{{$employee->name}}-{{$employee->surname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="date">วันที่:</label>
                        <input type="date" id="date" name="date" class="form-control" required>
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
                    <button type="submit" class="btn btn-primary">ยืนยัน</button>
                    <button type="reset" class="btn btn-warning">รีเซ็ต</button>
                </div>
            </form>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การลงเวลา</th>
                        <th>วันที่</th>
                        <th class="bg-info text-light">ชื่อ-สกุลพนักงาน</th>
                        <th>เวลาเข้าทำงาน</th>
                        <th>เวลาออกงาน</th>
                        <th class="bg-primary text-light">จำนวนเวลา(ชม.)</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="7" style="text-align:right"></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($attendances as $attendance)
                        <tr>
                            <td>{{$attendance->idAttendance}}</td>
                            <td>{{formatDateThai($attendance->date)}}</td>
                            <td class="text-info">{{$attendance->name}} {{$attendance->surname}}</td>
                            <td>{{formatDateThai($attendance->start_time)}} น.</td>
                            <td>{{formatDateThai($attendance->finish_time)}} น.</td>
                            <td class="text-primary">{{$attendance->amount_time}}</td>
                            <td>
                                <a href="{{url('/attendances/'.$attendance->idAttendance.'/edit')}}" class="btn btn-warning">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deleteAttendance{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                <div class="modal fade" id="deleteAttendance{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/attendances/'.$attendance->idAttendance)}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
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
            $('#table_id').DataTable({
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
         
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
         
                    // Total over all pages
                    total = api
                        .column( 5 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
         
                    // Total over this page
                    pageTotal = api
                        .column( 5, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
         
                    // Update footer
                    $( api.column( 5 ).footer() ).html(
                       'รวมจำนวนเวลา: ' + pageTotal +' ชม. (ทั้งหมด '+ total +' ชม.)'
                    );
                }
            });
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