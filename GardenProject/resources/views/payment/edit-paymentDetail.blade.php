@extends('layouts.app')
@section('title', 'แก้ไขรายละเอียดการจ่ายเงิน')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>แก้ไขรายละเอียดการจ่ายเงิน</h3>
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
            <form action="{{url('/edit-payments_detail/'.$paymentDetail->idPayDetail.'/payment/'.$idPayment)}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT')}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount_money">จำนวนเงิน:</label>
                            <input type="number" step="any" class="form-control" id="amount_money" name="amount_money" value="{{$paymentDetail->amount_money}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purchase">การสั่งซื้อ:</label>
                            <select class="custom-select form-control" id="purchase" name="purchase" required>
                                @foreach ($purchases as $purchase)
                                    <option value="{{$purchase->idPurchase}}" {{$paymentDetail->idPurchase == $purchase->idPurchase ? 'selected' : ''}}>{{$purchase->idPurchase}}</option>
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
        </div>
    </div>
@endsection
@section('footer')
@if (session()->has('edited'))
<script type="text/javascript">
    swal({
        title: "<?php echo session()->get('edited'); ?>",
        text: "ผลการทำงาน",
        timer: 10000,
        type: 'success',
        showConfirmButton: false
    });
</script>
@endif
@endsection