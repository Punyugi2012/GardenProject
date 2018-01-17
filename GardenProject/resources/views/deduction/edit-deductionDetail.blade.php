@extends('layouts.app')
@section('title', 'แก้ไขรายละเอียดการหักเงิน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/deductions')}}">การหักเงิน</a></li>
        <li class="breadcrumb-item"><a href='{{url("/deductions/{$idDeduction}")}}'>รายละเอียดการหักเงิน</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขรายละเอียดการหักเงิน</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>แก้ไขรายละเอียดการหักเงิน</h3>
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
            <form action="{{url('/edit-deductions_detail/'.$deductionDetail->idDeductionDetail.'/deduction/'.$idDeduction)}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group">
                    <label for="item">วัตถุดิบ:</label>
                    <select class="select-custom form-control" id="item" name="item" required>
                        @foreach ($items as $item)
                            <option value="{{$item->idItem}}" {{$deductionDetail->idItem == $item->idItem ? 'selected' : ''}}>{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">จำนวน:</label>
                            <input type="number" id="amount" name="amount" class="form-control" value="{{$deductionDetail->amount}}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">ราคาที่คิด:</label>
                            <input type="number" step="any" id="price" name="price" class="form-control" value="{{$deductionDetail->price}}" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cause">สาเหตุ:</label>
                    <textarea class="form-control" id="cause" name="cause" required>{{$deductionDetail->cause}}</textarea>
                </div>
                <div class="text-right">
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