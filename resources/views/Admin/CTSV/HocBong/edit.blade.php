@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Cập nhật học bổng</h6>
    </div>
    <div class="card-body">
        <form action="{{route('update_hocbong',$hocbong->hocbong_id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <?php
                $message =  session()->get('message');
                if ($message) {
                    echo '<p class="alert alert-success mt-2" id="alert-box">' . $message . '</p>';
                    session()->put('message', null);
                }
                ?>
            </div>
            <div class="form-group">
                <label for="hocbong_ten">Tên học bổng</label>
                <input type="text" class="form-control" name="hocbong_ten" placeholder="Nhập tên học bổng..." value="{{$hocbong->hocbong_ten}}">
            </div>
            <div class="form-group">
                <label>Chọn loại học bổng</label>
                <select name="loaihocbong_id" class="form-control input-sm m-bot15">
                    @foreach($loaihocbong as $key => $item)
                    @if($item->loaihocbong_id==$hocbong->loaihocbong_id)
                    <option selected value="{{$item->loaihocbong_id}}">{{$item->loaihocbong_ten}}</option>
                    @else
                    <option value="{{$item->loaihocbong_id}}">{{$item->loaihocbong_ten}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Chọn học kỳ</label>
                <select name="hocky_id" class="form-control input-sm m-bot15">
                    @foreach($hocky as $key => $item)
                    @if($item->hocky_id==$hocbong->hocky_id)
                    <option selected value="{{$item->hocky_id}}">{{$item->hocky_ten}}</option>
                    @else
                    <option value="{{$item->hocky_id}}">{{$item->hocky_ten}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Chọn hình thức duyệt học bổng</label>
                <select name="hinhthucduyet_id" class="form-control input-sm m-bot15">
                    @foreach($hinhthucduyet as $key => $item)
                    @if($item->hinhthucduyet_id==$hocbong->hinhthucduyet_id)
                    <option selected value="{{$item->hinhthucduyet_id}}">{{$item->hinhthucduyet_ten}}</option>
                    @else
                    <option value="{{$item->hinhthucduyet_id}}">{{$item->hinhthucduyet_ten}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="hocbong_hinhanh">Hình ảnh</label>
                <input type="file" class="form-control" name="hocbong_hinhanh">
                <img src="{{URL::to('/public/Upload/HocBong/'.$hocbong->hocbong_hinhanh)}}" class="mt-2" width="200" height="150">
            </div>
            <div class="form-group">
                <label for="hocbong_file">File đính kèm</label>
                <input type="text" class="form-control" name="hocbong_file" value="{{$hocbong->hocbong_file}}">
            </div>
            <div class="form-group">
                <label for="hocbong_noidung">Nội dung</label>
                <textarea style="resize: none;" rows="5" class="form-control" name="hocbong_noidung" id="hocbong_noidung">{{$hocbong->hocbong_noidung}}</textarea>
            </div>
            <div class="form-group">
                <label for="hocbong_thoigianbatdau">Thời gian bắt đầu</label>
                <input type="datetime-local" name="hocbong_thoigianbatdau" value="{{ date('Y-m-d\TH:i', strtotime($hocbong->hocbong_thoigianbatdau)) }}">
            </div>
            <div class="form-group">
                <label for="hocbong_thoigianketthuc">Thời gian kết thúc</label>
                <input type="datetime-local" name="hocbong_thoigianketthuc" value="{{ date('Y-m-d\TH:i', strtotime($hocbong->hocbong_thoigianketthuc))}}">
            </div>
            <div class="form-group">
                <label for="hocbong_kinhphi">Kinh phí</label>
                <input type="text" class="form-control" name="hocbong_kinhphi" value="{{$hocbong->hocbong_kinhphi}}">
            </div>
            <div class="form-group">
                <label for="hocbong_tongsoluong">Tổng số suất</label>
                <input type="text" class="form-control" name="hocbong_tongsoluong" value="{{$hocbong->hocbong_tongsoluong}}">
            </div>
            <div class="form-group">
                <label>Nhà tài trợ</label>
                <select name="user_id" class="form-control input-sm m-bot15">
                    @foreach($user as $key => $item)
                    @if($item->id==$hocbong->user_id)
                    <option selected value="{{$item->id}}">{{$item->fullname}}</option>
                    @else
                    <option value="{{$item->id}}">{{$item->fullname}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="hocbong_thoigiancapnhat">
            <input type="submit" class="btn btn-info mr-2 mt-2" value="Cập nhật">
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