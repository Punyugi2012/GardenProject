@extends('layouts.app')
@section('title', 'รายละเอียดการจ่ายเงิน')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายละเอียดการจ่ายเงิน</h3>
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
            <form action="{{url('/payments_detail/payment/'.$idPayment)}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount_money">จำนวนเงิน:</label>
                            <input type="number" step="any" class="form-control" id="amount_money" name="amount_money" placeholder="จำนวนเงิน" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purchase">การสั่งซื้อ:</label>
                            <select class="custom-select form-control" id="purchase" name="purchase" required>
                                <option value="">เลือกการสั่งซื้อ</option>
                                @foreach ($purchases as $purchase)
                                    <option value="{{$purchase->idPurchase}}">{{$purchase->idPurchase}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-light">บันทึก</button>
                    <button type="reset" class="btn btn-light">ล้าง</button>
                </div>
            </form>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่รายละเอียด</th>
                        <th>จำนวนเงิน</th>
                        <th>เลขที่การสั่งซ์้อ</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentsDetail as $paymentDetail)
                        <tr>
                            <td>{{$paymentDetail->idPayDetail}}</td>
                            <td>{{$paymentDetail->amount_money}}</td>
                            <td>{{$paymentDetail->idPurchase}}</td>
                            <td>
                                <button data-toggle="modal" data-target="#deletePaymentDetail{{$loop->index}}" class="btn btn-light">ลบ</button>
                                <div class="modal fade" id="deletePaymentDetail{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/payments_detail/'.$paymentDetail->idPayDetail.'/payment/'.$idPayment)}}" method="POST">
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