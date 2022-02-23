@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Thống kê top 5 học bổng được đăng kí nhiều nhất</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên học bổng</th>
                        <th>Số lượng đăng ký</th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($danhsach as $key => $item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->hocbong_ten}}</td>
                        <td>{{$item->total_amount}}</td>
                    </tr>
                   @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection