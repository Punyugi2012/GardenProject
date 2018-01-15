@extends('layouts.app')
@section('title', 'แก้ไขการรับวัตถุดิบจากการเคลม')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/purchases')}}">การสั่งซื้อ</a></li>
        <li class="breadcrumb-item"><a href='{{url("/claims?purchase={$purchase}")}}'>การเคลม</a></li>
        <li class="breadcrumb-item"><a href='{{url("/receiptclaims?claim={$claim->idClaim}&purchase={$purchase}")}}'>รับวัตถุดิบจากการเคลม</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขการรับวัตถุดิบจากการเคลม</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>แก้ไขการรับวัตถุดิบจากการเคลม</h3>
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
            <form action='{{url("/receiptclaims/{$receiptclaim->idReceivingClaim}?purchase={$purchase}")}}' method="POST" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">วันที่:</label>
                            <input type="date" id="date" name="date" class="form-control" value="{{$receiptclaim->date}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="time">เวลา:</label>
                            <input type="time" id="time" name="time" class="form-control" value="{{$receiptclaim->time}}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="claim">การเคลม:</label>
                            <select class="custom-select form-control" id="claim" name="claim" required>
                                <option value="{{$claim->idClaim}}">เลขที่การเคลม {{$claim->idClaim}}, เวลาเคลม {{formatDateThai($claim->time_claim)}} น. วันที่เคลม {{formatDateThai($claim->date_claim)}}</option>
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