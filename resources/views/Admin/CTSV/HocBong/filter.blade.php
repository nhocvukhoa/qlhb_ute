@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách đăng ký {{ $get_hocbong_ten}}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <div class="d-flex justify-content-end mb-3">
                    <form action="{{route('filter.note_admin', ['hocbong_id'=> $hocbong_id])}}" method="GET">
                        <select name="dangky_ghichu" class="form-control col-md-2">
                            @foreach($dangky_ghichu as $key => $item)
                            <option @if($Ghichu==$item->dangky_ghichu) selected @endif value="{{$item->dangky_ghichu}}">
                                {{$item->dangky_ghichu}}
                            </option>
                            @endforeach
                        </select>
                        <input type="submit" class="btn btn-info ml-2 mr-2" value="Lọc"></input>
                    </form>
                    <form action="{{route('export_selected_list', ['hocbong_id' => $hocbong_id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="submit" value="Export file excel" name="export_csv" class="btn btn-success">
                    </form>
                    <form action="{{route('return.apply_hocbong',['hocbong_id' => $hocbong_id])}}" method="GET">
                        @foreach($user_apply as $key => $item) 
                            <input type="hidden" name="hocbong_id" value="{{$item->hocbong_id}}">
                        @endforeach
                        <input type="submit" value="Quay về"  class="btn btn-danger ml-2">
                    </form>
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
                        <th>Mã sinh viên</th>
                        <th>Tên sinh viên</th>
                        <th>Ngành</th>
                        <th>Lớp</th>
                        <th>Thời gian đăng ký</th>
                        <th>Tình trạng</th>
                        <th>Kết quả</th>
                        <th>Ghi chú</th>
                        <th class="col-md-1">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($user_apply as $key => $user)
                    <tr>
                        <input type="hidden" name="hocbong_id" value="{{$user->hocbong_id}}">
                        <td>{{$key+ 1}}</td>
                        <td>{{ $user->user_name}}</td>
                        <td>{{ $user->user_fullname}}</td>
                        <td>{{ $user->user_nganh}}</td>
                        <td>{{ $user->user_lop}}</td>
                        <td>{{date('d-m-Y H:i:s', strtotime($user->dangky_thoigiandk))}}</td>
                        <td>
                            @if($user->dangky_tinhtrang == 0)
                                Chưa duyệt
                            @else
                                Đã duyệt
                            @endif
                        </td>
                        <td>
                            @if($user->loaihocbong_id == 1)
                                 @if($user->dangky_ketqua == 0)
                                    Chưa xác định
                                @else
                                    Được nhận điểm thưởng
                                @endif
                            @else
                                @if($user->dangky_ketqua == 0)
                                    Chưa xác định
                                @else
                                    Được nhận học bổng
                                @endif
                            @endif
                        </td>
                        <td>
                            {{$user->dangky_ghichu}}
                        </td>
                        <td class="col-md-2">
                            <a href="{{route('apply_detail_hocbong',['dangky_id' => $user->dangky_id])}}" class="btn btn-info text-uppercase mb-1 detail" title="Xem hồ sơ">
                                Xem hồ sơ
                            </a>
                            @if($total < $user->hocbong_tongsoluong)
                                @if($user->dangky_ketqua == 1)
                                    <button class="btn btn-danger text-uppercase" disabled="disabled">Đã duyệt</button>
                                @else
                                    <a href="{{route('apply_accept_filterNote',['dangky_id' => $user->dangky_id])}}" class="btn btn-danger text-uppercase mb-1 detail" title="Xem hồ sơ">
                                        Duyệt
                                    </a>
                                @endif
                            @else
                                <button class="btn btn-danger" disabled="disabled">Đã duyệt đủ</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <p class="mb-2 text-danger" style="font-size: 18px;">* Tổng số suất học bổng : {{$get_hocbong_soluong}} </p>
                <p class="mb-2 text-danger" style="font-size: 18px;">* Đã duyệt {{$total}} / {{$total_apply}} hồ sơ đăng ký</p>
            </table>
        </div>
    </div>
</div>




@endsection