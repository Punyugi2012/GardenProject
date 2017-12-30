@extends('layouts.app')
@section('title', 'เพิ่มพนักงาน')
@section('content')
    <div class="card" style="margin-top:10px">
        <div class="card-header">
            <h3>เพิ่มพนักงาน</h3>
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
            <form action="{{url('/employees')}}" method="POST"  enctype="multipart/form-data" autocomplete="off">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">ชื่อ:</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="ชื่อ" required>
                </div>
                <div class="form-group">
                    <label for="surname">นามสกุล:</label>
                    <input type="text" id="surname" name="surname" class="form-control" placeholder="นามสกุล" required>
                </div>
                <div class="form-group">
                    <label for="phone">เบอร์โทรศัพท์:</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="เบอร์โทรศัพท์" required>
                </div>
                <div class="form-group">
                    <label for="nationality">สัญชาติ:</label>
                    <select class="custom-select form-control" id="nationality" name="nationality" required>
                        <option value="" selected>เลือกสัญชาติ</option>
                        <option value="Vietnamese">เวียดนาม</option>
                        <option value="Thai">ไทย</option>
                        <option value="Singaporean">สิงคโปร์</option>
                        <option value="Burmese">พม่า</option>
                        <option value="Lao">ลาว</option>
                        <option value="Indonesian">อินโดนีเซีย</option>
                        <option value="Cambodian">กัมพูชา</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date_worked">วันที่เข้าทำงาน:</label>
                    <input type="date" id="date_worked" name="date_worked" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="profile_image">รูปประจำตัว:
                            <img id="image_upload_preview" src="http://www.conservable.net/sites/default/files/nopic.png" alt="profile image" style="widht:50px;height:50px">
                    </label>
                    <input type="file" id="profile_image" name="profile_image" class="form-control"  accept="image/*">
                </div>
                <div class="form-group">
                    <label for="salary">เงินเดือน:</label>
                    <input type="number" step=any id="salary" name="salary" class="form-control" placeholder="เงินเดือน" required>
                </div>
                <div class="form-group">
                    <label for="gender">เพศ:</label>
                    <select class="custom-select form-control" id="gender" name="gender" required>
                        <option value="" selected>เลือกเพศ</option>
                        <option value="male">ชาย</option>
                        <option value="female">หญิง</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-light">ยืนยัน</button>
                    <button type="reset" class="btn btn-light">ล้าง</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer')
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