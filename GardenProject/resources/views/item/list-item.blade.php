@extends('layouts.app')
@section('title', 'รายการวัตถุดิบ')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายการวัตถุดิบ</h3>
        </div>
        <div class="card-body">
            <div>
                <a href="{{url('items/create')}}" class="btn btn-light">เพิ่มวัตถุดิบ</a>
            </div>
            <br>
            <table id="table_id" class="display">
                <thead>
                    <tr>
                        <th>ชื่อ</th>
                        <th>จำนวน</th>
                        <th>ประเภท</th>
                        <th>ราคาต่อชิ้น</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>
                                {{$item->amount}}
                                @if($item->type == 'tree')
                                    ต้น
                                @elseif($item->type == 'drug') 
                                    ลิตร
                                @elseif($item->type == 'fertilizer')
                                    กิโลกรัม
                                @elseif($item->type == 'equipment') 
                                    ชิ้น/เครื่อง
                                @endif
                            </td>
                            <td>{{$item->type}}</td>
                            <td>{{$item->price_per_item}} บาท</td>
                            <td>
                                <a href="{{url('/items/'.$item->idItem.'/edit')}}" class="btn btn-light">แก้ไข</a>
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
 @endif
@endsection