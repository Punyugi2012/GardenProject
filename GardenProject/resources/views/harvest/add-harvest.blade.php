@extends('layouts.app')
@section('title', 'เพิ่มการเก็บเกี่ยว')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>เพิ่มการเก็บเกี่ยว</h3>
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
            <form action="{{url('/harvests')}}" method="POST" autocomplete="off">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="assignment">การมอบหมายงาน:</label>
                            <select class="custom-select form-control" id="assignment" name="assignment" required>
                                <option value="">เลือกการมอบหมายงาน</option>
                                @foreach ($assignments as $assignment)
                                    <option value="{{$assignment->idAssignment}}">{{$assignment->idAssignment}}, {{$assignment->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product">ผลผลิต:</label>
                            <select class="custom-select form-control" id="product" name="product" required>
                                <option value="">เลือกผลผลิต</option>
                                @foreach ($products as $product)
                                    <option value="{{$product->idProduct}}">{{$product->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amount">จำนวน (กิโลกรัม):</label>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="จำนวน (กิโลกรัม)" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">วันที่:</label>
                            <input type="date" class="form-control" id="date" name="date" placeholder="วันที่" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="time">เวลา:</label>
                            <input type="time" class="form-control" id="time" name="time" placeholder="เวลา" required>
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