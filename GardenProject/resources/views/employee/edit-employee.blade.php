@extends('layouts.app')
@section('title', 'แก้ไขพนักงาน')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item"><a href="{{url('/employees')}}">พนักงาน</a></li>
        <li class="breadcrumb-item active" aria-current="page">แก้ไขพนักงาน</li>
    </ol>
</nav>
@endsection
@section('content')
<div class="card" style="margin-top:10px">
    <div class="card-header">
        <h3>แก้ไขพนักงาน</h3>
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
        <form action="{{url('/employees/'.$employee->idEmployee)}}" enctype="multipart/form-data" method="POST" autocomplete="off">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="name">ชื่อ:</label>
                <input type="text" id="name" name="name" class="form-control" value="{{$employee->name}}"placeholder="ชื่อ" required>
            </div>
            <div class="form-group">
                <label for="surname">นามสกุล:</label>
                <input type="text" id="surname" name="surname" class="form-control" value="{{$employee->surname}}" placeholder="นามสกุล" required>
            </div>
            <div class="form-group">
                <label for="phone">เบอร์โทรศัพท์:</label>
                <input type="text" id="phone" name="phone" class="form-control" value="{{$employee->phone}}" placeholder="เบอร์โทรศัพท์" required>
            </div>
            <div class="form-group">
                <label for="nationality">สัญชาติ:</label>
                <select class="custom-select form-control" id="nationality" name="nationality" required>
                    <option value="Vietnamese" {{$employee->nationality == 'Vietnamese' ? 'selected': ''}}>เวียดนาม</option>
                    <option value="Thai" {{$employee->nationality == 'Thai' ? 'selected': ''}}>ไทย</option>
                    <option value="Singaporean" {{$employee->nationality == 'Singaporean' ? 'selected': ''}}>สิงคโปร์</option>
                    <option value="Burmese" {{$employee->nationality == 'Burmese' ? 'selected': ''}}>พม่า</option>
                    <option value="Lao" {{$employee->nationality == 'Lao' ? 'selected': ''}}>ลาว</option>
                    <option value="Indonesian" {{$employee->nationality == 'Indonesian' ? 'selected': ''}}>อินโดนีเซีย</option>
                    <option value="Cambodian" {{$employee->nationality == 'Cambodian' ? 'selected': ''}}>กัมพูชา</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date_worked">วันที่เข้าทำงาน:</label>
                <input type="date" id="date_worked" name="date_worked" class="form-control" value={{$employee->date_worked}} required>
            </div>
            <div class="form-group">
                <label for="profile_image">รูปประจำตัว:
                    <img id="image_upload_preview" src="{{asset('images/resize/'.$employee->profile_image)}}" alt="profile image" style="widht:50px;height:50px">
                </label>
                <input type="file" id="profile_image" name="profile_image" class="form-control"  accept="image/*">
            </div>
            <div class="form-group">
                <label for="salary">เงินเดือน:</label>
                <input type="number" step=any id="salary" name="salary" class="form-control" value="{{$employee->salary}}" placeholder="เงินเดือน" required>
            </div>
            <div class="form-group">
                <label for="gender">เพศ:</label>
                <select class="custom-select form-control" id="gender" name="gender" required>
                    <option value="male" {{$employee->gender == 'male' ? 'selected': ''}}>ชาย</option>
                    <option value="female" {{$employee->gender == 'female' ? 'selected': ''}}>หญิง</option>
                </select>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-light">บันทึก</button>
                <button type="reset" class="btn btn-light">ล้าง</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('footer')
    @if (session()->has('edited'))
        <script type="text/javascript">
            swal({
                title: "<?php echo session()->get('edited'); ?>",
                text: "ผลการทำงาน",
                timer: 10000,
                type: 'success',
                showConfirmButton: false
            });
        </script>
    @endif
    <script type="text/javascript">
        $(document).ready( function () {   
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
        
                    reader.onload = function (e) {
                        $('#image_upload_preview').attr('src', e.target.result);
                    }
        
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#profile_image").change(function () {
                readURL(this);
            });
        });
    </script>
@endsection