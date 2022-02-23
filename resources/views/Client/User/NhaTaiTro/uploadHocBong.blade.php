@extends('Client.Layout.index')
@section('content')
<section class="login" style="background-color: #fff !important;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul id="breadcrumb" style="width: 100%;">
                    <li><a href="{{route('home')}}"><span class="icon fas fa-home mr-2"></span>Trang chủ</a></li>
                    <li><a href="#"><span class="icon bi bi-file-arrow-up mr-2"></span>Đăng tin học bổng</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="line3"></div>
        <div class="row" style="justify-content:center">
            <div class="col-lg-7">
                <div class="login-content" style="border: 1px solid gray; margin-top: 10px;">
                    <div class="text-center login-title text-uppercase" style="margin-bottom: 30px;">Đăng thông tin học bổng</div>
                    <?php
                    $message =  session()->get('message');
                    if ($message) {
                        echo '<p class="alert alert-success" id="alert-box">' . $message . '</p>';
                        session()->put('message', null);
                    }
                    ?>
                     <?php
                    $error =  session()->get('error');
                    if ($error) {
                        echo '<p class="alert alert-danger" id="alert-box">' . $error . '</p>';
                        session()->put('error', null);
                    }
                    ?>
                    <form action="{{route('luubaidang_ntt')}}" method="POST" enctype="multipart/form-data">
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
                            <input type="text" class="form-control" name="hocbong_ten" placeholder="Nhập tên học bổng..." value="{{old('hocbong_ten')}}">
                            @if($errors->has('hocbong_ten'))
                                <span class="text text-danger">{{$errors->first('hocbong_ten')}}</span>
                            @endif
                        </div>
                        <input type="hidden" name="loaihocbong_id" value="3">
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
                            <!-- <input type="file" class="form-control" name="hocbong_hinhanh"> -->
                            <div class="custom-file">
                                <input type="file" name="hocbong_hinhanh" class="custom-file-input" id="inputGroupFile02"/>
                                <label class="custom-file-label" for="inputGroupFile02">Chọn file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="hocbong_file">File đính kèm (Không bắt buộc)</label>
                            <input type="text" class="form-control" name="hocbong_file" placeholder="Chọn đường dẫn đến file...">
                        </div>
                        <div class="form-group">
                            <label for="hocbong_noidung">Nội dung</label>
                            <textarea style="resize: none;" rows="5" class="form-control" name="hocbong_noidung" id="hocbong_noidung" placeholder="Nhập nội dung học bổng"></textarea>
                            @if($errors->has('hocbong_noidung'))
                                <span class="text text-danger">{{$errors->first('hocbong_noidung')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="hocbong_thoigianbatdau">Thời gian bắt đầu</label>
                            <input type="date" name="hocbong_thoigianbatdau">
                            @if($errors->has('hocbong_thoigianbatdau'))
                                <span class="text text-danger">{{$errors->first('hocbong_thoigianbatdau')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="hocbong_thoigianketthuc">Thời gian kết thúc</label>
                            <input type="date" name="hocbong_thoigianketthuc">
                            @if($errors->has('hocbong_thoigianketthuc'))
                                <span class="text text-danger">{{$errors->first('hocbong_thoigianketthuc')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="hocbong_kinhphi">Kinh phí</label>
                            <input type="text" class="form-control" name="hocbong_kinhphi" placeholder="Nhập kinh phí học bổng" value="{{old('hocbong_kinhphi')}}">
                            @if($errors->has('hocbong_kinhphi'))
                                <span class="text text-danger">{{$errors->first('hocbong_kinhphi')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="hocbong_tongsoluong">Tổng số suất</label>
                            <input type="text" class="form-control" name="hocbong_tongsoluong" placeholder="Nhập tổng số lượng suất" value="{{old('hocbong_tongsoluong')}}">
                            @if($errors->has('hocbong_tongsoluong'))
                                <span class="text text-danger">{{$errors->first('hocbong_tongsoluong')}}</span>
                            @endif
                        </div>
                        <input type="hidden" name="hocbong_tinhtrang" value="0">
                        <input type="hidden" name="user_id" value="{{Auth::id()}}">
                        <hr class="mt-3 mb-3">
                        <input type="submit" class="btn btn-info mr-2" value="Đăng bài">
                        <a href="{{route('home')}}" class="btn btn-danger">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!--TODO: Footer-->
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