@extends('welcome')
@section('welcome_content')
<div class="header-title">
    <h1>DANH SÁCH HỌC BỔNG</h1>
</div>
@if($search_hocbong->isEmpty())
    <p style="color: red; font-size: 20px;">Không tìm thấy kết quả "{{ $result}}"</p>
@else
<div class="scholarship-list">
    @foreach($search_hocbong as $hocbong)
    <div class="col-lg-4 col-sm-6 mb-4 grid-tem">
        <div class="card shadow h-100">
            <img class="card-img-top" src="{{URL::to('public/Upload/HocBong/'.$hocbong->hocbong_hinhanh)}}"></img>
            @if($hocbong->hocbong_thoigianketthuc >= date('Y-m-d'))
                <span class="status2">Đang diễn ra</span>
            @else
                <span class="status">Đã kết thúc</span>
            @endif
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
@endif

<div class="row mt-4">
    <div class="col-sm-12 text-right text-center-xs">
        <div class="pagination d-flex justify-content-center mr-4"> {{$search_hocbong->links('paginationlinks')}}</div>
    </div>
</div>
<!--TODO: end Scholarship-->
@endsection