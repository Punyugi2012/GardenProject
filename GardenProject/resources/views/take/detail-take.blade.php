@extends('layouts.app')
@section('title', 'อุปกรณ์ที่เบิก')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/takes')}}">เบิกอุปกรณ์</a></li>
        <li class="breadcrumb-item active" aria-current="page">อุปกรณ์ที่เบิก</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>อุปกรณ์ที่เบิก</h3>
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
            <form action="{{url('/takes_detail/take/'.$idTake)}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">จำนวน:</label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="จำนวนวัตถุดิบ" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="item">อุปกรณ์</label>
                        <select class="custom-select form-control" id="item" name="item" required>
                            <option value="">อุปกรณ์</option>
                            @foreach ($items as $item)
                                <option value="{{$item->idItem}}">{{$item->name}}, จำนวนที่มีอยู่ {{$item->amount}}</option>
                            @endforeach
                        </select>
                    </div>
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
                        <th>ชื่อวัตถุดิบ</th>
                        <th>จำนวน</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($takesDetail as $detail)
                        <tr>
                            <td>{{$detail->idTakeDetail}}</td>
                            <td>{{$detail->name}}</td>
                            <td>{{$detail->amount}}</td>
                            <td>
                                <button data-toggle="modal" data-target="#deleteTakeDetail{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                <div class="modal fade" id="deleteTakeDetail{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/takes_detail/'.$detail->idTakeDetail.'/take/'.$idTake)}}" method="POST">
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