@extends('layouts.app')
@section('title', 'การรับวัตถุดิบ')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/purchases')}}">การสั่งซื้อ</a></li>
        <li class="breadcrumb-item active" aria-current="page">การรับวัตถุดิบ</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>การรับวัตถุดิบ</h3>
        </div>
        <div class="card-body">
            @if (count($receipts) == 0)
                <div>
                    <a href='{{url("receipts/create?purchase={$purchase}")}}' class="btn btn-success">เพิ่มการรับวัตถุดิบ</a>
                </div>
            @endif
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การรับ</th>
                        <th>วันที่รับ</th>
                        <th>เวลารับ</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receipts as $receipt)
                        <tr>
                            <td>{{$receipt->idReceiving}}</td>
                            <td>{{formatDateThai($receipt->date)}}</td>
                            <td>{{formatDateThai($receipt->time)}} น.</td>
                            <td>
                                <a href='{{url("/receipts/{$receipt->idReceiving}?purchase={$purchase}")}}' class="btn btn-info">วัตถุดิบที่รับ</a>
                                <a href='{{url("/receipts/{$receipt->idReceiving}/edit?purchase={$purchase}")}}' class="btn btn-warning">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deleteReceipt{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                <div class="modal fade" id="deleteReceipt{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/receipts/'.$receipt->idReceiving)}}" method="POST">
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