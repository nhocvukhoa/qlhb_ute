@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách ngành</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <div class="d-flex justify-content-between">
                    <div>
                        <form action="{{route('search_nganh')}}" method="GET">
                            @csrf
                            <div class="search-box d-flex">
                                <input type="search" class="search-txt form-control mr-2 col-md-7" name="search" 
                                placeholder="Nhập tên ngành ...">
                                <input type="submit" class="btn btn-info btn-sm mr-4" value="Tìm kiếm" name="search_items">
                            </div>
                        </form>
                    </div>
                    <a href="{{route('add_nganh')}}" class="btn btn-primary text-uppercase" title="Thêm">
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
                        <th class="col-md-2">Mã ngành</th>
                        <th class="col-md-2">Tên khoa</th>
                        <th>Tên ngành</th>
                        <th class="col-md-2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 0;
                    ?>
                    @foreach($nganh as $item)
                    <?php
                    $index++;
                    ?>
                    <tr>
                        <td>{{$item->nganh_id}}</td>
                        <td>{{$item->khoa_ten}}</td>
                        <td>{{$item->nganh_ten}}</td>
                        <td>
                            <a href="{{route('edit_nganh', $item->nganh_id)}}" class="btn btn-success" title="Sửa">
                                <i class="bi bi-pen "></i>
                            </a>
                            <a href="{{route('delete_nganh', $item->nganh_id)}}" class="btn btn-danger delete" 
                            title="Xóa" onclick="return confirm('Bạn có muốn xóa ngành này không?')"">
                                <i class="bi bi-x-octagon "></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-sm-12 text-right text-center-xs mt-2">
                <div class="pagination d-flex justify-content-center"> {{$nganh->links('paginationlinks')}}</div>
            </div>
        </div>
    </div>
</div>
@endsection