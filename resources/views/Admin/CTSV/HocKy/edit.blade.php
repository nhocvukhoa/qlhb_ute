@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Cập nhật học kỳ</h6>
    </div>
    <div class="card-body">
        <form action="{{route('update_hocky', $hocky->hocky_id)}}" method="POST">
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
                <label for="hocky_ten">Tên học kỳ</label>
                <input type="text" class="form-control" name="hocky_ten" value="{{$hocky->hocky_ten}}">
            </div>
            <div class="form-group">
                <label>Năm học</label>
                <select name="namhoc_id" class="form-control input-sm m-bot15">
                    @foreach($namhoc as $key => $item)
                    @if($item->namhoc_id==$hocky->namhoc_id)
                        <option selected value="{{$item->namhoc_id}}">{{$item->namhoc_ten}}</option>
                    @else
                        <option  value="{{$item->namhoc_id}}">{{$item->namhoc_ten}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="hocky_thoigianbatdau">Thời gian bắt đầu</label>
                <input type="datetime-local" class="form-control" name="hocky_thoigianbatdau" 
                value="{{ date('Y-m-d\TH:i', strtotime($hocky->hocky_thoigianbatdau))}}">
            </div>
            <div class="form-group">
                <label for="hocky_thoigianketthuc">Thời gian kết thúc</label>
                <input type="datetime-local" class="form-control" name="hocky_thoigianketthuc"
                value="{{ date('Y-m-d\TH:i', strtotime($hocky->hocky_thoigianketthuc))}}">
            </div>
            <input type="submit" class="btn btn-info mr-2 mt-2" value="Cập nhật">
            <a href="{{route('show_hocky')}}" class="btn btn-danger mt-2">Quay lại</a>
        </form>
    </div>
</div>
@endsection