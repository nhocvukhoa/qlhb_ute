@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách thông báo</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{route('add_thongbao')}}" class="btn btn-primary text-uppercase" title="Thêm">
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
                        <th>Tên thông báo</th>
                        <th>Mô tả</th>
                        <th>Nội dung</th>
                        <th>File đính kèm</th>
                        <th>Thời gian đăng</th>
                        <th>Người đăng</th>
                        <th>Hành động</th>
                    </tr>
                <tbody>
                    @foreach($thongbao as $key => $item)
                    <tr>
                        <td>{{$key+ $thongbao->firstItem()}}</td>
                        <td>{{ $item->thongbao_ten }}</td>
                        <td>{{ $item->thongbao_mota }}</td>
                        <td>{!! $item->thongbao_noidung !!}</td>
                        <td>
                            @if($item->thongbao_file)
                            <a href="{{asset('public/Upload/HoSo/'.$item->thongbao_file)}}" target="_blank">
                                Xem file
                            </a>
                            @else
                            Không có file đính kém
                            @endif
                        </td>
                        <td>{{date('d/m/Y H:i', strtotime($item->thongbao_thoigiandang))}}</td>
                        <td>{{ $item->fullname }}</td>
                        <td>
                            <a href="{{route('edit_thongbao', $item->thongbao_id)}}" class="btn btn-success text-uppercase mb-1 edit" title="Sửa">
                                <i class="bi bi-pen"></i>
                            </a>
                            <a href="{{route('delete_thongbao', $item->thongbao_id)}}" class="btn btn-danger text-uppercase delete mb-1" title="Xóa" 
                            onclick="return confirm('Bạn có muốn xóa thông báo này không?')"">
                                <i class=" bi bi-x-octagon"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </thead>
            </table>
            <div class="col-sm-12 text-right text-center-xs mt-2">
                <div class="pagination d-flex justify-content-center"> {{$thongbao->links('paginationlinks')}}</div>
            </div>
        </div>
    </div>
</div>
@endsection