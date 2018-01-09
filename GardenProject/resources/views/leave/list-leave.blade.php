@extends('layouts.app')
@section('title', 'รายการการลางาน')
@section('content')
 <div class="card" style="margin-top:10px">
     <div class="card-header">
         <h3>รายการการลางาน</h3>
     </div>
     <div class="card-body">
            <div>
                <a href="{{url('leaves/create')}}" class="btn btn-light">เพิ่มการลางาน</a>
            </div>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]'>
                <thead>
                    <tr>
                        <th>เลขที่การลา</th>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>จากวันที่</th>
                        <th>ถึงวันที่</th>
                        <th>จำนวน(วัน)</th>
                        <th>ประเภท</th>
                        <th>สาเหตุ</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaves as $leave)
                        <tr>
                            <td>{{$leave->idTakeLeave}}</td>
                            <td>{{$leave->name}}</td>
                            <td>{{$leave->surname}}</td>
                            <td>{{formatDateThai($leave->from_date)}}</td>
                            <td>{{formatDateThai($leave->to_date)}}</td>
                            <td>{{$leave->amount_day}} วัน</td>
                            <td>{{formatLeaveTypeThai($leave->type)}}</td>
                            <td>{{$leave->cause}}</td>
                            <td>
                                <a href="{{url('/leaves/'.$leave->idTakeLeave.'/edit')}}" class="btn btn-light">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deleteLeave{{$loop->index}}" class="btn btn-light">ลบ</button>
                                <div class="modal fade" id="deleteLeave{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/leaves/'.$leave->idTakeLeave)}}" method="POST">
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