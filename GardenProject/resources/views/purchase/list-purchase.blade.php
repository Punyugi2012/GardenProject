@extends('layouts.app')
@section('title', 'รายการการสั่งซื้อ')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item active" aria-current="page">การสั่งซื้อ</li>
    </ol>
</nav>
@endsection
@section('content')
 <div class="card" style="margin-top:10px">
     <div class="card-header">
         <h3>รายการการสั่งซื้อ</h3>
     </div>
     <div class="card-body">
            <div>
                <a href="{{url('purchases/create')}}" class="btn btn-success">เพิ่มการสั่งซื้อ</a>
            </div>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การสั่งซื้อ</th>
                        <th>วันที่สั่ง</th>
                        <th>เวลาสั่ง</th>
                        <th>วันที่จ่าย</th>
                        <th>เวลาจ่าย</th>
                        <th>วันที่รับ</th>
                        <th>เวลารับ</th>
                        <th class="bg-primary text-light">จำนวนเงินทั้งหมด (บาท)</th>
                        <th class="bg-info text-light">ชื่อร้านค้า</th>
                        <th>เคลม</th>
                        <th>สถานะการจ่ายเงิน</th>
                        <th>สถานะการรับ</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="13" style="text-align:right" class="text-success"></th>
                    </tr>
                </tfoot>
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
                            <td class="text-primary">{{$purchase->total_money}}</td>
                            <td class="text-info">{{$purchase->name}}</td>
                            <td>
                                @if ($purchase->status_claim == 'hasnotClaim')
                                    <button class="btn btn-success">ไม่มีเคลม</button>
                                @elseif ($purchase->status_claim == 'hasClaim')    
                                    <a href="{{url('/claims?purchase='.$purchase->idPurchase)}}" class="btn btn-danger">มีเคลม</a>
                                @endif
                            </td>
                            <td>
                                @if ($purchase->status_payment == 'paid')
                                    <button class="btn btn-success">จ่ายเงินแล้ว</button>
                                @elseif ($purchase->status_payment == 'notpaid')    
                                    <button class="btn btn-danger">ยังไม่จ่ายเงิน</button>
                                @endif
                            </td>
                            <td>
                                @if ($purchase->status_receipt == 'receipted')
                                    <a href='{{url("/receipts?purchase={$purchase->idPurchase}")}}' class="btn btn-success">รับวัตถุดิบแล้ว</a>
                                @elseif ($purchase->status_receipt == 'unreceipted')    
                                    <a href='{{url("/receipts?purchase={$purchase->idPurchase}")}}' class="btn btn-danger">ยังไม่รับ</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{url('/purchases/'.$purchase->idPurchase)}}" class="btn btn-info">วัตถุดิบที่สั่งซื้อ</a>
                                <a href="{{url('/purchases/'.$purchase->idPurchase.'/edit')}}" class="btn btn-warning">แก้ไข</a>
                                @if ($purchase->canDelete)
                                    <button data-toggle="modal" data-target="#deletePurchase{{$loop->index}}" class="btn btn-danger">ลบ</button>
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
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal">ยกเลิก</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
            $('#table_id').DataTable({
                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    total = api
                        .column( 7 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    pageTotal = api
                        .column( 7, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    $( api.column( 7 ).footer() ).html(
                       'จำนวนเงินรวม: ' + pageTotal +' บาท (ทั้งหมด '+ total +' บาท)'
                    );
                }
            });
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