<section class="top-register">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="header-title">
                    <h1>Học bổng được đăng ký nhiều</h1>
                </div>
                <div class="top-register-list d-flex flex-wrap">
                @foreach($hocbong_dangky as $key => $hocbong)
                    <div class="col-lg-3 col-sm-6 mb-4 grid-tem">
                            <div class="card shadow h-100" style="border: none;">
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
            </div>
        </div>
    </div>
</section>