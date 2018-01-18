@extends('layouts.app')
@section('title', 'แก้ไขการเก็บเกี่ยว')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/harvests')}}">การเก็บเกี่ยว</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขการเก็บเกี่ยว</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>แก้ไขการเก็บเกี่ยว</h3>
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
            <form action="{{url('/harvests/'.$harvest->idHarvest)}}" method="POST" autocomplete="off">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="assignment">การมอบหมายงาน:</label>
                            <select class="custom-select form-control" id="assignment" name="assignment" required>
                                @foreach ($assignments as $assignment)
                                    <option value="{{$assignment->idAssignment}}">เลขที่การมอบหมายงาน {{$assignment->idAssignment}}, ประเภท {{$assignment->name}}, เวลา {{formatDateThai($assignment->time)}} น. วันที่ {{formatDateThai($assignment->date)}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product">ผลผลิต:</label>
                            <select class="custom-select form-control" id="product" name="product" required>
                                @foreach ($products as $product)
                                    <option value="{{$product->idProduct}}">{{$product->name}}, จำนวนสต็อค {{$product->amount_stock}} กิโลกรัม</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amount">จำนวน (กิโลกรัม):</label>
                            <input type="number" class="form-control" id="amount" name="amount" value="{{$harvest->amount}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">วันที่:</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{$harvest->date_harvest}}"required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="time">เวลา:</label>
                            <input type="time" class="form-control" id="time" name="time" value="{{$harvest->time_harvest}}" required>
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