@extends('layouts.app')
@section('title', 'รายการรับวัตถุดิบจากการเคลม')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/purchases')}}">การสั่งซื้อ</a></li>
        <li class="breadcrumb-item"><a href='{{url("/claims?purchase={$purchase}")}}'>การเคลม</a></li>
        <li class="breadcrumb-item active" aria-current="page">รับวัตถุดิบจากการเคลม</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายการรับวัตถุดิบจากการเคลม</h3>
        </div>
        <div class="card-body">
            <div>
                <a href='{{url("receiptclaims/create?claim={$claim}&purchase={$purchase}")}}' class="btn btn-success">เพิ่มการรับจากการเคลม</a>
            </div>
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
                    @foreach ($receiptclaims as $receiptclaim)
                        <tr>
                            <td>{{$receiptclaim->idReceivingClaim}}</td>
                            <td>{{formatDateThai($receiptclaim->date)}}</td>
                            <td>{{formatDateThai($receiptclaim->time)}} น.</td>
                            <td>
                                <a href='{{url("/receiptclaims/{$receiptclaim->idReceivingClaim}?claim={$claim}&purchase={$purchase}")}}' class="btn btn-info">วัตถุดิบที่รับ</a>
                                <a href='{{url("/receiptclaims/{$receiptclaim->idReceivingClaim}/edit?claim={$claim}&purchase={$purchase}")}}' class="btn btn-warning">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deleteReceiptclaim{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                <div class="modal fade" id="deleteReceiptclaim{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action='{{url("/receiptclaims/{$receiptclaim->idReceivingClaim}?claim={$claim}&purchase={$purchase}")}}' method="POST">
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