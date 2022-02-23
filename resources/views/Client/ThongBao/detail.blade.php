@extends('Client.Layout.index')
@section('content')
<section class="notice-detail-page" style="margin-bottom: 200px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul id="breadcrumb" style="width: 100%;">
                    <li><a href="{{route('home')}}"><span class="icon fas fa-home mr-2"></span>Trang chủ</a></li>
                    <li><a href="javascript:history.back()"><span class="icon bi bi-bell mr-2"></span>Thông báo</a></li>
                    <li><a href="#"><span class="icon bi bi-file-earmark-post-fill mr-2"></span>Chi tiết thông báo</a></li>
                </ul>
                <div class="line3"></div>
                <div class="content-notice-detail">
                    @foreach($detail_thongbao as $item)
                    <div class="notice-item-detail">
                        <div class="notice-body">
                            <a class="notice-title text-uppercase">{{$item->thongbao_ten}}</a>
                            <div class="notice-content">
                                {!! $item->thongbao_noidung !!}
                            </div>
                            @if($item->thongbao_file)
                            <a href="{{asset('public/Upload/HoSo/'.$item->thongbao_file)}}" target= "_blank">
                                <i class="fas fa-download mr-1" style="color: red;"></i><span style="color: black;">Xem file đính kèm tại đây</span> 
                            </a>
                            @else
                               <p></p>
                            @endif
                            <div class="notice-author-time d-flex justify-content-between">
                                <div class="notice-author"><i class="bi bi-person-circle"></i>Người đăng: {{$item->fullname}}</div>
                                <div class="notice-time"><i class="bi bi-clock"></i>
                                    Thời gian đăng: {{date('d-m-Y H:i:s', strtotime($item->thongbao_thoigiandang))}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection