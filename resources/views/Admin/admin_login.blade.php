<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{$title}}</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('public/Backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <!-- Custom styles for this template-->
    <link href="{{asset('public/Backend/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Đăng nhập</h1>
                                    </div>
                                    <?php
                                    $message =  session()->get('message');
                                    if ($message) {
                                        echo '<p class="alert alert-danger" id="alert-box">' . $message . '</p>';
                                        session()->put('message', null);
                                    }
                                    ?>
                                    <form class="user" action="{{route('admin_login')}}" method="POST">
                                        @csrf
                                        <div class="form-group" style="margin-bottom: 0px;">
                                            <input type="text" class="form-control form-control-user mb-1" name="name" placeholder="Nhập tên đăng nhập" value="{{old('name')}}">
                                            <span style="color: red; margin-left: 10px;">
                                                @error('name')
                                                    {{$message}}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="form-group" style="margin-bottom: 0px;">
                                            <input type="password" class="form-control form-control-user mb-1" name="password" placeholder="Nhập mật khẩu" value="{{old('password')}}">
                                            <span style="color: red; margin-left: 10px;">
                                                @error('password')
                                                    {{$message}}
                                                @enderror
                                            </span>
                                        </div>
                                        <input type="submit" value="Đăng nhập" class="btn btn-primary btn-user btn-block mt-1">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('public/Backend/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('public/Backend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('public/Backend/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}
    <!-- Custom scripts for all pages-->
    <script src="{{asset('public/Backend/js/sb-admin-2.min.js')}}"></script>
    <script>
        $('#alert-box').removeClass('hide');
        $('#alert-box').delay(4000).slideUp(500);
    </script>


</body>

</html>