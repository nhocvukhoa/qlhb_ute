@extends('Client.Layout.index')
@section('content')
<section class="login" style="background-color: #fff !important;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul id="breadcrumb" style="width: 100%;">
                    <li><a href="{{route('home')}}"><span class="icon fas fa-home mr-2"></span>Trang chủ</a></li>
                    <li><a href="#"><span class="icon far fa-id-badge mr-2"></span>Thông tin nhà tài trợ</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="line3"></div>
        <div class="row" style="justify-content:center">
            <div class="col-lg-9">
                <div class="login-content" style="border: 1px solid gray; margin-top: 10px;">
                    <div class="text-center login-title text-uppercase" style="margin-bottom: 30px;">Thông tin nhà tài trợ</div>
                    <?php
                    $message =  session()->get('message');
                    if ($message) {
                        echo '<p class="alert alert-success" id="alert-box">' . $message . '</p>';
                        session()->put('message', null);
                    }
                    ?>
                    <form action="{{route('capnhatthongtin_ntt')}}" method="POST">
                        @csrf
                       
                        <div class="form-group row d-flex align-items-center">
                            <label class="col-sm-3" style="margin-bottom: 0!important;">Tên nhà tài trợ :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="fullname" value="{{$sponsor->fullname}}">
                            </div>
                        </div>
                        <div class="form-group row d-flex align-items-center">
                            <label class="col-sm-3" style="margin-bottom: 0!important;">Địa chỉ :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="diachi" value="{{$sponsor->diachi}}">
                            </div>
                        </div>
                        <div class="form-group row d-flex align-items-center">
                            <label class="col-sm-3" style="margin-bottom: 0!important;">Số điện thoại :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="sdt" value="{{$sponsor->sdt}}">
                            </div>
                        </div>
                        <div class="form-group row d-flex align-items-center">
                            <label class="col-sm-3" style="margin-bottom: 0!important;">Email :</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" name="email" value="{{$sponsor->email}}">
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