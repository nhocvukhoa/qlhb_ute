@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Thông tin cán bộ khoa</h6>
    </div>
    <div class="card-body">
        <div class="col-lg-12">
            <?php
            $message =  session()->get('message');
            if ($message) {
                echo '<p class="alert alert-success" id="alert-box">' . $message . '</p>';
                session()->put('message', null);
            }
            ?>
            <form action="{{route('update_cbk')}}" method="POST">
                @csrf
                <div class="form-group">
                    <?php
                    $message =  session()->get('message');
                    if ($message) {
                        echo '<p class="alert alert-success mt-2" id="alert-box">' . $message . '</p>';
                        session()->put('message', null);
                    }
                    ?>
                </div>
                <div class="form-row">
                    <div class="form-group d-flex align-items-center col-md-6">
                        <label class="col-md-4" style="margin-bottom: 0!important;">Mã cán bộ :</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name" value="{{$cbk->name}}" disabled>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center col-md-6">
                        <label class="col-md-4" style="margin-bottom: 0!important;">Khoa :</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="email" value="{{$cbk->khoa_ten}}" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group d-flex align-items-center col-md-6">
                        <label class="col-md-4" style="margin-bottom: 0!important;">Chức vụ :</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="fullname" value="{{$cbk->chucvu}}" disabled>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center col-md-6">
                        <label class="col-md-4" style="margin-bottom: 0!important;">Họ và tên :</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="email" value="{{$cbk->fullname}}" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group d-flex align-items-center col-md-6">
                        <label class="col-md-4" style="margin-bottom: 0!important;">Email :</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="email" value="{{$cbk->email}}" disabled>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center col-md-6">
                        <label class="col-md-4" style="margin-bottom: 0!important;">Số điện thoại :</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="sdt" value="{{$cbk->sdt}}">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group d-flex align-items-center col-md-6">
                        <label class="col-md-4" style="margin-bottom: 0!important;">Giới tính :</label>
                        <div class="col-md-8">
                            <input type=radio name="gioitinh" class="mr-1" value="Nam" {{ $cbk->gioitinh == 'Nam' ? 'checked' : ''}}>Nam</option>
                            <input type=radio name="gioitinh" class="mr-1" value="Nữ" {{ $cbk->gioitinh == 'Nữ' ? 'checked' : ''}}>Nữ</option>
                        </div>
                    </div>
                    <div class="form-group d-flex align-items-center col-md-6">
                        <label class="col-md-4" style="margin-bottom: 0!important;">Ngày sinh :</label>
                        <div class="col-md-8">
                            <input type="date" class="form-control" name="ngaysinh" value="{{ date('Y-m-d', strtotime($cbk->ngaysinh)) }}">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group d-flex align-items-center col-md-6">
                        <label class="col-md-4" style="margin-bottom: 0!important;">Địa chỉ :</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="diachi" value="{{$cbk->diachi}}">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="d-flex align-items-center" style="justify-content: center;">
                    <input type="submit" class="btn btn-info mr-2 mt-2" value="Cập nhật">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection