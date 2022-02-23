@extends('Client.Layout.index')
@section('content')
<section class="login" style="background-color: #fff !important;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul id="breadcrumb" style="width: 100%;">
                    <li><a href="{{route('home')}}"><span class="icon fas fa-home mr-2"></span>Trang chủ</a></li>
                    <li><a href="#"><span class="icon far fa-id-badge mr-2"></span>Thông tin sinh viên</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="line3"></div>
        <div class="row" style="justify-content:center">
            <div class="col-lg-11">
                <div class="login-content" style="border: 1px solid gray; margin-top: 10px;">
                    <div class="text-center login-title text-uppercase mb-4">Thông tin sinh viên</div>
                    <?php
                    $message =  session()->get('message');
                    if ($message) {
                        echo '<p class="alert alert-success" id="alert-box">' . $message . '</p>';
                        session()->put('message', null);
                    }
                    ?>
                    <form action="{{route('capnhatthongtin_sv')}}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group d-flex align-items-center col-md-6">
                                <label class="col-md-4" style="margin-bottom: 0!important;">Mã sinh viên :</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="name" value="{{$student->name}}" disabled>
                                </div>
                            </div>
                            <div class="form-group d-flex align-items-center col-md-6">
                                <label class="col-md-4" style="margin-bottom: 0!important;">Khoa :</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="khoa_id" value="{{$student->khoa_ten}}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group  d-flex align-items-center col-md-6">
                                <label class="col-md-4" style="margin-bottom: 0!important;">Ngành :</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="nganh_id" value="{{$student->nganh_ten}}" disabled>
                                </div>
                            </div>
                            <div class="form-group d-flex align-items-center col-md-6">
                                <label class="col-md-4" style="margin-bottom: 0!important;">Lớp :</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="lop_id" value="{{$student->lop_ten}}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group d-flex align-items-center col-sm-6">
                                <label class="col-sm-4" style="margin-bottom: 0!important;">Họ và tên :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="fullname" value="{{$student->fullname}}" disabled>
                                </div>
                            </div>
                            <div class="form-group d-flex align-items-center col-sm-6">
                                <label class="col-sm-4" style="margin-bottom: 0!important;">Chức vụ :</label>
                                <div class="col-sm-8">
                                    @if($student->canbo)
                                    <input type="text" class="form-control" name="chucvu" value="{{$student->chucvu}}" disabled>
                                    @else
                                    <input type="text" class="form-control" name="chucvu" value="Không có" disabled>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group  d-flex align-items-center col-md-6">
                                <label class="col-sm-4" style="margin-bottom: 0!important;">Email :</label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control" name="email" value="{{$student->email}}" disabled>
                                </div>
                            </div>
                            <div class="form-group d-flex align-items-center col-sm-6">
                                <label class="col-sm-4" style="margin-bottom: 0!important;">Ngày sinh :</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" name="ngaysinh" value="{{ date('Y-m-d', strtotime($student->ngaysinh)) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                        <div class="form-group d-flex align-items-center col-md-6">
                                <label class="col-sm-4" style="margin-bottom: 0!important;">Giới tính :</label>
                                <div class="col-sm-8">
                                    <!-- <input type="text" class="form-control" name="gioitinh" value="{{$student->gioitinh}}"> -->
                                    <input type=radio name="gioitinh" class="mr-1" value="Nam" {{ $student->gioitinh == 'Nam' ? 'checked' : ''}}>Nam</option>
                                    <input type=radio name="gioitinh" class="mr-1" value="Nữ" {{ $student->gioitinh == 'Nữ' ? 'checked' : ''}}>Nữ</option>            
                                </div>
                            </div>
                            <div class="form-group d-flex align-items-center col-md-6">
                                <label class="col-sm-4" style="margin-bottom: 0!important;">Địa chỉ :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="diachi" value="{{$student->diachi}}">
                                </div>
                            </div>
                           
                        </div>

                        <div class="form-row">
                            <div class="form-group  d-flex align-items-center col-md-6">
                                <label class="col-sm-4" style="margin-bottom: 0!important;">Số điện thoại :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="sdt" value="{{$student->sdt}}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-center" style="width: 100%;">
                            <input type="submit" class="btn btn-primary  btn-login-user" value="Cập nhật">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!--TODO: Footer-->
@endsection