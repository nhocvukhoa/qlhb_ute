@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Thêm ngành</h6>
    </div>
    <div class="card-body">
        <form action="{{route('insert_nganh')}}" method="POST">
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
                <label>Tên khoa</label>
                <select name="khoa_id" class="form-control input-sm m-bot15">
                    @foreach($khoa as $key => $item)
                     <option value="{{$item->khoa_id}}">{{$item->khoa_ten}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="khoa_ten">Tên ngành</label>
                <input type="text" class="form-control" name="nganh_ten" placeholder="Nhập tên ngành">
                <span style="color: red;">
                    @error('nganh_ten')
                    {{$message}}
                    @enderror
                </span>
            </div>
            <input type="submit" class="btn btn-info mr-2 mt-2" value="Thêm">
            <a href="{{route('show_nganh')}}" class="btn btn-danger mt-2">Quay lại</a>
        </form>
    </div>
</div>
@endsection