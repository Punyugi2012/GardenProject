@extends('layouts.app')
@section('title', 'เพิ่มการหักเงิน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/deductions')}}">การหักเงิน</a></li>
        <li class="breadcrumb-item active" aria-current="page">เพิ่มการหักเงิน</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>เพิ่มการหักเงิน</h3>
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
            <form action="{{url('/deductions')}}" method="POST" autocomplete="off">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employee">พนักงาน:</label>
                            <select class="custom-select form-control" id="employee" name="employee" required>
                                <option value="">เลือกพนักงาน</option>
                                @foreach ($employees as $employee)
                                    <option value="{{$employee->idEmployee}}">{{$employee->name}}-{{$employee->surname}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="take">การเบิก:</label>
                            <select class="custom-select form-control" id="take" name="take" required>
                                <option value="">เลือกการเบิก</option>
                                @foreach ($takes as $take)
                                    <option value="{{$take->idTake}}">เลขที่การเบิก {{$take->idTake}}, เวลา {{formatDateThai($take->time_take)}} น. วันที่ {{formatDateThai($take->date_take)}} สถานะ {{$take->status_returning == 'fully' ? 'คืนครบแล้ว' : 'คืนยังไม่ครบ'}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="date">วันที่:</label>
                                <input type="date" id="date" name="date" class="form-control" required>
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