@extends('layouts.app')
@section('title', 'รายการขาย')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item active" aria-current="page">การขาย</li>
    </ol>
</nav>
@endsection
@section('content')
 <div class="card" style="margin-top:10px">
     <div class="card-header">
         <h3>รายการขาย</h3>
     </div>
     <div class="card-body">
            <div>
                <a href="{{url('sales/create')}}" class="btn btn-success">เพิ่มการขาย</a>
            </div>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การขาย</th>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th class="bg-primary text-light">จำนวนเงินรวม (บาท)</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="5" style="text-align:right" class="text-success"></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr>
                            <td>{{$sale->idSale}}</td>
                            <td>{{formatDateThai($sale->date)}}</td>
                            <td>{{formatDateThai($sale->time)}} น.</td>
                            <td class="text-primary">{{$sale->total_money}}</td>
                            <td>
                                <a href="{{url('/sales/'.$sale->idSale)}}" class="btn btn-info">รายละเอียด</a> 
                                <a href="{{url('/sales/'.$sale->idSale.'/edit')}}" class="btn btn-warning">แก้ไข</a>   
                                @if ($sale->total_money == 0)
                                    <button data-toggle="modal" data-target="#deleteSale{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                    <div class="modal fade" id="deleteSale{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title">ยืนยันการลบ</h2>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{url('/sales/'.$sale->idSale)}}" method="POST">
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
                        .column( 3 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    pageTotal = api
                        .column( 3, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
                    $( api.column( 3 ).footer() ).html(
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