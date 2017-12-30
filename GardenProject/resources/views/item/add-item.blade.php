@extends('layouts.app')
@section('title', 'เพิ่มวัตถุดิบ')
@section('content')
<div class="card" style="margin-top:10px">
    <div class="card-header">
        <h3>เพิ่มวัตถุดิบ</h3>
    </div>
    <div class="card-body">
        <form action="{{url('/items')}}" method="POST" autocomplete="off">
            <div class="form-group">
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
                        <label for="name">ชื่อ:</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="ชื่อวัตถุดิบ">
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amount">จำนวน:</label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="จำนวน">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="name">ราคาต่อชิ้น:</label>
                        <input type="number" step=any id="name" name="name" class="form-control" placeholder="ราคาต่อชิ้น">
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-light">ยืนยัน</button>
                    <button type="reset" class="btn btn-light">ล้าง</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection