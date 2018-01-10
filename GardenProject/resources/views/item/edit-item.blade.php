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
            <p>จำนวนวัตถุดิบปัจจุบัน: {{$item->amount}}  
                @if ($item->type == 'tree')
                    ต้น
                @elseif($item->type == 'drug')
                    ลิตร
                @elseif($item->type == 'fertilizer')
                    กิโลกรัม
                @endif
            </p>
            <div class="row">
                <div class="col-md-6">
                    <p> เพิ่มจำนวนวัตถุดิบ:
                        <img src="http://i.imgur.com/yOadS1c.png" id="minus1" width="20" height="20" class="minus"/>
                        <input id="qty1" name="inAmount" type="text" value="0" class="qty form-control d-inline" style="width:30%"/>
                        <img id="add1" src="http://i.imgur.com/98cvZnj.png" width="20" height="20" class="add"/>
                    </p>
                </div>
                <div class="col-md-6">
                    <p> ลบจำนวนวัตถุดิบ:
                        <img src="http://i.imgur.com/yOadS1c.png" id="minus2" width="20" height="20" class="minus"/>
                        <input id="qty2" name="deAmount" type="text" value="0" class="qty form-control d-inline" style="width:30%"/>
                        <img id="add2" src="http://i.imgur.com/98cvZnj.png" width="20" height="20" class="add"/>
                    </p>
                </div>
            </div>
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">ชื่อ:</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{$item->name}}" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="price_per_item">ราคาต่อหน่วย (บาท):</label>
                        <input type="number" step=any id="price_per_item" name="price_per_item" class="form-control" value="{{$item->price_per_item}}" required>
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
<script type="text/javascript">
    $('.add').on('click',function(){
        var $qty=$(this).closest('p').find('.qty');
        var currentVal = parseInt($qty.val());
        if (!isNaN(currentVal)) {
            $qty.val(currentVal + 1);
        }
    });
    $('.minus').on('click',function(){
        var $qty=$(this).closest('p').find('.qty');
        var currentVal = parseInt($qty.val());
        if (!isNaN(currentVal) && currentVal > 0) {
            $qty.val(currentVal - 1);
        }
    });
</script>
@endsection