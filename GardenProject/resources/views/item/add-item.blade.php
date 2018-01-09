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
        <form action="{{url('/items')}}" method="POST" autocomplete="off">
            {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="type">ประเภท:</label>
                            <select class="custom-select form-control" id="type" name="type" required>
                                <option value="" selected>เลือกประเภท</option>
                                <option value="tree">ต้นไม้</option>
                                <option value="drug">ยา</option>
                                <option value="fertilizer">ปุ๋ย</option>
                                <option value="equipment">อุปกรณ์</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">ชื่อ:</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="ชื่อวัตถุดิบ" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amount">จำนวน:</label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="จำนวน" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="price_per_item">ราคาต่อหน่วย (บาท):</label>
                            <input type="number" step=any id="price_per_item" name="price_per_item" class="form-control" placeholder="ราคาต่อหน่วย" required>
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