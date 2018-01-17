@extends('layouts.app')
@section('title', 'รายละเอียดการหักเงิน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/deductions')}}">การหักเงิน</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายละเอียดการหักเงิน</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายละเอียดการหักเงิน</h3>
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
            <form action="{{url('/deductions_detail/deduction/'.$idDeduction)}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="item">อุปกรณ์:</label>
                    <select class="select-custom form-control" id="item" name="item" required>
                        <option value="">เลือกอุปกรณ์</option>
                        @foreach ($items as $item)
                            <option value="{{$item->idItem}}">{{$item->name}}, ราคา {{$item->price_per_item}} บาท</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">จำนวนอุปกรณ์:</label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="จำนวนอุปกรณ์" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">ราคาที่คิด (บาท):</label>
                            <input type="number" step="any" id="price" name="price" class="form-control" placeholder="ราคาที่คิด" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cause">หมายเหตุ:</label>
                    <textarea class="form-control" id="cause" name="cause" placeholder="หมายเหตุ" required></textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                    <button type="reset" class="btn btn-warning">รีเซ็ต</button>
                </div>
            </form>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่รายละเอียด</th>
                        <th>ชื่ออุปกรณ์</th>
                        <th>จำนวน</th>
                        <th>ราคาที่คิด (บาท)</th>
                        <th>หมายเหตุุ</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deductionsDetail as $detail)
                        <tr>
                            <td>{{$detail->idDeductionDetail}}</td>
                            <td>{{$detail->name}}</td>
                            <td>{{$detail->amount}}</td>
                            <td>{{$detail->price}}</td>
                            <td>{{$detail->cause}}</td>
                            <td>
                                <a href="{{url('/edit-deductions_detail/'.$detail->idDeductionDetail.'/deduction/'.$idDeduction)}}" class="btn btn-warning">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deleteDeductionDetail{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                <div class="modal fade" id="deleteDeductionDetail{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/deductions_detail/'.$detail->idDeductionDetail.'/deduction/'.$idDeduction)}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('footer')
    <script type="text/javascript">
        $(document).ready( function () {
            $('#table_id').DataTable();
        });
    </script>
    @if (session()->has('added'))
        <script type="text/javascript">
            swal({
                title: "<?php echo session()->get('added'); ?>",
                text: "ผลการทำงาน",
                timer: 10000,
                type: 'success',
                showConfirmButton: false
            });
        </script>
    @elseif(session()->has('deleted'))
        <script type="text/javascript">
            swal({
                title: "<?php echo session()->get('deleted'); ?>",
                text: "ผลการทำงาน",
                timer: 10000,
                type: 'success',
                showConfirmButton: false
            });
        </script>
    @endif
@endsection