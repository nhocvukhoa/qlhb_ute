@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Cập nhật ngành</h6>
    </div>
    <div class="card-body">
        <form action="{{route('update_nganh', $nganh->nganh_id)}}" method="POST">
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
                <label>Tên khoa</label>
                <select name="khoa_id" class="form-control input-sm m-bot15">
                    @foreach($khoa as $key => $item)
                        @if($item->khoa_id==$nganh->khoa_id)
                            <option selected value="{{$item->khoa_id}}">{{$item->khoa_ten}}</option>
                        @else
                            <option value="{{$item->khoa_id}}">{{$item->khoa_ten}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="khoa_ten">Tên ngành</label>
                <input type="text" class="form-control" name="nganh_ten" placeholder="Nhập tên ngành"
                value="{{$nganh->nganh_ten}}">
                <span style="color: red;">
                    @error('nganh_ten')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <input type="submit" class="btn btn-info mr-2 mt-2" value="Cập nhật">
            <a href="{{route('show_nganh')}}" class="btn btn-danger mt-2">Quay lại</a>
        </form>
    </div>
</div>
@endsection