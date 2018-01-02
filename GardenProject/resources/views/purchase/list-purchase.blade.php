@extends('layouts.app')
@section('title', 'รายการการสั่งซื้อ')
@section('content')
 <div class="card" style="margin-top:10px">
     <div class="card-header">
         <h3>รายการการสั่งซื้อ</h3>
     </div>
     <div class="card-body">
            <div>
                <a href="{{url('purchases/create')}}" class="btn btn-light">เพิ่ม การสั่งซื้อ</a>
            </div>
            <br>
            <table id="table_id" class="display">
                <thead>
                    <tr>
                        <th>เลขที่การสั่งซื้อ</th>
                        <th>วันที่สั่ง</th>
                        <th>เวลาสั่ง</th>
                        <th>วันที่จ่าย</th>
                        <th>เวลาจ่าย</th>
                        <th>วันที่รับ</th>
                        <th>เวลารับ</th>
                        <th>จำนวนเงินทั้งหมด</th>
                        <th>ชื่อร้านค้า</th>
                        <th>สถานะ</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchases as $purchase)
                        <tr>
                            <td>{{$purchase->idPurchase}}</td>
                            <td>{{formatDateThai($purchase->date_order)}}</td>
                            <td>{{formatDateThai($purchase->time_order)}} น.</td>
                            <td>{{formatDateThai($purchase->date_pay)}}</td>
                            <td>{{formatDateThai($purchase->time_pay)}} น.</td>
                            <td>{{formatDateThai($purchase->date_get)}}</td>
                            <td>{{formatDateThai($purchase->time_get)}} น.</td>
                            <td>{{$purchase->total_money}}</td>
                            <td>{{$purchase->name}}</td>
                            <td>{{$purchase->status}}</td>
                            <td>
                                <a href="{{url('/purchases/'.$purchase->idPurchase)}}" class="btn btn-light">รายละเอียด</a>
                                <a href="{{url('/purchases/'.$purchase->idPurchase.'/edit')}}" class="btn btn-light">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deletePurchase{{$loop->index}}" class="btn btn-light">ลบ</button>
                                <div class="modal fade" id="deletePurchase{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/purchases/'.$purchase->idPurchase)}}" method="POST">
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