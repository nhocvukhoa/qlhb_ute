@extends('welcome')
@section('welcome_content')
<!-- 
<p class="label-scholarship">Danh sách học bổng</p> -->
<div class="header-title">
    <h1>DANH SÁCH HỌC BỔNG</h1>
</div>
<!-- <div class="line"></div> -->
<div class="scholarship-list">
    @foreach($listhocbong as $hocbong)
    <div class="col-lg-4 col-sm-6 mb-4 grid-tem">
            <div class="card shadow h-100">
                <div class="img-wrapper">
                    <img class="card-img-top" src="{{URL::to('public/Upload/HocBong/'.$hocbong->hocbong_hinhanh)}}"></img>
                    @if($hocbong->hocbong_thoigianketthuc >= date('Y-m-d'))
                        <span class="status2">Đang diễn ra</span>
                    @else
                        <span class="status">Đã kết thúc</span>
                    @endif
                </div>
                <div class="card-content h-100">
                    <p class="scholarship-name">{{$hocbong->hocbong_ten}}</p>
                </div>
                <div class="card-footer text-center">
                    <a href="{{URL::to('/chitiet-hocbong/'.$hocbong->hocbong_id)}}">
                        <button class="btn btn-danger"><i class="bi bi-clipboard-minus"></i>Xem chi tiết</button>
                    </a>
                </div>
            </div>
    </div>
    @endforeach
</div>

<div class="row mt-2">
    <div class="col-sm-12 text-right text-center-xs">
        <div class="pagination d-flex justify-content-center mr-4"> {{$listhocbong->links('paginationlinks')}}</div>
    </div>
</div>

@endsection