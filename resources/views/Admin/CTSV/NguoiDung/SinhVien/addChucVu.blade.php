@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Cập nhật chức vụ</h6>
    </div>
    <div class="card-body">
        <form action="{{route('update_canbo_sinhvien',$sinhvien->id)}}" method="POST" enctype="multipart/form-data">
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
            <input type="hidden" name="canbo">
            <div class="form-group">
                <label for="thongbao_ten">Tên chức vụ</label>
                <input type="text" class="form-control" name="chucvu" value="{{$sinhvien->chucvu}}">
                <span style="color: red;">
                    @error('chucvu')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <input type="submit" class="btn btn-info mr-2 mt-2" value="Thêm">
            <a href="{{route('show_sinhvien')}}" class="btn btn-danger mt-2">Quay lại</a>
        </form>
    </div>
</div>
@endsection

