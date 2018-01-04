@extends('layouts.app')
@section('title', 'รายละเอียดการเคลม')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายละเอียดการเคลม</h3>
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
            <form action="{{url('/claims_detail/claim/'.$idClaim)}}" method="POST" autocomplete="off">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="item">วัตถุดิบ:</label>
                            <select class="select-custom form-control" id="item" name="item" required>
                                <option value="">เลือกวัตถุดิบ</option>
                                @foreach ($items as $item)
                                    <option value="{{$item->idItem}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">จำนวน:</label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="จำนวนวัตถุดิบ" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cause">สาเหตุ:</label>
                    <textarea class="form-control" id="cause" name="cause" placeholder="สาเหตุ" required></textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-light">บันทึก</button>
                    <button type="reset" class="btn btn-light">ล้าง</button>
                </div>
            </form>
            <br>
            <table id="table_id" class="display">
                <thead>
                    <tr>
                        <th>เลขที่รายละเอียด</th>
                        <th>ชื่อวัตถุดิบ</th>
                        <th>จำนวน</th>
                        <th>สาเหตุ</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($claimsDetail as $claimDetail)
                        <tr>
                            <td>{{$claimDetail->idClaimDetail}}</td>
                            <td>{{$claimDetail->name}}</td>
                            <td>{{$claimDetail->amount}}</td>
                            <td>{{$claimDetail->cause}}</td>
                            <td>
                                <a href="{{url('/edit-claims_detail/'.$claimDetail->idClaimDetail.'/claim/'.$idClaim)}}" class="btn btn-light">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deleteClaimDetail{{$loop->index}}" class="btn btn-light">ลบ</button>
                                <div class="modal fade" id="deleteClaimDetail{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/claims_detail/'.$claimDetail->idClaimDetail.'/claim/'.$idClaim)}}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">ยืนยัน</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
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