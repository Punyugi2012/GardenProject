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
            <table id="table_id" class="display">
                <thead>
                    <tr>
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
                            <td>{{$leave->name}}</td>
                            <td>{{$leave->surname}}</td>
                            <td>{{formatDateThai($leave->from_date)}}</td>
                            <td>{{formatDateThai($leave->to_date)}}</td>
                            <td>{{$leave->amount_day}} วัน</td>
                            <td>{{formatLeaveTypeThai($leave->type)}}</td>
                            <td>{{$leave->cause}}</td>
                            <td>
                                <a href="{{url('/leaves/'.$leave->idTakeLeave.'/edit')}}" class="btn btn-light">แก้ไข</a>
                                <form class="d-inline" action="{{url('/leaves/'.$leave->idTakeLeave)}}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-light">ลบ</a>
                                </form>
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