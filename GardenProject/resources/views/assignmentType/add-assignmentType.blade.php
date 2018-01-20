@extends('layouts.app')
@section('title', 'เพิ่มประเภทมอบหมายงาน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/assignments')}}">การมอบหมายงาน</a></li>
        <li class="breadcrumb-item"><a href="{{url('/assignments/create')}}">เพิ่มการมอบหมายงาน</a></li>
        <li class="breadcrumb-item active" aria-current="page">เพิ่มประเภทมอบหมายงาน</li>
    </ol>
</nav>
@endsection
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>เพิ่มประเภทมอบหมายงาน</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{url('/assignmentTypes')}}" method="POST" autocomplete="off">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name">ชื่อประเภท:</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="ชื่อประเภท" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                    <button type="reset" class="btn btn-warning">รีเซ็ต</button>
                </div>
            </form>
            <br>
            <table id="table_id" data-order='[[ 0, "desc" ]]' class="display">
                <thead>
                    <tr>
                        <th>เลขที่ประเภท</th>
                        <th class="bg-primary text-light">ชื่อ</th>
                        <th>เครื่องมือ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignmentTypes as $type)
                        <tr>
                            <td>{{$type->idAssignmentType}}</td>
                            <td class="text-primary">{{$type->name}}</td>
                            <td>
                                <a href="{{url('/assignmentTypes/'.$type->idAssignmentType.'/edit')}}" class="btn btn-warning">แก้ไข</a>
                                @if ($type->canDelete)
                                    <button data-toggle="modal" data-target="#deleteAssignmentType{{$loop->index}}" class="btn btn-danger">ลบ</button>
                                    <div class="modal fade" id="deleteAssignmentType{{$loop->index}}"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="modal-title">ยืนยันการลบ</h2>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{url('/assignmentTypes/'.$type->idAssignmentType)}}" method="POST">
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