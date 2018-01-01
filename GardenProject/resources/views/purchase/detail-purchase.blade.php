@extends('layouts.app')
@section('title', 'รายละเอียดการสั่งซื้อ')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายละเอียดการสั่งซื้อ</h3>
        </div>
        <div class="card-body">
            <form action="{{url('/purchases_detail/purchase/'.$purchase->idPurchase)}}" method="POST" autocomplete="off">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">จำนวน:</label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="จำนวน" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="item">วัตถุดิบ:</label>
                        <select class="custom-select form-control" id="item" name="item" required>
                            <option value="">เลือกวัตถุดิบ</option>
                            @foreach ($items as $item)
                                <option value="{{$item->idItem}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-light">บันทึก</button>
                    <button type="reset" class="btn btn-light">ล้าง</button>
                </div>
            </form>
            <br>
            <table id="table_id" class="display">
                <thead>
                    <tr>
                        <td>ชื่อวัตถุดิบ</td>
                        <td>จำนวน</td>
                        <td>จำนวนเงินรวม</td>
                        <td>เครื่องมือ</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchasesDetail as $purchaseDetail)
                        <tr>
                            <td>{{$purchaseDetail->name}}</td>
                            <td>{{$purchaseDetail->amount}}</td>
                            <td>{{$purchaseDetail->total_money}}</td>
                            <td>
                                <a href="#" class="btn btn-light">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deletePurchaseDetail{{$loop->index}}" class="btn btn-light">ลบ</button>
                                <div class="modal fade" id="deletePurchaseDetail{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/purchases_detail/'.$purchaseDetail->idPurchaseDetail.'/purchase/'.$purchase->idPurchase)}}" method="POST">
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