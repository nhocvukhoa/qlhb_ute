@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Thêm cán bộ khoa</h6>
    </div>
    <div class="card-body">
        <form action="{{route('insert_canbo')}}" method="POST">
            @csrf
            <div class="form-group">
                <?php
                $message =  session()->get('message');
                if ($message) {
                    echo '<p class="alert alert-danger mt-2" id="alert-box">' . $message . '</p>';
                    session()->put('message', null);
                }
                ?>
            </div>
           
            <div class="form-group">
                <label for="name">Mã cán bộ</label>
                <input type="text" class="form-control" name="name" placeholder="Nhập mã cán bộ">
                <span style="color: red;">
                    @error('name')
                    {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu">
                <span style="color: red;">
                    @error('password')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="fullname">Họ tên cán bộ</label>
                <input type="text" class="form-control" name="fullname" placeholder="Nhập tên cán bộ">
                <span style="color: red;">
                    @error('fullname')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Nhập email">
                <span style="color: red;">
                    @error('email')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="diachi">Địa chỉ</label>
                <input type="text" class="form-control" name="diachi" placeholder="Nhập địa chỉ">
                <span style="color: red;">
                    @error('diachi')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="fullname">Số điện thoại</label>
                <input type="text" class="form-control" name="sdt" placeholder="Nhập số điện thoại">
                <span style="color: red;">
                    @error('sdt')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="gioitinh">Giới tính</label>
                <div class="col-sm-8">
                    <input type=radio name="gioitinh" class="mr-1" value="Nam" checked>Nam</option>
                     <input type=radio name="gioitinh" class="mr-1" value="Nữ">Nữ</option>            
                </div>
                <span style="color: red;">
                    @error('gioitinh')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="ngaysinh">Ngày sinh</label>
                <input type="date" class="form-control" name="ngaysinh">
                <span style="color: red;">
                    @error('ngaysinh')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label>Tên khoa</label>
                <select name="khoa_id" class="form-control input-sm m-bot15">
                    @foreach($khoa as $key => $item)
                     <option value="{{$item->khoa_id}}">{{$item->khoa_ten}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="chucvu">Chức vụ</label>
                <input type="text" class="form-control" name="chucvu" placeholder="Nhập chức vụ">
                <span style="color: red;">
                    @error('chucvu')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <input type="hidden" name="tinhtrang">
            <input type="hidden" name="quyen">
            <input type="hidden" name="canbo">
            <input type="hidden" name="ngayDuyetTV">
            <input type="submit" class="btn btn-info mr-2 mt-2" value="Thêm">
            <a href="{{route('show_canbo')}}" class="btn btn-danger mt-2">Quay lại</a>
        </form>
    </div>
</div>
@endsection