@extends('layouts.app')
@section('title', 'รายการการเก็บเกี่ยว')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item active" aria-current="page">การเก็บเกี่ยว</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายการการเก็บเกี่ยว</h3>
        </div>
        <div class="card-body">
            <div>
                <a href="{{url('/harvests/create')}}" class="btn btn-success">เพิ่มการเก็บเกี่ยว</a>
            </div>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การเก็บเกี่ยว</th>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th>ผลผลิต</th>
                        <th>จำนวนผลผลิต (กิโลกรัม)</th>
                        <th>เลขที่การมอบหมายงาน</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($harvests as $harvest)
                        <tr>
                            <td>{{$harvest->idHarvest}}</td>
                            <td>{{formatDateThai($harvest->date_harvest)}}</td>
                            <td>{{formatDateThai($harvest->time_harvest)}} น.</td>
                            <td>{{$harvest->name}}</td>
                            <td>{{$harvest->amount}}</td>
                            <td>{{$harvest->idAssignment}}</td>
                            <td>
                                <a href="{{url('/harvests/'.$harvest->idHarvest.'/edit')}}" class="btn btn-warning">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deleteHarvest{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                <div class="modal fade" id="deleteHarvest{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/harvests/'.$harvest->idHarvest)}}" method="POST">
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