<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.6.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{asset('public/Frontend/css/sweetalert.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/Frontend/css/animate.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="{{asset('public/Frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('public/Frontend/css/reset.css')}}">
</head>

<body>
    <!--TODO: Header-->
    <section class="header">
        <div class="container">
            <div class="row header-content">
                <div class="header-left">
                    <div class="logo">
                        <a href="{{URL::to('/trangchu')}}">
                            <img src="{{asset('public/Frontend/images/logoUTE.png')}}" alt="Logo UTE" >
                        </a>
                    </div>
                    <ul class="nav-list">
                        <li class="nav-item active"><a href="{{URL::to('/trangchu')}}">Trang chủ</a></li>
                        <li class="nav-item"><a href="{{route('list_thongbao')}}">Thông báo</a></li>
                        <li class="nav-item"><a href="{{route('lienhe')}}">Liên hệ</a></li>
                        </li>
                    </ul>
                </div>
                <div class="header-right">
                    <form action="{{route('searchHocBong')}}" method="GET">
                        <div class="search-box d-flex">
                               <input type="text" class="search-txt form-control mr-2" name="keyword" 
                               placeholder="Tìm kiếm học bổng ...">
                            <input type="submit" class="btn btn-primary btn-sm mr-4" value="Tìm kiếm">
                        </div>
                    </form>
                    <div class="user-action">
                        @if(Auth::check())
                        <ul class="nav pull-right top-menu list-action">
                            <li class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="username">
                                    @can('sv')
                                        {{Auth::user()->fullname}}
                                    @endcan
                                    @can('ntt')
                                        {{Auth::user()->fullname}}
                                    @endcan
                                    @can('ctsv')
                                        {{Auth::logout()}}
                                        <a href="{{URL::to('/user/register')}}">Đăng ký</a>
                                        <a href="{{URL::to('/user/login')}}">Đăng nhập</a>
                                    @endcan
                                    @can('cbk')
                                        {{Auth::logout()}}
                                        <a href="{{URL::to('/user/register')}}">Đăng ký</a>
                                        <a href="{{URL::to('/user/login')}}">Đăng nhập</a>
                                    @endcan
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                @can('sv')
                                <li><a href="{{route('thongtin')}}"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Thông tin người dùng</a></li>
                                <li><a href="{{route('danhsachdangky')}}"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>Danh sách đăng ký</a></li>
                                <li><a href="{{route('client_logout')}}"><i class="fa fa-key mr-2"></i> Đăng xuất </a></li>
                                @elsecan('ntt')
                                <li><a href="{{route('thongtin_ntt')}}"><i class="bi bi-person-circle mr-2"></i></i>Thông tin người dùng</a></li>
                                <li><a href="{{route('danghocbong_ntt')}}"><i class="bi bi-file-arrow-up mr-2"></i>Đăng tin học bổng</a></li>
                                <li><a href="{{route('lichsu_ntt')}}"><i class="bi bi-eye mr-2"></i>Quản lý bài đăng</a></li>
                                <li><a href="{{URL::to('logout-client')}}"><i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất </a></li>
                                @endcan
                            </ul>
                        </ul>
                        @else
                        <a href="{{route('show_register_home')}}">Đăng ký</a>
                        <span style="margin: 0px 7px; color: black;">|</span>
                        <a href="{{URL::to('/user/login')}}">Đăng nhập</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!--TODO: end Header-->