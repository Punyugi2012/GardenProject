@extends('layouts.app')
@section('title', 'เพิ่มการเคลม')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/purchases')}}">การสั่งซื้อ</a></li>
        <li class="breadcrumb-item"><a href='{{url("/claims?purchase={$purchase->idPurchase}")}}'>การเคลม</a></li>
        <li class="breadcrumb-item active" aria-current="page">เพิ่มการเคลม</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>เพิ่มการเคลม</h3>
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
            <form action="{{url('/claims')}}" method="POST" autocomplete="off">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="purchase">การสั่งซื้อ:</label>
                    <select class="custom-select form-control" id="purchase" name="purchase" required>
                        <option value="{{$purchase->idPurchase}}">
                            เลขที่การสั่งซื้อ {{$purchase->idPurchase}}, เวลาที่สั่ง {{formatDateThai($purchase->time_order)}} น., วันที่ซื้อ {{formatDateThai($purchase->date_order)}}
                        </option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date_claim">วันที่เคลม:</label>
                            <input type="date" id="date_claim" name="date_claim" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="time_claim">เวลาเคลม:</label>
                                <input type="time" id="time_claim" name="time_claim" class="form-control" required>
                            </div>
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
                            <div class="form-group">
                                <label for="time_get">เวลาที่รับ:</label>
                                <input type="time" id="time_get" name="time_get" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                    <button type="reset" class="btn btn-warning">รีเซ็ต</button>
                </div>
            </form>
        </div>
    </div>
@endsection