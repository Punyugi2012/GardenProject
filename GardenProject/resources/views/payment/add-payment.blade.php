@extends('layouts.app')
@section('title', 'เพิ่มการจ่ายเงิน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/payments')}}">การจ่ายเงิน</a></li>
        <li class="breadcrumb-item active" aria-current="page">เพิ่มการจ่ายเงิน</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>เพิ่มการจ่ายเงิน</h3>
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
            <form action="{{url('/payments')}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="shop">ร้านค้า:</label>
                    <select class="custom-select form-control" name="shop" id="shop" required>
                        <option value="">เลือกร้านค้า</option>
                        @foreach ($shops as $shop)
                            <option value="{{$shop->idShop}}">{{$shop->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">วันที่:</label>
                            <input type="date" id="date" name="date" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="time">เวลา:</label>
                            <input type="time" id="time" name="time" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="type">ประเภท:</label>
                            <select class="custom-select form-control" name="type" id="type" required>
                                <option value="">เลือกประเภท</option>
                                <option value="alienate">โอนเงิน</option>
                                <option value="normal">ปกติ</option>
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