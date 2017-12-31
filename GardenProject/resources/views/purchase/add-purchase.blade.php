@extends('layouts.app')
@section('title', 'เพิ่มการสั่งซื้อ')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>เพิ่มการสั่งซื้อ</h3>
        </div>
        <div class="card-body">
            <form action="{{url('/purchases')}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="shop">ร้านค้า:</label>
                    <select class="custom-select form-control" name="shop" id="shop" required>
                        <option value="" selected>เลือกร้านค้า</option>
                        @foreach ($shops as $shop)
                            <option value="{{$shop->idShop}}">{{$shop->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_order">วันที่สั่ง:</label>
                            <input type="date" id="date_order" name="date_order" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">   
                            <label for="time_order">เวลาสั่ง:</label>
                            <input type="time" id="time_order" name="time_order" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_pay">วันที่จ่าย:</label>
                            <input type="date" id="date_pay" name="date_pay" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="time_pay">เวลาจ่าย:</label>
                            <input type="time" id="time_pay" name="time_pay" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_get">วันที่รับ:</label>
                            <input type="date" id="date_get" name="date_get" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="time_get">เวลารับ:</label>
                            <input type="time" id="time_get" name="time_get" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="total_money">จำนวนเงินทั้งหมด:</label>
                            <input type="number" step="any" id="total_money" name="total_money" placeholder="จำนวนเงินทั้งหมด" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">สถานะ:</label>
                            <select class="custom-select form-control" name="status" id="status" required>
                                <option value="">เลือกสถานะ</option>
                                <option value="hasClaim">มีเคลม</option>
                                <option value="hasnotClaim">ไม่มีเคลม</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-light">บันทึก</button>
                    <button type="reset" class="btn btn-light">ล้าง</button>
                </div>
            </form>
        </div>
    </div>
@endsection