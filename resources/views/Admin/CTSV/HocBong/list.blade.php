@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách học bổng</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <div class="d-flex justify-content-between">
                    <div>
                        <form action="{{route('search_hocbong')}}" method="GET">
                            @csrf
                            <div class="search-box d-flex">
                                <input type="search" class="search-txt form-control mr-2 col-md-7" name="search" 
                                placeholder="Nhập tên học bổng ...">
                                <input type="submit" class="btn btn-info btn-sm mr-4" value="Tìm kiếm" name="search_items">
                            </div>
                        </form>
                    </div>
                    <a href="{{route('add_hocbong')}}" class="btn btn-primary text-uppercase" title="Thêm">
                        <i class="bi bi-plus-circle mr-2"></i>Thêm
                    </a>
                </div>
                <div class="form-group">
                    <?php
                    $message =  session()->get('message');
                    if ($message) {
                        echo '<p class="alert alert-success mt-2" id="alert-box">' . $message . '</p>';
                        session()->put('message', null);
                    }
                    ?>
                </div>
                <thead>
                    <tr>
                        <th>Mã HB</th>
                        <th>Tên học bổng</th>
                        <th>Loại học bổng</th>
                        <th>Học kỳ</th>
                        <th>TG bắt đầu</th>
                        <th>TG kết thúc</th>
                        <th>Người đăng</th>
                        <th>Tình trạng</th>
                        <th>Người duyệt</th>
                        <th>Thời gian duyệt</th>
                        <th class="col-md-2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listHocBong as $key => $hocbong)
                    <tr>
                        <td>{{$key+ $listHocBong->firstItem()}}</td>
                        <td>{{$hocbong->hocbong_ten}}</td>
                        <td>{{$hocbong->loaihocbong_ten}}</td>
                        <td>{{$hocbong->hocky_ten}}</td>
                        <td>{{date('d/m/Y', strtotime($hocbong->hocbong_thoigianbatdau));}}</td>
                        <td>{{date('d/m/Y', strtotime($hocbong->hocbong_thoigianketthuc));}}</td>
                        <td>{{$hocbong->fullname}}</td>
                        <td>
                            @if($hocbong->hocbong_tinhtrang == 0)
                            Chưa được duyệt
                            @else
                            Đã duyệt
                            @endif
                        </td>
                        <td>{{$hocbong->hocbong_nguoiduyet}}</td>
                        <td>{{date('d/m/Y H:i', strtotime($hocbong->hocbong_ngayduyet))}}</td>
                        <td>
                            <a href="{{route('edit_hocbong', $hocbong->hocbong_id)}}" class="btn btn-success text-uppercase mb-1 edit" title="Sửa">
                                <i class="bi bi-pen"></i>
                            </a>
                            <!-- <a href="{{route('delete_hocbong', $hocbong->hocbong_id)}}" class="btn btn-danger text-uppercase delete mb-1" title="Xóa" onclick="return confirm('Bạn có muốn xóa học bổng này không?')"">
                                <i class=" bi bi-x-octagon"></i>
                            </a> -->
                            <a href="{{route('detail_hocbong', $hocbong->hocbong_id)}}" class="btn btn-info text-uppercase mb-1 detail" title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{route('apply_hocbong', $hocbong->hocbong_id)}}" class="btn btn-warning text-uppercase mb-1" title="Xem danh sách đăng ký">
                                <i class="bi bi-list-check"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
        </div>
        </table>
        <div class="col-sm-12 text-right text-center-xs mt-2">
            <div class="pagination d-flex justify-content-center"> {{$listHocBong->links('paginationlinks')}}</div>
        </div>
    </div>
</div>
</div>




@endsection