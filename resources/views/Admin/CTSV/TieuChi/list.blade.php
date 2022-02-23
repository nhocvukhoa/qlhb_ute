@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách tiêu chí</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{route('add_tieuchi')}}" class="btn btn-primary text-uppercase" title="Thêm">
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
                        <th>Tên tiêu chí</th>
                        <th class="col-md-3">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tieuchi as $key => $item)
                    <tr>
                        <td>{{$item->tieuchi_id}}</td>
                        <td>{{$item->tieuchi_ten}}</td>
                        <td>
                            <a href="{{route('edit_tieuchi',$item->tieuchi_id)}}" class="btn btn-success text-uppercase" title="Sửa">
                                <i class="bi bi-pen "></i>
                            </a>
                            <a href="{{route('delete_tieuchi',$item->tieuchi_id)}}" class="btn btn-danger text-uppercase delete" 
                            title="Xóa" onclick="return confirm('Bạn có muốn xóa tiêu chí này không?')"">
                                <i class="bi bi-x-octagon "></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
            <div class="col-sm-12 text-right text-center-xs mt-2">
                    <div class="pagination d-flex justify-content-center"> {{$tieuchi->links('paginationlinks')}}</div>
            </div>
        </div>
    </div>
</div>
@endsection