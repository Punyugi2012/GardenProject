@extends('layouts.app')
@section('title', 'รายการการเคลม')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/purchases')}}">การสั่งซื้อ</a></li>
        <li class="breadcrumb-item active" aria-current="page">การเคลม</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายการการเคลม</h3>
        </div>
        <div class="card-body">
            <div>
                <a href="{{url('claims/create?purchase='.$purchase)}}" class="btn btn-success">เพิ่มการเคลม</a>
            </div>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่การเคลม</th>
                        <th class="bg-primary text-light">วันที่เคลม</th>
                        <th class="bg-primary text-light">เวลาเคลม</th>
                        <th class="bg-info text-light">วันที่รับ</th>
                        <th class="bg-info text-light">เวลารับ</th>
                        <th>สถานะ</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($claims as $claim)
                        <tr>
                            <td>{{$claim->idClaim}}</td>
                            <td>{{formatDateThai($claim->date_claim)}}</td>
                            <td>{{formatDateThai($claim->time_claim)}} น.</td>
                            <td>{{formatDateThai($claim->date_get)}}</td>
                            <td>{{formatDateThai($claim->time_get)}} น.</td>
                            <td>
                                @if ($claim->status == 'success')
                                    <a href='{{url("/receiptclaims?claim={$claim->idClaim}&purchase={$purchase}")}}' class="btn btn-success">รับจากเคลมครบแล้ว</a>
                                @elseif($claim->status == 'unsuccess')
                                    <a href='{{url("/receiptclaims?claim={$claim->idClaim}&purchase={$purchase}")}}' class="btn btn-danger">รับจากเคลมยังไม่ครบ</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{url('/claims/'.$claim->idClaim.'?purchase='.$purchase)}}" class="btn btn-primary">อุปกรณ์ที่นำไปเคลม</a>
                                <a href="{{url('/claims/'.$claim->idClaim.'/edit?purchase='.$purchase)}}" class="btn btn-warning">แก้ไข</a>
                                @if ($claim->canDelete)
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
                                            <form action="{{url('/claims/'.$claim->idClaim)}}" method="POST">
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