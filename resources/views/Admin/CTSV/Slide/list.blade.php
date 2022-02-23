@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách slide</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                    <div class="d-flex justify-content-end">
                        <a href="{{route('add_slide')}}" class="btn btn-primary text-uppercase" title="Thêm">
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
                        <th class="col-md-3">Tên slide</th>
                        <th>Hình ảnh slide</th>
                        <th class="col-md-3">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($slide as $key => $item)
                    <tr>
                        <td>{{ $key + 1}}</td>
                        <td>{{ $item->slide_ten}}</td>
                        <td>
                            <img src="{{asset('public/Upload/Slide/'.$item->slide_hinhanh)}}" width="500px;" height="300px;">
                        </td>
                        <td>
                            <a href="{{route('edit_slide',$item->slide_id)}}" class="btn btn-success text-uppercase" title="Sửa">
                                <i class="bi bi-pen "></i>
                            </a>
                            <a href="{{route('delete_slide',$item->slide_id)}}" class="btn btn-danger text-uppercase delete" 
                            title="Xóa" onclick="return confirm('Bạn có muốn xóa slide này không?')"">
                                <i class="bi bi-x-octagon "></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
</div>
</div>
@endsection