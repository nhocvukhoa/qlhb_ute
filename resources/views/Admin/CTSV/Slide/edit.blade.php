@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Cập nhật slide</h6>
    </div>
    <div class="card-body">
        <form action="{{route('update_slide',$slide->slide_id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="slide_ten">Tên slide</label>
                <input type="text" class="form-control" name="slide_ten"  value="{{$slide->slide_ten}}">
            </div>
            <div class="form-group">
                <label for="slide_hinhanh">Hình ảnh slide</label>
                <div class="custom-file">
                    <input type="file" name="slide_hinhanh" class="custom-file-input" id="inputGroupFile02"/>
                    <label class="custom-file-label" for="inputGroupFile02">{{$slide->slide_hinhanh}}</label>
                </div>
            </div>
            <input type="submit" class="btn btn-info mr-2 mt-2" value="Cập nhật">
            <a href="{{route('show_slide')}}" class="btn btn-danger mt-2">Quay lại</a>
        </form>
    </div>
</div>

@endsection