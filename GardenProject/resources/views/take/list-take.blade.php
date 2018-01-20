@extends('layouts.app')
@section('title', 'รายการการเบิกอุปกรณ์')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item active" aria-current="page">เบิกอุปกรณ์</li>
    </ol>
</nav>
@endsection
@section('content')
 <div class="card" style="margin-top:10px">
     <div class="card-header">
         <h3>รายการการเบิกอุปกรณ์</h3>
     </div>
     <div class="card-body">
            <div>
                <a href="{{url('takes/create')}}" class="btn btn-success">เพิ่มการเบิก</a>
            </div>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การเบิก</th>
                        <th class="bg-primary text-light">ชื่อ-สกุลพนักงาน</th>
                        <th>เลขที่มอบหมายงาน</th>
                        <th class="bg-info text-light">งาน</th>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th>สถานะ</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($takes as $take)
                        <tr>
                            <td>{{$take->idTake}}</td>
                            <td class="text-primary">{{$take->name}} {{$take->surname}}</td>
                            <td>{{$take->idAssignment}}</td>
                            <td class="text-info">{{$take->assignment_name}}</td>
                            <td>{{formatDateThai($take->date_take)}}</td>
                            <td>{{formatDateThai($take->time_take)}} น.</td>
                            <td>
                                @if ($take->status_returning == 'fully')
                                    <a href='{{url("/returnings?take={$take->idTake}")}}' class="btn btn-success">คืนครบแล้ว</a>
                                @elseif($take->status_returning == 'unfully')
                                    <a href='{{url("/returnings?take={$take->idTake}")}}' class="btn btn-danger">ยังคืนไม่ครบ</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{url('/takes/'.$take->idTake)}}" class="btn btn-info">อุปกรณ์ที่เบิก</a>
                                <a href="{{url('/takes/'.$take->idTake.'/edit')}}" class="btn btn-warning">แก้ไข</a>
                                @if ($take->canDelete)
                                    <button data-toggle="modal" data-target="#deleteTake{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                    <div class="modal fade" id="deleteTake{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title">ยืนยันการลบ</h2>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{url('/takes/'.$take->idTake)}}" method="POST">
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
                                @endif
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