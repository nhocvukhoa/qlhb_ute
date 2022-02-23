@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Chi tiết học bổng</h6>
    </div>
    <div class="card-body">
        @foreach($detail_hocbong as $detail)
        <form action="">
            <div class="form-group row">
                <label class="col-sm-3">Tên học bổng :</label>
                <div class="col-sm-9">
                    <p class="mb-0">{{$detail->hocbong_ten}}</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3">Hình ảnh :</label>
                <div class="col-sm-9">
                    <img src="{{URL::to('/public/Upload/HocBong/'.$detail->hocbong_hinhanh)}}" 
                    style="width: 70%;"></img>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3">Loại học bổng :</label>
                <div class="col-sm-9">
                    <p class="mb-0">{{$detail->loaihocbong_ten}}</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3">Học kỳ :</label>
                <div class="col-sm-9">
                    <p class="mb-0">{{$detail->hocky_ten}}</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3">Hình thức duyệt :</label>
                <div class="col-sm-9">
                    <p class="mb-0">{{$detail->hinhthucduyet_ten}}</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3">Nội dung :</label>
                <div class="col-sm-9">
                    <p class="mb-0">{!! $detail->hocbong_noidung !!}</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3">Thời gian bắt đầu :</label>
                <div class="col-sm-9">
                    <p class="mb-0">{{date('d/m/Y', strtotime($detail->hocbong_thoigianbatdau));}}</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3">Thời gian kết thúc :</label>
                <div class="col-sm-9">
                    <p class="mb-0">{{date('d/m/Y', strtotime($detail->hocbong_thoigianketthuc));}}</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3">Kinh phí :</label>
                <div class="col-sm-9">
                    <p class="mb-0">{{number_format($detail->hocbong_kinhphi).' '.' VND'}}</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3">Tổng số lượng suất :</label>
                <div class="col-sm-9">
                    <p class="mb-0">{{$detail->hocbong_tongsoluong}}</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3">Người đăng :</label>
                <div class="col-sm-9">
                    <p class="mb-0">{{$detail->fullname}}</p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3">Thời gian đăng :</label>
                <div class="col-sm-9">
                    <p class="mb-0"> {{date('d/m/Y H:i', strtotime($detail->hocbong_thoigiandang))}}</p>
                </div>
            </div>
            <hr>
            <a href="{{route('list_post')}}" class="btn btn-danger mt-2">Quay lại</a>
        </form>
        @endforeach
    </div>
</div>
@endsection