@extends('Client.Layout.index')
@section('content')
<div class="post-history">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul id="breadcrumb" style="width: 100%;">
                    <li><a href="{{route('home')}}"><span class="icon fas fa-home mr-2"></span>Trang chủ</a></li>
                    <li><a href="{{route('lichsu_ntt')}}"><span class="icon far fa-list-alt mr-2"></span>Quản lý bài đăng</a></li>
                    <li><a href="#"><span class="icon far fa-list-alt mr-2"></span>Cập nhật bài đăng</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="line3"></div>
        <div class="row" style="justify-content:center">
            <div class="col-lg-8">
                <div class="login-content" style="border: 1px solid gray; margin-top: 10px;">
                    <div class="text-center login-title text-uppercase" style="margin-bottom: 30px;">Cập nhật bài đăng</div>
                    <form action="{{route('update_baidang_ntt', $hocbong->hocbong_id)}}" method="POST" enctype="multipart/form-data">
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
                            <input type="text" class="form-control" name="hocbong_ten" value="{{$hocbong->hocbong_ten}}">
                        </div>
                        <input type="hidden" name="loaihocbong_id" value="{{$hocbong->loaihocbong_id}}">
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
                            <div class="custom-file">
                                <input type="file" name="hocbong_hinhanh" class="custom-file-input" id="inputGroupFile02"/>
                                <label class="custom-file-label" for="inputGroupFile02">Chọn file</label>
                            </div>
                            <img src="{{URL::to('/public/Upload/HocBong/'.$hocbong->hocbong_hinhanh)}}" class="mt-2" width="400" height="200">
                        </div>
                        <div class="form-group">
                            <label for="hocbong_file">File đính kèm (Không bắt buộc)</label>
                            <input type="text" class="form-control" name="hocbong_file" value="{{$hocbong->hocbong_file}}">
                        </div>
                        <div class="form-group">
                            <label for="hocbong_noidung">Nội dung</label>
                            <textarea style="resize: none;" rows="5" class="form-control" name="hocbong_noidung" id="hocbong_noidung">
                                {{$hocbong->hocbong_noidung}}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="hocbong_thoigianbatdau">Thời gian bắt đầu</label>
                            <input type="date" name="hocbong_thoigianbatdau"
                            value="{{ date('Y-m-d', strtotime($hocbong->hocbong_thoigianbatdau))}}">
                        </div>
                        <div class="form-group">
                            <label for="hocbong_thoigianketthuc">Thời gian kết thúc</label>
                            <input type="date" name="hocbong_thoigianketthuc"
                            value="{{ date('Y-m-d', strtotime($hocbong->hocbong_thoigianketthuc))}}">
                        </div>
                        <div class="form-group">
                            <label for="hocbong_kinhphi">Kinh phí</label>
                            <input type="text" class="form-control" name="hocbong_kinhphi" placeholder="Nhập kinh phí học bổng" 
                            value="{{$hocbong->hocbong_kinhphi}}">
                        </div>
                        <div class="form-group">
                            <label for="hocbong_tongsoluong">Tổng số suất</label>
                            <input type="text" class="form-control" name="hocbong_tongsoluong" placeholder="Nhập tổng số lượng suất" 
                            value="{{$hocbong->hocbong_tongsoluong}}">
                        </div>
                        <input type="hidden" name="hocbong_tinhtrang" value="0">
                        <input type="hidden" name="user_id" value="{{Auth::id()}}">
                        <hr class="mt-3 mb-3">
                        <input type="submit" class="btn btn-info mr-2" value="Lưu thay đổi">
                        <a href="{{route('lichsu_ntt')}}" class="btn btn-danger">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@section('ckeditor_content')
<script>
    ClassicEditor
        .create(document.querySelector('#hocbong_noidung'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection