@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Thêm tiêu chí</h6>
    </div>
    <div class="card-body">
        <form action="{{route('insert_tieuchi')}}" method="POST">
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
            <div class="form-group">
                <label for="tieuchi_ten">Tên tiêu chí</label>
                <input type="text" class="form-control" name="tieuchi_ten" placeholder="Nhập tên tiêu chí">
                <span style="color: red;">
                    @error('tieuchi_ten')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <input type="submit" class="btn btn-info mr-2 mt-2" value="Thêm">
            <a href="{{route('show_tieuchi')}}" class="btn btn-danger mt-2">Quay lại</a>
        </form>
    </div>
</div>
@endsection