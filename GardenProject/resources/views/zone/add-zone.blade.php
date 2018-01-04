@extends('layouts.app')
@section('title', 'เพิ่มโซน')
@section('content')
 <div class="card" style="margin-top:10px">
     <div class="card-header">
         <h3>เพิ่มโซน</h3>
     </div>
    <div class="card-body">
        <form action="{{url('/zones')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="area">พื้นที่:</label>
                        <input type="number" step="any" id="area" name="area" class="form-control" placeholder="พื้นที่ ตรม." required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="size">ขนาด:</label>
                        <input type="number" step="any" id="size" name="size" class="form-control" placeholder="ขนาด ไร่" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="images">
                </div>
                <label for="zone_images">รูปภาพโซน(เพิ่มได้หลายรูป):
                </label>
                <input type="file" id="zone_images" name="zone_images[]" class="form-control"  accept="image/*" multiple>
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
    <script type="text/javascript">
        $(function() {
            var imagesPreview = function(input, placeToInsertImagePreview) {
        
                if (input.files) {
                    var filesAmount = input.files.length;
        
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
        
                        reader.onload = function(event) {
                            $($.parseHTML('<img style="width:200px;height:200px">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }
        
                        reader.readAsDataURL(input.files[i]);
                    }
                }
        
            };
            $('#zone_images').on('change', function() {
                imagesPreview(this, 'div.images');
            });
        });
    </script>
@endsection