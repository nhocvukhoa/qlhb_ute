@extends('Client.Layout.index')
@section('content')
<section class="post-history">
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul id="breadcrumb" style="width: 100%;">
                        <li><a href="{{route('home')}}"><span class="icon fas fa-home mr-2"></span>Trang chủ</a></li>
                        <li><a href="#"><span class="icon fas fa-list mr-2"></span>Danh sách học bổng đã đăng ký</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="line3"></div>
            <div class="card shadow mb-4" style="margin-top: 10px;">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-center" style="font-size:20px;">Danh sách học bổng đã đăng ký</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                            <div class="d-flex justify-content-end mb-3">
                            </div>
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Mã sinh viên</th>
                                    <th class="text-center col-md-2">Tên học bổng</th>
                                    <th>Thời gian đăng ký</th>
                                    <th>Tình trạng</th>
                                    <th>Kết quả</th>
                                    <th>Người duyệt</th>
                                    <th>Thời gian duyệt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listRegistered as $key=> $item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->user_name}}</td>
                                    <td>{{$item->hocbong_ten}}</td>
                                    <td>{{date('d-m-Y H:i:s', strtotime($item->dangky_thoigiandk))}}</td>
                                    <td>
                                        @if($item->dangky_tinhtrang == 0)
                                            Chưa duyệt
                                        @else
                                            Đã duyệt
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->loaihocbong_id == 1)
                                            @if($item->dangky_ketqua == 0)
                                                Chưa xác định
                                            @else
                                                Được nhận điểm thưởng
                                            @endif
                                        @else
                                            @if($item->dangky_ketqua == 0)
                                                Chưa xác định
                                            @else
                                                Được nhận học bổng
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->dangky_nguoiduyet == NULL)
                                            <p>Chưa có người duyệt</p>
                                        @else
                                            {{$item->dangky_nguoiduyet}}</td>
                                        @endif
                                    <td>
                                        @if($item->dangky_thoigianduyet == NULL)
                                        <p>Chưa xác định</p>
                                        @else
                                        {{date('d-m-Y H:i:s', strtotime($item->dangky_thoigianduyet))}}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection