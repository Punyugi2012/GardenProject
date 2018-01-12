@extends('layouts.app')
@section('title', 'แก้ไขผลผลิต')
@section('content')
<div class="card" style="margin-top:10px">
    <div class="card-header">
        <h3>แก้ไขผลผลิต</h3>
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
        <form action="{{url('/products/'.$product->idProduct)}}" method="POST" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">ชื่อ:</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{$product->name}}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price_per_product">ราคาต่อกิโลกรัม (บาท):</label>
                        <input type="number" step=any id="price_per_product" name="price_per_product" class="form-control" value="{{$product->price_per_product}}" required>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-light">ยืนยัน</button>
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