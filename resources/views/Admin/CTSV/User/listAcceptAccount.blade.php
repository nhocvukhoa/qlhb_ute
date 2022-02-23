@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Duyệt đăng ký tài khoản</h6>
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
                        <th>Mã user</th>
                        <th>Tên đăng nhập</th>
                        <th>Tên nhà tài trợ</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th class="col-md-3">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listUser as $key => $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->fullname}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->diachi}}</td>
                        <td>{{$user->sdt}}</td>
                        <td>
                            <a href="{{route('active_user', $user->id)}}" class="btn btn-success text-uppercase" title="Duyệt">
                                <i class="bi bi-check2-circle"></i>
                            </a>
                            <a href="{{route('delete_user', $user->id)}}" class="btn btn-danger text-uppercase ml-2 delete" title="Xóa" 
                            onclick="return confirm('Bạn có muốn xóa tài khoản này không?')"">
                                <i class=" bi bi-x-octagon"></i>
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