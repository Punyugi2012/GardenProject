@extends('layouts.app')
@section('title', 'เพิ่มวัตถุดิบ')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/products')}}">ผลผลิต</a></li>
        <li class="breadcrumb-item active" aria-current="page">เพิ่มวัตถุดิบ</li>
    </ol>
</nav>
@endsection
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">ชื่อ:</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="ชื่อวัตถุดิบ" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price_per_product">ราคาต่อกิโลกรัม (บาท):</label>
                        <input type="number" step=any id="price_per_product" name="price_per_product" class="form-control" placeholder="ราคาต่อหน่วย" required>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">ยืนยัน</button>
                <button type="reset" class="btn btn-warning">รีเซ็ต</button>
            </div>
        </form>
    </div>
</div>
@endsection