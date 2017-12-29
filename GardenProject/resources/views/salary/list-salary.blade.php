@extends('layouts.app')
@section('title', 'รายการการจ่ายเงินเดือน')
@section('content')
 <div class="card" style="margin-top:10px">
     <div class="card-header">
         <h3>รายการการจ่ายเงินเดือน</h3>
     </div>
     <div class="card-body">
            <div>
                <a href="{{url('salaries/create')}}" class="btn btn-light">เพิ่มการจ่ายเงินเดือน</a>
            </div>
            <br>
            <table id="table_id" class="display">
                <thead>
                    <tr>
                        <th>ชื่อ</th>
                        <th>นามสกุล</th>
                        <th>วันที่</th>
                        <th>จำนวนเงิน</th>
                        <th>ค่าเสียหาย</th>
                        <th>จำนวนเงินสุทธิ</th>
                        <th>รอบ</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salaries as $salary)
                        <tr>
                            <td>{{$salary->name}}</td>
                            <td>{{$salary->surname}}</td>
                            <td>{{formatDateThai($salary->date_time)}} น.</td>
                            <td>{{$salary->amount_money}}</td>
                            <td>{{$salary->cost}}</td>
                            <td>{{$salary->rest_money}}</td>
                            <td>{{$salary->round}}</td>
                            <td>
                                <a href="{{url('/salaries/'.$salary->idSalary.'/edit')}}" class="btn btn-light">แก้ไข</a>   
                                <form action="{{url('/salaries/'.$salary->idSalary)}}" method="POST" class="d-inline">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-light">ลบ</button>
                                </form>
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