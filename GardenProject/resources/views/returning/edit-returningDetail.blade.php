@extends('layouts.app')
@section('title', 'แก้ไขรายละเอียดการคืน')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>แก้ไขรายละเอียดการคืน</h3>
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
            <form action="{{url('/edit-returnings_detail/'.$returningDetail->idRevertingDetail.'/returning/'.$idReturning)}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                {{ method_field('put') }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="amount">จำนวน:</label>
                                <input type="number" id="amount" name="amount" class="form-control" value="{{$returningDetail->amount}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="item">วัตถุดิบ</label>
                            <select class="custom-select form-control" id="item" name="item" required>
                                @foreach ($items as $item)
                                    <option value="{{$item->idItem}}" {{$returningDetail->idItem == $item->idItem ? 'selected' : ''}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cause">หมายเหตุ:</label>
                    <textarea class="form-control" id="cause" name="cause" placeholder="สาเหตุ" required>{{$returningDetail->cause}}</textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-light">บันทึก</button>
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
@endsection