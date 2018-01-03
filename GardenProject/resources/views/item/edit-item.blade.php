@extends('layouts.app')
@section('title', 'แก้ไขวัตถุดิบ')
@section('content')
<div class="card" style="margin-top:10px">
    <div class="card-header">
        <h3>แก้ไขวัตถุดิบ</h3>
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
        <form action="{{url('/items/'.$item->idItem)}}" method="POST" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="type">ประเภท:</label>
                            <select class="custom-select form-control" id="type" name="type" required>
                                <option value="tree" {{$item->type == 'tree' ? 'selected' : ''}}>ต้นไม้</option>
                                <option value="drug" {{$item->type == 'drug' ? 'selected' : ''}}>ยา</option>
                                <option value="fertilizer" {{$item->type == 'fertilizer' ? 'selected' : ''}}>ปุ๋ย</option>
                                <option value="equipment" {{$item->type == 'equipment' ? 'selected' : ''}}>อุปกรณ์</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="name">ชื่อ:</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{$item->name}}" required>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amount">จำนวน:</label>
                            <input type="number" id="amount" name="amount" class="form-control" value="{{$item->amount}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="price_per_item">ราคาต่อหน่วย:</label>
                        <input type="number" step=any id="price_per_item" name="price_per_item" class="form-control" value="{{$item->price_per_item}}" required>
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