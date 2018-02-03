@extends('layouts.app')
@section('title', 'รายการการหักเงิน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item active" aria-current="page">การหักเงิน</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายการการหักเงิน</h3>
        </div>
        <div class="card-body">
            <div>
                <a href="{{url('/deductions/create')}}" class="btn btn-success">เพิ่มการหักเงิน</a>
            </div>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การหักเงิน</th>
                        <th>วันที่</th>
                        <th class="bg-info text-light">จำนวนเงินรวม (บาท)</th>
                        <th class="bg-primary text-light">ชื่อ-สกุลพนักงาน</th>
                        <th>เลขที่การเบิก</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="6" style="text-align:right" class="text-success"></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($deductions as $deduction)
                        <tr>
                            <td>{{$deduction->idDeduction}}</td>
                            <td>{{formatDateThai($deduction->date)}}</td>
                            <td class="text-info">{{$deduction->total_money}}</td>
                            <td class="text-primary">{{$deduction->name}} {{$deduction->surname}}</td>
                            <td>{{$deduction->idTake}}</td>
                            <td>
                                <a href="{{url('/deductions/'.$deduction->idDeduction)}}" class="btn btn-info">รายละเอียด</a>
                                <a href="{{url('/deductions/'.$deduction->idDeduction.'/edit')}}" class="btn btn-warning">แก้ไข</a>
                                <button data-toggle="modal" data-target="#deleteClaim{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                <div class="modal fade" id="deleteClaim{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/deductions/'.$deduction->idDeduction)}}" method="POST">
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
                        .column( 2 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    pageTotal = api
                        .column( 2, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    $( api.column( 2 ).footer() ).html(
                       'รวมจำนวนเงินรวม: ' + pageTotal +' บาท (ทั้งหมด '+ total +' บาท)'
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