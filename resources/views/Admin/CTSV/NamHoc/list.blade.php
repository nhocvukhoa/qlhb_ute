@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách năm học</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <div class="d-flex justify-content-between">
                    <div>
                        <form action="{{route('search_namhoc')}}" method="GET">
                            @csrf
                            <div class="search-box d-flex">
                                <input type="search" class="search-txt form-control mr-2 col-md-7" name="search" 
                                placeholder="Nhập tên năm học ...">
                                <input type="submit" class="btn btn-info btn-sm mr-4" value="Tìm kiếm" name="search_items">
                            </div>
                        </form>
                    </div>
                    <a href="{{route('add_namhoc')}}" class="btn btn-primary text-uppercase" title="Thêm">
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
                        <th>Tên năm học</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian kết thúc</th>
                        <th class="col-md-2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($namhoc as $key => $item)
                    <tr>
                        <td>{{$item->namhoc_id}}</td>
                        <td>{{$item->namhoc_ten}}</td>
                        <td>{{date('d-m-Y H:i:s', strtotime($item->namhoc_thoigianbatdau))}}</td>
                        <td>{{date('d-m-Y H:i:s', strtotime($item->namhoc_thoigianketthuc))}}</td>
                        <td>
                            <a href="{{route('edit_namhoc',$item->namhoc_id)}}" class="btn btn-success text-uppercase" title="Sửa">
                                <i class="bi bi-pen "></i>
                            </a>
                            <a href="{{route('delete_namhoc',$item->namhoc_id)}}" class="btn btn-danger text-uppercase delete" title="Xóa" onclick="return confirm('Bạn có muốn xóa năm học này không?')"">
                                <i class=" bi bi-x-octagon "></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-sm-12 text-right text-center-xs mt-2">
                    <div class="pagination d-flex justify-content-center"> {{$namhoc->links('paginationlinks')}}</div>
            </div>
    </div>
</div>
</div>
@endsection