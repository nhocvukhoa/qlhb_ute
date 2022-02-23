@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách học kỳ</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <div class="d-flex justify-content-between">
                    <div>
                        <form action="{{route('search_hocky')}}" method="GET">
                            @csrf
                            <div class="search-box d-flex">
                                <input type="search" class="search-txt form-control mr-2 col-md-7" name="search" placeholder="Nhập tên học kỳ ...">
                                <input type="submit" class="btn btn-info btn-sm mr-4" value="Tìm kiếm" name="search_items">
                            </div>
                        </form>
                    </div>
                    <a href="{{route('add_hocky')}}" class="btn btn-primary text-uppercase" title="Thêm">
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
                        <th>STT</th>
                        <th>Năm học</th>
                        <th>Tên học kỳ</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian kết thúc</th>
                        <th class="col-md-2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hocky as $key => $item)
                    <tr>
                        <td>{{($item->hocky_id)}}</td>
                        <td>{{$item->namhoc_ten}}</td>
                        <td>{{$item->hocky_ten}}</td>
                        <td>{{date('d-m-Y H:i:s', strtotime($item->hocky_thoigianbatdau))}}</td>
                        <td>{{date('d-m-Y H:i:s', strtotime($item->hocky_thoigianketthuc))}}</td>
                        <td>
                            <a href="{{route('edit_hocky',$item->hocky_id)}}" class="btn btn-success text-uppercase" title="Sửa">
                                <i class="bi bi-pen "></i>
                            </a>
                            <a href="{{route('delete_hocky',$item->hocky_id)}}" class="btn btn-danger text-uppercase delete" title="Xóa" onclick="return confirm('Bạn có muốn xóa học kỳ này không?')"">
                                <i class=" bi bi-x-octagon "></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-sm-12 text-right text-center-xs mt-2">
                    <div class="pagination d-flex justify-content-center"> {{$hocky->links('paginationlinks')}}</div>
            </div>
    </div>
</div>
</div>
@endsection