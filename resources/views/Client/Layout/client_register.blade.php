@include('Client.client_header')
<section class="register">
    <div class="container">
        <div class="row" style="justify-content:center">
            <div class="col-lg-6">
                <div class="register-content">
                    <div class="text-center register-title">ĐĂNG KÝ</div>
                    <?php
                    $message =  session()->get('message');
                    if ($message) {
                        echo '<p class="alert alert-danger" id="alert-box">' . $message . '</p>';
                        session()->put('message', null);
                    }
                    ?>
                    <form action="{{route('register_login')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên đăng nhập:</label>
                            <input type="text" class="form-control mb-1" name="name" placeholder="Tên đăng nhập..." value="{{old('name')}}">
                            @if($errors->has('name'))
                                 <span class="text text-danger">{{$errors->first('name')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu:</label>
                            <input type="password" class="form-control mb-1" name="password" placeholder="Mật khẩu..." value="{{old('password')}}">
                            @if($errors->has('password'))
                                 <span class="text text-danger">{{$errors->first('password')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control mb-1" name="email" placeholder="Email..." value="{{old('email')}}">
                            @if($errors->has('email'))
                                 <span class="text text-danger">{{$errors->first('email')}}</span>
                            @endif
                        </div>
                        <input type="hidden" name="quyen" value="3">
                        <div class="form-group">
                            <label for="fullname">Tên nhà tài trợ:</label>
                            <input type="fullname" class="form-control mb-1" name="fullname" placeholder="Tên nhà tài trợ..." value="{{old('fullname')}}">
                            @if($errors->has('fullname'))
                                 <span class="text text-danger">{{$errors->first('fullname')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="diachi">Địa chỉ:</label>
                            <input type="text" class="form-control mb-1" name="diachi" placeholder="Địa chỉ..." value="{{old('diachi')}}">
                            @if($errors->has('diachi'))
                                 <span class="text text-danger">{{$errors->first('diachi')}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="sdt">Số điện thoại:</label>
                            <input type="text" class="form-control mb-1" name="sdt" placeholder="Số điện thoại..." value="{{old('sdt')}}">
                            @if($errors->has('sdt'))
                                 <span class="text text-danger">{{$errors->first('sdt')}}</span>
                            @endif
                        </div>
                        <input type="hidden" name="tinhtrang" value="0">
                        <input type="submit" class="btn btn-primary btn-block btn-register-user mt-4" value="Đăng ký">
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('Client.client_relationship')
@include('Client.client_footer')