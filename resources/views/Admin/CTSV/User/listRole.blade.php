@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Thiết lập quyền</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <form action="{{route('search_user')}}" method="GET">
                        @csrf
                        <div class="search-box d-flex">
                            <input type="search" class="search-txt form-control mr-2 col-md-3" name="search" 
                            placeholder="Nhập tên nhà tài trợ ...">
                            <input type="submit" class="btn btn-info btn-sm mr-4" value="Tìm kiếm" name="search_items">
                        </div>
                </form>
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
                        <th>Tên đăng nhập</th>
                        <th>Tên nhà tài trợ</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Tình trạng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($userRole as $key => $user)
                    <tr>
                        <td>{{$key+ $userRole->firstItem()}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->fullname}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->diachi}}</td>
                        <td>{{$user->sdt}}</td>
                        <td>
                            @if($user->tinhtrang == 0)
                                Khóa
                            @else
                                Đang hoạt động
                            @endif
                        </td>
                        <td>
                        <?php
                            if ($user->tinhtrang == 0) {
                            ?>
                            <a  href="{{route('open_user', $user->id)}}" class="btn btn-danger" title="Mở khóa">
                                <i class="fas fa-key"></i>
                            </a>
                            <?php
                            } else {
                            ?>
                            <a  href="{{route('blocked_user', $user->id)}}" class="btn btn-success mr-2" title="Khóa">
                                 <i class="bi bi-check2-circle"></i>
                            </a>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-sm-12 text-right text-center-xs mt-2">
                <div class="pagination d-flex justify-content-center"> {{$userRole->links('paginationlinks')}}</div>
            </div>
        </div>
    </div>
</div>
@endsection