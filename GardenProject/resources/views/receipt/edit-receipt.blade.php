@extends('layouts.app')
@section('title', 'แก้ไขการรับวัตถุดิบ')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/purchases')}}">การสั่งซื้อ</a></li>
        <li class="breadcrumb-item"><a href='{{url("/receipts?purchase={$purchase->idPurchase}")}}'>การรับวัตถุดิบ</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขการรับวัตถุดิบ</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="card-header">
            <h3>แก้ไขการรับวัตถุดิบ</h3>
        </div>
        <div class="card-body">
            <form action='{{url("/receipts/{$receipt->idReceiving}")}}' method="POST" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">วันที่:</label>
                            <input type="date" id="date" name="date" class="form-control" value="{{$receipt->date}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="time">เวลา:</label>
                            <input type="time" id="time" name="time" class="form-control" value="{{$receipt->time}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="purchase">การสั่งซื้อ:</label>
                            <select class="custom-select form-control" id="purchase" name="purchase" required>
                                <option value="{{$purchase->idPurchase}}">เลขที่การสั่งซื้อ {{$purchase->idPurchase}}, เวลาสั่ง {{formatDateThai($purchase->date_order)}} น. วันที่สั่ง {{formatDateThai($purchase->time_order)}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                    <button type="reset" class="btn btn-warning">รีเซ็ต</button>
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