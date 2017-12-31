@extends('layouts.app')
@section('title', 'รายการร้านค้า')
@section('content')
 <div class="card" style="margin-top:10px">
     <div class="card-header">
         <h3>รายการร้านค้า</h3>
     </div>
     <div class="card-body">
            <div>
                <a href="{{url('shops/create')}}" class="btn btn-light">เพิ่มร้านค้า</a>
            </div>
            <br>
            <table id="table_id" class="display">
                <thead>
                    <tr>
                        <th>ชื่อ</th>
                        <th>ที่อยู่</th>
                        <th>เบอร์โทรศัพท์</th>
                        <th>เลขบัญชี</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shops as $shop)
                        <tr>
                            <td>{{$shop->name}}</td>
                            <td>{{$shop->address}}</td>
                            <td>{{$shop->phone}}</td>
                            <td>{{$shop->account_number??'-'}}</td>
                            <td>
                                <a href="{{url('/shops/'.$shop->idShop.'/edit')}}" class="btn btn-light">แก้ไข</a>
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