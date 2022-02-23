@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Thêm học bổng</h6>
    </div>
    <div class="card-body">
        <form action="{{route('insert_hocbong')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <?php
                $message =  session()->get('message');
                if ($message) {
                    echo '<p class="alert alert-danger mt-2" id="alert-box">' . $message . '</p>';
                    session()->put('message', null);
                }
                ?>
            </div>
            <div class="form-group">
                <label for="hocbong_ten">Tên học bổng</label>
                <input type="text" class="form-control" name="hocbong_ten" placeholder="Nhập tên học bổng..." value="{{old('hocbong_ten')}}">
                <span style="color: red;">
                    @error('hocbong_ten')
                    {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label>Loại học bổng</label>
                <select name="loaihocbong_id" class="form-control input-sm m-bot15">
                    @foreach($loaihocbong_hocbong as $key => $loaihocbong)
                    <option value="{{$loaihocbong->loaihocbong_id}}">{{$loaihocbong->loaihocbong_ten}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Chọn học kỳ</label>
                <select name="hocky_id" class="form-control input-sm m-bot15">
                    @foreach($hocky_hocbong as $key => $hocky)
                    <option value="{{$hocky->hocky_id}}">{{$hocky->hocky_ten}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Chọn hình thức duyệt học bổng</label>
                <select name="hinhthucduyet_id" class="form-control input-sm m-bot15">
                    @foreach($hinhthucduyet_hocbong as $key => $hinhthucduyet)
                    <option value="{{$hinhthucduyet->hinhthucduyet_id}}">{{$hinhthucduyet->hinhthucduyet_ten}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="hocbong_hinhanh">Hình ảnh</label>
                <input type="file" class="form-control" name="hocbong_hinhanh" multiple>
            </div>
            <div class="form-group">
                <label for="hocbong_file">File đính kèm</label>
                <input type="text" class="form-control" name="hocbong_file">
            </div>
            <div class="form-group">
                <label for="hocbong_noidung">Nội dung</label>
                <textarea style="resize: none;" rows="5" class="form-control" name="hocbong_noidung" id="hocbong_noidung" placeholder="Nhập nội dung học bổng"></textarea>
                <span style="color: red;">
                    @error('hocbong_noidung')
                    {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="hocbong_thoigianbatdau">Thời gian bắt đầu</label>
                <input type="datetime-local" name="hocbong_thoigianbatdau">
                <span style="color: red;">
                    @error('hocbong_thoigianbatdau')
                    {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="hocbong_thoigianketthuc">Thời gian kết thúc</label>
                <input type="datetime-local" name="hocbong_thoigianketthuc">
                <span style="color: red;">
                    @error('hocbong_thoigianketthuc')
                    {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="hocbong_kinhphi">Kinh phí</label>
                <input type="text" class="form-control" name="hocbong_kinhphi" placeholder="Nhập kinh phí học bổng" 
                value="{{old('hocbong_kinhphi')}}">
                <span style="color: red;">
                    @error('hocbong_kinhphi')
                    {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="hocbong_tongsoluong">Tổng số suất</label>
                <input type="text" class="form-control" name="hocbong_tongsoluong" placeholder="Nhập tổng số lượng suất"
                value="{{old('hocbong_tongsoluong')}}">
                <span style="color: red;">
                    @error('hocbong_tongsoluong')
                    {{$message}}
                    @enderror
                </span>
            </div>
            <input type="hidden" name="hocbong_tinhtrang" value="1">
            <input type="hidden" name="hocbong_nguoiduyet" value="
                @php
                    $fullname = Auth::user()->fullname;
                    if($fullname){
                        echo $fullname;
                    }
                @endphp
            ">
            <div class="form-group">
                <label for="user_id">Người đăng</label>
                <select name="user_id" class="form-control input-sm m-bot15">
                    @foreach($nhataitro_hocbong as $key => $nhataitro)
                        <option value="{{$nhataitro->id}}">{{$nhataitro->fullname}}</option>
                    @endforeach
                </select>
                <span style="color: red;">
                    @error('user_id')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <input type="hidden" name="hocbong_ngayduyet">
            </div>

            <input type="submit" class="btn btn-info mr-2 mt-2" value="Thêm">
            <a href="{{route('show_hocbong')}}" class="btn btn-danger mt-2">Quay lại</a>
        </form>
    </div>
</div>
@endsection

@section('ckeditor_content')
<script>
    ClassicEditor
        .create(document.querySelector('#hocbong_noidung'))
        .catch(error => {
            console.error(error);
        });
</script>

@endsection