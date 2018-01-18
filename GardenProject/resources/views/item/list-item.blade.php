@extends('layouts.app')
@section('title', 'รายการวัตถุดิบ')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item active" aria-current="page">วัตถุดิบ</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายการวัตถุดิบ</h3>
        </div>
        <div class="card-body">
            <div>
                <a href="{{url('items/create')}}" class="btn btn-success">เพิ่มวัตถุดิบ</a>
            </div>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่วัตถุดิบ</th>
                        <th>ชื่อ</th>
                        <th>จำนวน</th>
                        <th>ราคาต่อหน่วย (บาท)</th>
                        <th>ประเภท</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{$item->idItem}}</td>
                            <td>{{$item->name}}</td>
                            <td>
                                {{$item->amount}}
                            </td>
                            <td>{{$item->price_per_item}}</td>
                            <td>  
                                @if ($item->type == 'tree')
                                    ต้นไม้
                                @elseif($item->type == 'drug')
                                    ยา
                                @elseif($item->type == 'fertilizer')
                                    ปุ๋ย
                                @elseif($item->type == 'equipment')
                                    อุปกรณ์
                                @endif</td>
                            <td>
                                <a href="{{url('/items/'.$item->idItem.'/edit')}}" class="btn btn-warning">แก้ไข</a>
                                @if ($item->canDelete)
                                    <button data-toggle="modal" data-target="#deleteItem{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                    <div class="modal fade" id="deleteItem{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title">ยืนยันการลบ</h2>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{url('/items/'.$item->idItem)}}" method="POST">
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