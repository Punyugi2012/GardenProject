@extends('layouts.app')
@section('title', 'รายการการคืนอุปกรณ์')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href='{{url("/takes")}}'>เบิกอุปกรณ์</a></li>
        <li class="breadcrumb-item active" aria-current="page">การคืนอุปกรณ์</li>
    </ol>
</nav>
@endsection
@section('content')
 <div class="card" style="margin-top:10px">
     <div class="card-header">
         <h3>รายการการคืนอุปกรณ์</h3>
     </div>
     <div class="card-body">
            @if ($status == 'unfully')
                <div>
                    <a href='{{url("returnings/create?take={$take}")}}' class="btn btn-success">เพิ่มการคืน</a>
                </div>
                <br>
            @endif
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การคืน</th>
                        <th class="bg-primary text-light">ชื่อ-สกุลพนักงาน</th>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($returnings as $returning)
                        <tr>
                            <td>{{$returning->idReverting}}</td>
                            <td class="text-primary">{{$returning->name}} {{$returning->surname}}</td>
                            <td>{{formatDateThai($returning->date)}}</td>
                            <td>{{formatDateThai($returning->time)}} น.</td>
                            <td>
                                <a href='{{url("/returnings/$returning->idReverting?take={$take}")}}' class="btn btn-info">อุปกรณ์ที่คืน</a>
                                <a href='{{url("/returnings/{$returning->idReverting}/edit?take={$take}")}}' class="btn btn-warning">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deleteReturning{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                <div class="modal fade" id="deleteReturning{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action='{{url("/returnings/{$returning->idReverting}?take={$take}")}}' method="POST">
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