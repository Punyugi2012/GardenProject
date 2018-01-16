@extends('layouts.app')
@section('title', 'รายการการมอบหมายงาน')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายการการมอบหมายงาน</h3>
        </div>
        <div class="card-body">
            <div>
                <a href="{{url('assignments/create')}}" class="btn btn-success">เพิ่มการมอบหมายงาน</a>
            </div>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การมอบหมายงาน</th>
                        <th>ประเภทของงาน</th>
                        <th>โซน</th>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th>จำนวนพนักงาน</th>
                        <th>สถานะ</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignments as $assignment)
                        <tr>
                            <td>{{$assignment->idAssignment}}</td>
                            <td class="text-primary"><b>{{$assignment->name}}</b></td>
                            <td>{{$assignment->idZone}}</td>
                            <td>{{formatDateThai($assignment->date)}}</td>
                            <td>{{formatDateThai($assignment->time)}} น.</td>
                            <td>{{$assignment->amount_employee}} คน</td>
                            <td>
                                @if ($assignment->status == 'success')
                                    <span class="text-success">เรียบร้อยแล้ว</span>
                                @elseif($assignment->status == 'unsuccess')
                                    <span class="text-warning">ยังไม่เรียบร้อย</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{url('/assignments/'.$assignment->idAssignment)}}" class="btn btn-info">พนักงาน</a>
                                <a href="{{url('/assignments/'.$assignment->idAssignment.'/edit')}}" class="btn btn-warning">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deleteAssignment{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                <div class="modal fade" id="deleteAssignment{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/assignments/'.$assignment->idAssignment)}}" method="POST">
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
            $('#table_id').DataTable({});
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