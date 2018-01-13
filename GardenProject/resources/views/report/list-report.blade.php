@extends('layouts.app')
@section('title', 'รายการการรายงาน')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายการการรายงาน</h3>
        </div>
        <div class="card-body">
            <div>
                <a href="{{url('reports/create')}}" class="btn btn-light">เพิ่มการรายงาน</a>
            </div>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การรายงาน</th>
                        <th>ชื่อ-สกุลพนักงาน</th>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th>เลขที่การมอบหมายงาน</th>
                        <th>รายละเอียด</th>
                        <th>ประเภท</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr>
                            <td>{{$report->idReport}}</td>
                            <td>{{$report->name}} {{$report->surname}}</td>
                            <td>{{formatDateThai($report->date)}}</td>
                            <td>{{formatDateThai($report->time)}} น.</td>
                            <td>{{$report->idAssignment}}</td>
                            <td>{{$report->detail}}</td>
                            <td>
                                @if ($report->type == 'permission')
                                    ขออนุญาติเบิกเครื่องตัดหญ้า
                                @elseif($report->type == 'report')
                                    รายงาน
                                @endif
                            </td>
                            <td>
                                <a href="{{url('/reports/'.$report->idReport)}}" class="btn btn-light">รายละเอียด</a>
                                <a href="{{url('/reports/'.$report->idReport.'/edit')}}" class="btn btn-light">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deleteReport{{$loop->index}}" class="btn btn-light">ลบ</button>
                                <div class="modal fade" id="deleteReport{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/reports/'.$report->idReport)}}" method="POST">
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