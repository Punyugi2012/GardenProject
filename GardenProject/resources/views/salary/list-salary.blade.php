@extends('layouts.app')
@section('title', 'รายการการจ่ายเงินเดือน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item active" aria-current="page">การจ่ายเงินเดือน</li>
    </ol>
</nav>
@endsection
@section('content')
 <div class="card" style="margin-top:10px">
     <div class="card-header">
         <h3>รายการการจ่ายเงินเดือน</h3>
     </div>
     <div class="card-body">
            <div>
                <a href="{{url('salaries/create')}}" class="btn btn-success">เพิ่มการจ่ายเงินเดือน</a>
            </div>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การจ่ายเงินเดือน</th>
                        <th class="bg-info text-light">ชื่อ-สกุลพนักงาน</th>
                        <th>วันที่</th>
                        <th>เวลา</th>
                        <th>จำนวนเงิน(บาท)</th>
                        <th>ค่าเสียหาย(บาท)</th>
                        <th class="bg-primary text-light">จำนวนเงินสุทธิ(บาท)</th>
                        <th>รอบ</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th colspan="9" style="text-align:right" class="text-success"></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($salaries as $salary)
                        <tr>
                            <td>{{$salary->idSalary}}</td>
                            <td class="text-info">{{$salary->name}} {{$salary->surname}}</td>
                            <td>{{formatDateThai($salary->date)}}</td>
                            <td>{{formatDateThai($salary->time)}} น.</td>
                            <td>{{$salary->amount_money}}</td>
                            <td>{{$salary->cost}}</td>
                            <td class="text-primary">{{$salary->rest_money}}</td>
                            <td>{{$salary->round}}</td>
                            <td>
                                <a href="{{url('/salaries/'.$salary->idSalary.'/edit')}}" class="btn btn-warning">แก้ไข</a>   
                                <button data-toggle="modal" data-target="#deleteSalary{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                <div class="modal fade" id="deleteSalary{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">ยืนยันการลบ</h2>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{url('/salaries/'.$salary->idSalary)}}" method="POST">
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
         
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
         
                    // Total over all pages
                    total = api
                        .column( 6 )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
         
                    // Total over this page
                    pageTotal = api
                        .column( 6, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
         
                    // Update footer
                    $( api.column( 6 ).footer() ).html(
                       'รวมจำนวนเงินสุทธิ: ' + pageTotal +' บาท (ทั้งหมด '+ total +' บาท)'
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