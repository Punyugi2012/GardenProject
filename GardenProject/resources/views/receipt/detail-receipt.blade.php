@extends('layouts.app')
@section('title', 'วัตถุดิบที่รับ')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/purchases')}}">การสั่งซื้อ</a></li>
        <li class="breadcrumb-item"><a href='{{url("/receipts?purchase={$purchase}")}}'>การรับวัตถุดิบ</a></li>
        <li class="breadcrumb-item active" aria-current="page">วัตถุดิบที่รับ</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>วัตถุดิบที่รับ</h3>
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
            <form action='{{url("/receipt_detail/receipt/{$idReceipt}?purchase={$purchase}")}}' method="POST" autocomplete="off">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">จำนวน:</label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="จำนวนวัตถุดิบ" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="item">วัตถุดิบ</label>
                        <select class="custom-select form-control" id="item" name="item" required>
                            <option value="">เลือกวัตถุดิบ</option>
                            @foreach ($purchasesDetail as $detail)
                                <option value="{{$detail->idItem}}">{{$detail->name}}, จำนวนที่สั่ง {{$detail->amount}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success">บันทึก</button>
                    <button type="reset" class="btn btn-warning">รีเซ็ต</button>
                </div>
            </form>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่รายละเอียด</th>
                        <th class="bg-primary text-light">ชื่อวัตถุดิบ</th>
                        <th class="bg-info text-light">จำนวน</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($receiptsDetail as $receiptDetail)
                        <tr>
                            <td>{{$receiptDetail->idReceivingDetail}}</td>
                            <td class="text-primary">
                                {{$receiptDetail->name}}                       
                            </td>
                            <td class="text-info">{{$receiptDetail->amount}}</td>
                            <td>
                                <button data-toggle="modal" data-target="#deleteReceiptDetail{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                <div class="modal fade" id="deleteReceiptDetail{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action='{{url("/receipt_detail/{$receiptDetail->idReceivingDetail}/receipt/{$idReceipt}?purchase={$purchase}")}}' method="POST">
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