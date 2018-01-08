@extends('layouts.app')
@section('title', 'แก้ไขรายละเอียดการขาย')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>แก้ไขรายละเอียดการขาย</h3>
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
            <form action="{{url('/edit-sales_detail/'.$saleDetail->idSaleDetail.'/sale/'.$idSale)}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product">ผลผลิต</label>
                            <select class="custom-select form-control" id="product" name="product" required>
                                @foreach ($products as $product)
                                    <option value="{{$product->idProduct}}" {{$saleDetail->idProduct == $product->idProduct ? 'selected' : ''}}>{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">จำนวน (กิโลกรัม):</label>
                            <input type="number" id="amount" name="amount" class="form-control" value="{{$saleDetail->amount}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="total_price">ราคารวม (บาท):</label>
                            <input type="number" step="any" id="total_price" name="total_price" class="form-control" value="{{$saleDetail->total_price}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price_per_product">ราคาต่อหน่วย (บาท):</label>
                            <input type="number" step="any" id="price_per_product" name="price_per_product" class="form-control" value="{{$saleDetail->price_per_product}}"required>
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