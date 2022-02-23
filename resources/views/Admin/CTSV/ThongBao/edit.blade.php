@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Cập nhật thông báo</h6>
    </div>
    <div class="card-body">
        <form action="{{route('update_thongbao',$thongbao->thongbao_id)}}" method="POST" enctype="multipart/form-data">
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
                <label for="thongbao_ten">Tên thông báo</label>
                <input type="text" class="form-control" name="thongbao_ten" value="{{$thongbao->thongbao_ten}}">
                <span style="color: red;">
                    @error('thongbao_ten')
                    {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="thongbao_mota">Mô tả</label>
                <textarea style="resize: none;" rows="2" class="form-control" name="thongbao_mota">{{$thongbao->thongbao_mota}}</textarea>
                <span style="color: red;">
                    @error('thongbao_mota')
                    {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="thongbao_noidung">Nội dung</label>
                <textarea style="resize: none;" rows="5" class="form-control" name="thongbao_noidung" id="thongbao_noidung">
                {{$thongbao->thongbao_noidung}}
                </textarea>
                <span style="color: red;">
                    @error('thongbao_noidung')
                    {{$message}}
                    @enderror
                </span>
            </div>
            <div class="form-group">
                <label for="thongbao_file">File đính kèm</label>
                <input type="file" class="form-control" name="document">
                @if($thongbao->thongbao_file)
                    <a href="{{asset('public/Upload/ThongBao/'.$thongbao->thongbao_file)}}">
                        Xem file
                    </a>
                @else
                    Không có file đính kém
                @endif
            </div>
            <input type="hidden" name="thongbao_thoigiancapnhat">

            <input type="submit" class="btn btn-info mr-2 mt-2" value="Cập nhật">
            <a href="{{route('show_thongbao')}}" class="btn btn-danger mt-2">Quay lại</a>
        </form>
    </div>
</div>
@endsection

@section('ckeditor_content')
<script>
    ClassicEditor
        .create(document.querySelector('#thongbao_noidung'))
        .catch(error => {
            console.error(error);
        });
</script>

@endsection