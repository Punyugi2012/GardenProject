@extends('layouts.app')
@section('title', 'เพิ่มวัตถุดิบ')
@section('content')
<div class="card" style="margin-top:10px">
    <div class="card-header">
        <h3>เพิ่มวัตถุดิบ</h3>
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
        <form action="{{url('/products')}}" method="POST" autocomplete="off">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">ชื่อ:</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="ชื่อวัตถุดิบ" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="price_per_product">ราคาต่อหน่วย:</label>
                        <input type="number" step=any id="price_per_product" name="price_per_product" class="form-control" placeholder="ราคาต่อหน่วย" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="amount_stock">จำนวนในสต็อค:</label>
                        <input type="number" id="amount_stock" name="amount_stock" class="form-control" placeholder="จำนวนในสต็อค" required>
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