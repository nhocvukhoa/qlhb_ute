@extends('Client.Layout.index')
@section('content')
<section class="scholarship-detail d-flex flex-column">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul id="breadcrumb" style="width: 100%;">
                    <li><a href="{{route('home')}}"><span class="icon fas fa-home mr-2"></span>Trang chủ</a></li>
                    <li><a href="#"><span class="icon bi bi-file-earmark-post-fill mr-2"></span>Chi tiết học bổng</a></li>
                </ul>
                <div class="line3"></div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 5px;">
        <div class="row">
            <div class="col-md-9 d-flex flex-column">
                @foreach($detail_hocbong as $detail)
                <form action="" method="POST">
                    @csrf
                    <div class="scholarship-detail-content">
                        <div class="scholarship-detail-wrapper">
                            <input type="hidden" name="hocbong_id" value="{{$detail->hocbong_id}}">
                            <img src="{{URL::to('/public/Upload/HocBong/'.$detail->hocbong_hinhanh)}}" style="width: 100%;"></img>
                            <h1 class="scholarship-title"><i class="fas fa-graduation-cap"></i>{{$detail->hocbong_ten}}</h1>
                            <div class="scholarship-content"> {!! $detail->hocbong_noidung !!} </div>
                            @if($detail->hocbong_file)
                            <a href="{{$detail->hocbong_file}}" target= "_blank" class="scholarship_file">
                                <i class="fas fa-download mr-1" style="color: red;"></i><span style="color: black;">Xem file đính kèm tại đây</span> 
                            </a>
                            @else
                               <p></p>
                            @endif
                         
                            <div class="footer-detail d-flex flex-column mt-3">
                                <div class="footer-detail-item d-flex" style="font-size: 18px;">
                                    <p><i class="bi bi-clock"></i>Bắt đầu: {{date('d/m/Y', strtotime($detail->hocbong_thoigianbatdau));}}</p>
                                    <p><i class="bi bi-clock"></i>Kết thúc: {{date('d/m/Y', strtotime($detail->hocbong_thoigianketthuc));}}</p>
                                    <p><i class="bi bi-people-fill mr-2"></i>Số lượng đã đăng ký: {{$detail->hocbong_soluongdadangky}}</p>
                                </div>
                                <div class="footer-detail-item d-flex" style="font-size: 18px; line-height: 23px;">
                                    <p><i class="bi bi-person-circle mr-2"></i>Người đăng: {{$detail->fullname}}</p>
                                    <p><i class="bi bi-clock"></i>Thời gian đăng: {{date('d/m/Y H:i', strtotime($detail->hocbong_ngayduyet))}}</p>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </form>

                <div class="registration-form">
                    <form action="{{URL::to('/dangky-hocbong')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h1 class="form-title">HỒ SƠ ĐĂNG KÝ</h1>
                        <div class="alert alert-danger">
                            <p class="mb-2">LƯU Ý</p>
                            <ol class="p-1 ml-2" style="list-style: block !important; font-size: 18px;">
                                <li class="mb-2">Sinh viên chọn file minh chứng cho từng tiêu chí của học bổng</li>
                                <li>Sinh viên phải kiểm tra hồ sơ vì chỉ đăng ký được một lần duy nhất</li>
                            </ol>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="hocbong_id" value="{{$detail->hocbong_id}}">
                        </div>
                        <div class="form-group">
                            <?php
                            $message =  session()->get('message');
                            if ($message) {
                                echo '<p class="alert alert-success mt-2" id="alert-box">' . $message . '</p>';
                                session()->put('message', null);
                            }
                            ?>
                        </div>
                        @foreach($detail->tieuchi as $key => $tieuchi)
                        @if($student)
                        <input type="hidden" name="user_name" value="{{$student->name}}">
                        <input type="hidden" name="user_fullname" value="{{$student->fullname}}">
                        <input type="hidden" name="user_nganh" value="{{$student->nganh_ten}}">
                        <input type="hidden" name="user_lop" value="{{$student->lop_ten}}">
                        <input type="hidden" name="tieuchi_id[]" value="{{$tieuchi->tieuchi_id}}">
                        @endif
                        <div class="form-group mt-3">
                            <label style="font-size: 18px; line-height: 22px; font-weight: 600px;">Minh chứng {{ ($key+1) }}: {{$tieuchi->tieuchi_ten}}</label>
                            <!-- <input name="image[]" type="file" class="form-control hoso_hinhanh"> -->
                            <div class="custom-file">
                                <input type="file" name="image[]" class="custom-file-input hoso_hinhanh" multiple
                                id="inputGroupFile02"/>
                                <label class="custom-file-label" for="inputGroupFile02">Chọn file</label>
                                <span style="color: red;">
                                    @error('image[]')
                                        {{$message}}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        @endforeach

                        <hr class="mt-1">
                        <div class="d-flex justify-content-center">
                            @if(Auth::check())
                                @if(Auth::user()->quyen==2)
                                    @if($detail->hocbong_thoigianketthuc < date('Y-m-d'))
                                        <button type="submit" class="btn btn-danger text-center text-uppercase" style="margin-top: 20px;" disabled>Đã hết hạn</button>
                                    @else
                                        @if($detail->loaihocbong_id==1 && Auth::user()->canbo==1)
                                            @if(!$canRegister)
                                                <button type="submit" name="image[]" disabled class="btn btn-danger text-center text-uppercase" style="margin-top: 10px;">Đã đăng ký</button>
                                            @else
                                                <button type="submit" name="image[]" class="btn btn-danger text-center text-uppercase register_hocbong" style="margin-top: 10px;">Đăng ký</button>
                                            @endif
                                        @elseif($detail->loaihocbong_id==1 && Auth::user()->canbo==0)
                                            <button type="submit" name="image[]" disabled class="btn btn-danger text-center text-uppercase" style="margin-top: 10px;">Không có quyền đăng ký</button>
                                        @else
                                            @if(!$canRegister)
                                                <button type="submit" name="image[]" disabled class="btn btn-danger text-center text-uppercase" style="margin-top: 10px;">Đã đăng ký</button>
                                            @else
                                                <button type="submit" name="image[]" class="btn btn-danger text-center text-uppercase register_hocbong" style="margin-top: 10px;">Đăng ký</button>
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    @if($detail->hocbong_thoigianketthuc < date('Y-m-d'))
                                        <button class="btn btn-danger text-center text-uppercase" style="margin-top: 10px;" disabled>Đã hết hạn</button>
                                    @else
                                        <button class="btn btn-danger text-center text-uppercase" style="margin-top: 10px;" disabled>Đăng ký</button>
                                    @endif
                                @endif
                            @else
                                @if($detail->hocbong_thoigianketthuc < date('Y-m-d'))
                                    <a href="{{route('show_form_login_home')}}">
                                        <button class="btn btn-danger text-center text-uppercase" style="margin-top: 10px;" disabled>Đã hết hạn</button>
                                    </a>
                                @else
                                    <a href="{{route('show_form_login_home')}}">
                                        <button class="btn btn-danger text-center text-uppercase" style="margin-top: 10px;">Đăng ký</button>
                                    </a>
                                @endif
                            @endif
                           
                        </div>
                    </form>
                </div>
                @endforeach

            </div>

            <div class="col-md-3 d-flex flex-column">
                <div class="relate-scholarship">
                    <h1 class="relate-title"><i class="fas fa-graduation-cap"></i>Các học bổng liên quan</h1>
                    <div class="relate-scholarship-list d-flex flex-column">
                        @foreach($relate_hocbong as $relate)
                        <a href="{{URL::to('/chitiet-hocbong/'.$relate->hocbong_id)}}">
                            <div class="relate-scholarship-item" style="border-bottom: 1px solid #aaaaaa;">
                                <img src="{{URL::to('/public/Upload/HocBong/'.$relate->hocbong_hinhanh)}}" class="relate-img">
                                <h1 class="relate-name">{{$relate->hocbong_ten}}</h1>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection