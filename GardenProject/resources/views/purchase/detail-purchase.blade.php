@extends('layouts.app')
@section('title', 'วัตถุดิบที่สั่งซื้อ')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>วัตถุดิบที่สั่งซื้อ</h3>
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
            <form action="{{url('/purchases_detail/purchase/'.$idPurchase)}}" method="POST" autocomplete="off">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="item">วัตถุดิบ:</label>
                            <select class="custom-select form-control" id="item" name="item" required>
                                <option value="">เลือกวัตถุดิบ</option>
                                @foreach ($items as $item)
                                    <option value="{{$item->idItem}}">{{$item->name}}, ราคา {{$item->price_per_item}} บาท</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">จำนวน:</label>
                            <input type="number" id="amount" name="amount" class="form-control" placeholder="จำนวน" required>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-light">บันทึก</button>
                    <button type="reset" class="btn btn-light">ล้าง</button>
                </div>
            </form>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่รายละเอียด</th>
                        <th>ชื่อวัตถุดิบ</th>
                        <th>ราคาต่อชิ้น (บาท)</th>
                        <th>จำนวน</th>
                        <th>จำนวนเงินรวม (บาท)</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchasesDetail as $purchaseDetail)
                        <tr>
                            <td>{{$purchaseDetail->idPurchaseDetail}}</td>
                            <td>{{$purchaseDetail->name}}
                                @if ($purchaseDetail->type == 'tree')
                                (ต้น)
                                @elseif($purchaseDetail->type == 'drug')
                                    (ลิตร)
                                @elseif($purchaseDetail->type == 'fertilizer')
                                    (กิโลกรัม)
                                @endif
                            </td>
                            <td>{{$purchaseDetail->price_per_item}}</td>
                            <td>{{$purchaseDetail->amount}}</td>
                            <td>{{$purchaseDetail->total_money}}</td>
                            <td>
                                <a href="{{url('/edit-purchases_detail/'.$purchaseDetail->idPurchaseDetail.'/purchase/'.$idPurchase)}}" class="btn btn-light">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deletePurchaseDetail{{$loop->index}}" class="btn btn-light">ลบ</button>
                                <div class="modal fade" id="deletePurchaseDetail{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/purchases_detail/'.$purchaseDetail->idPurchaseDetail.'/purchase/'.$idPurchase)}}" method="POST">
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