@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Cập nhật lớp</h6>
    </div>
    <div class="card-body">
        <form action="{{route('update_lop',$lop->lop_id)}}" method="POST">
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
                <label>Ngành</label>
                <select name="nganh_id" class="form-control input-sm m-bot15">
                    @foreach($nganh as $key => $item)
                    @if($item->nganh_id==$lop->nganh_id)
                        <option selected value="{{$item->nganh_id}}">{{$item->nganh_ten}}</option>
                    @else
                        <option  value="{{$item->nganh_id}}">{{$item->nganh_ten}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="khoa_ten">Tên ngành</label>
                <input type="text" class="form-control" name="lop_ten" placeholder="Nhập tên ngành"
                value="{{$lop->lop_ten}}">
                <span style="color: red;">
                    @error('lop_ten')
                        {{$message}}
                    @enderror
                </span>
            </div>
            <input type="submit" class="btn btn-info mr-2 mt-2" value="Cập nhật">
            <a href="{{route('show_lop')}}" class="btn btn-danger mt-2">Quay lại</a>
        </form>
    </div>
</div>
@endsection