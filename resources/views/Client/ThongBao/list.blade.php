@extends('Client.Layout.index')
@section('content')
<section class="notice-page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul id="breadcrumb" style="width: 100%;">
                    <li><a href="{{route('home')}}"><span class="icon fas fa-home mr-2"></span>Trang chủ</a></li>
                    <li><a href="#"><span class="icon bi bi-bell mr-2"></span>Thông báo</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <div class="line3"></div>
                <div class="content-notice">
                    @foreach($thongbao as $item)
                    <div class="notice-item d-flex align-items-center">
                        <img src="{{asset('public/Frontend/images/thongbao3.jpg')}}" class="img-notice">
                        <div class="notice-body">
                            <a class="notice-title text-uppercase" href="{{route('detail_thongbao', $item->thongbao_id)}}">{{$item->thongbao_ten}}</a>
                            <p class="notice-desc">{{$item->thongbao_mota}}</p>
                            <div class="notice-author-time d-flex justify-content-between">
                                <div class="notice-author"><i class="bi bi-person-circle"></i>Người đăng: {{$item->fullname}}</div>
                                <div class="notice-time"><i class="bi bi-clock"></i>Thời gian: {{date('d-m-Y H:i:s', strtotime($item->thongbao_thoigiandang))}}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row mt-4">
                    <div class="col-sm-12 text-right text-center-xs">
                        <div class="pagination d-flex justify-content-center mr-4"> {{$thongbao->links('paginationlinks')}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection