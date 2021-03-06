@extends('layouts.app')
@section('title', 'เพิ่มร้านค้า')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/shops')}}">ร้านค้า</a></li>
        <li class="breadcrumb-item active" aria-current="page">เพิ่มร้านค้า</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>เพิ่มร้านค้า</h3>
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
            <form action="{{url('/shops')}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">ชื่อ:</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="ชื่อร้านค้า" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">ที่อยู่:</label>
                            <input type="text" id="address" name="address" class="form-control" placeholder="ที่อยู่" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="phone">เบอร์โทรศัพท์:</label>
                                <input type="text" id="phone" name="phone" class="form-control" placeholder="เบอร์โทรศัพท์" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="account_number">เลขบัญชี:</label>
                            <input type="text" id="account_number" name="account_number" class="form-control" placeholder="เลขบัญชี">
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">ยืนยัน</button>
                    <button type="reset" class="btn btn-warning">รีเซ็ต</button>
                </div>
            </form>
        </div>
    </div>
@endsection
