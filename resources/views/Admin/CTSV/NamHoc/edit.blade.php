@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Cập nhật năm học</h6>
    </div>
    <div class="card-body">
        <form action="{{route('update_namhoc', $namhoc->namhoc_id)}}" method="POST">
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
                <label for="namhoc_ten">Tên năm học</label>
                <input type="text" class="form-control" name="namhoc_ten" value="{{$namhoc->namhoc_ten}}">
            </div>
            <div class="form-group">
                <label for="namhoc_thoigianbatdau">Thời gian bắt đầu</label>
                <input type="datetime-local" class="form-control" name="namhoc_thoigianbatdau" 
                value="{{ date('Y-m-d\TH:i', strtotime($namhoc->namhoc_thoigianbatdau))}}">
            </div>
            <div class="form-group">
                <label for="namhoc_thoigianketthuc">Thời gian kết thúc</label>
                <input type="datetime-local" class="form-control" name="namhoc_thoigianketthuc"
                value="{{ date('Y-m-d\TH:i', strtotime($namhoc->namhoc_thoigianketthuc))}}">
            </div>
            <input type="submit" class="btn btn-info mr-2 mt-2" value="Cập nhật">
            <a href="{{route('show_namhoc')}}" class="btn btn-danger mt-2">Quay lại</a>
        </form>
    </div>
</div>
@endsection