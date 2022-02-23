    @include('Client.client_header')
    <section class="login">
        <div class="container">
            <div class="row" style="justify-content:center">
                <div class="col-lg-5">
                    <div class="login-content">
                        <div class="text-center login-title">ĐĂNG NHẬP</div>
                        <?php
                        $message =  session()->get('message');
                        if ($message) {
                            echo '<p class="alert alert-danger" id="alert-box">' . $message . '</p>';
                            session()->put('message', null);
                        }
                        ?>
                        <form action="{{route('client_login')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên đăng nhập:</label>
                                <input type="text" class="form-control" name="name" placeholder="Tên đăng nhập...">
                                <span style="color: red;">
                                    @error('name')
                                     {{$message}}
                                    @enderror
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu:</label>
                                <input type="password" class="form-control" name="password" placeholder="Mật khẩu...">
                                <span style="color: red;">
                                    @error('password')
                                     {{$message}}
                                    @enderror
                                </span>
                            </div>
                            <input type="submit" class="btn btn-primary btn-block btn-login-user" value="Đăng nhập">
                            <div class="not-member text-center">
                                <span>Nếu bạn chưa là thành viên hãy <a href="{{route('show_register_home')}}">Đăng ký</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('Client.client_relationship')
    <!--TODO: Footer-->
    @include('Client.client_footer')

    