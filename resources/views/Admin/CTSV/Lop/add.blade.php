@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Thêm lớp</h6>
    </div>
    <div class="card-body">
        <form action="{{route('insert_lop')}}" method="POST">
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
                <label>Tên ngành</label>
                <select name="nganh_id" class="form-control input-sm m-bot15">
                    @foreach($nganh as $key => $item)
                     <option value="{{$item->nganh_id}}">{{$item->nganh_ten}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="lop_ten">Tên lớp</label>
                <input type="text" class="form-control" name="lop_ten" placeholder="Nhập tên lớp">
                <span style="color: red;">
                    @error('lop_ten')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <input type="submit" class="btn btn-info mr-2 mt-2" value="Thêm">
            <a href="{{route('show_lop')}}" class="btn btn-danger mt-2">Quay lại</a>
        </form>
    </div>
</div>
@endsection