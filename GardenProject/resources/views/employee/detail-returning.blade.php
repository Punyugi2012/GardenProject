@extends('layouts.app')
@section('title', 'รายละเอียดการคืน')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายละเอียดการคืน</h3>
        </div>
        <div class="card-body">
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่รายละเอียด</th>
                        <th>ชื่อวัตถุดิบ</th>
                        <th>จำนวน</th>
                        <th>หมายเหตุ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($returningsDetail as $detail)
                        <tr>
                            <td>{{$detail->idRevertingDetail}}</td>
                            <td>{{$detail->name}}</td>
                            <td>{{$detail->amount}}</td>
                            <td>{{$detail->cause}}</td>
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
@endsection