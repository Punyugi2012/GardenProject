@extends('layouts.app')
@section('title', 'รายการผลผลิต')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item active" aria-current="page">ผลผลิต</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายการผลผลิต</h3>
        </div>
        <div class="card-body">
            <div>
                <a href="{{url('products/create')}}" class="btn btn-success">เพิ่มผลผลิต</a>
            </div>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่ผลผลิต</th>
                        <th class="bg-primary text-light">ชื่อ</th>
                        <th>ราคาต่อกิโลกรัม (บาท)</th>
                        <th class="bg-info text-light">จำนวนในสต็อค (กิโลกรัม)</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="5" style="text-align:right" class="text-success"></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{$product->idProduct}}</td>
                            <td class="text-primary">{{$product->name}}</td>
                            <td>{{$product->price_per_product}}</td>
                            <td class="text-info">{{$product->amount_stock}}</td>
                            <td>
                                <a href="{{url('/products/'.$product->idProduct.'/edit')}}" class="btn btn-warning">แก้ไข</a>
                                @if ($product->canDelete)
                                    <button data-toggle="modal" data-target="#deleteProduct{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                    <div class="modal fade" id="deleteProduct{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title">ยืนยันการลบ</h2>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{url('/products/'.$product->idProduct)}}" method="POST">
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
                       'รวมจำนวนในสต็อค: ' + pageTotal +' กิโลกรัม (ทั้งหมด '+ total +' กิโลกรัม)'
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