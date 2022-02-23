@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Duyệt bài đăng học bổng của nhà tài trợ</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
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
                        <th>Tên học bổng</th>
                        <th>Loại học bổng</th>
                        <th>Học kỳ</th>
                        <th>Thời gian bắt đầu</th>
                        <th>Thời gian kết thúc</th>
                        <th>Tình trạng</th>
                        <th>Người đăng</th>
                        <th class="col-md-2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                  
                     <?php $index= 0;?>
                    @foreach($listHocBong as $hocbong)
                    <?php $index++; ?>
                    <tr>
                        <td>{{$index}}</td>
                        <td>{{$hocbong->hocbong_ten}}</td>
                        <td>{{$hocbong->loaihocbong_ten}}</td>
                        <td>{{$hocbong->hocky_ten}}</td>
                        <td>{{date('d/m/Y', strtotime($hocbong->hocbong_thoigianbatdau));}}</td>
                        <td>{{date('d/m/Y', strtotime($hocbong->hocbong_thoigianketthuc));}}</td>
                        <td>
                            @if($hocbong->hocbong_tinhtrang ==0) 
                                Chưa được duyệt
                            @else
                                Đã duyệt
                            @endif
                        </td>
                        <td>{{$hocbong->fullname}}</td>
                        <td>
                            <a href="{{route('active_post',$hocbong->hocbong_id)}}" class="btn btn-success text-uppercase" title="Duyệt">
                                <i class="bi bi-check2-circle"></i>
                            </a>
                            <a href="{{route('detail_post',$hocbong->hocbong_id)}}" class="btn btn-info text-uppercase detail" title="Xem chi tiết">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{route('delete_post',$hocbong->hocbong_id)}}" class="btn btn-danger text-uppercase  delete" 
                            title="Xóa" onclick="return confirm('Bạn có muốn học bổng này không?')"">
                                <i class="bi bi-x-octagon"></i>
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