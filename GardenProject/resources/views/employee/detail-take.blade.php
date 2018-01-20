@extends('layouts.app')
@section('title', 'รายละเอียดการเบิก')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/employees')}}">พนักงาน</a></li>
        <li class="breadcrumb-item"><a href='{{url("/employees/{$employee}")}}'>รายละเอียดพนักงาน</a></li>
        <li class="breadcrumb-item active" aria-current="page">รายละเอียดการเบิก</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>รายละเอียดการเบิก</h3>
        </div>
        <div class="card-body">
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่รายละเอียด</th>
                        <th class="bg-primary text-light">ชื่อวัตถุดิบ</th>
                        <th>จำนวน</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($takesDetail as $detail)
                        <tr>
                            <td>{{$detail->idTakeDetail}}</td>
                            <td class="text-primary">{{$detail->name}}</td>
                            <td>{{$detail->amount}}</td>
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