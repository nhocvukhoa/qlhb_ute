@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Thống kê điểm học tập các lớp</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
           
                <thead>
                    <tr>
                        <th>Học kỳ</th>
                        <th>Tên lớp</th>
                        <th>Số lượng yếu</th>
                        <th>Số lượng trung bình</th>
                        <th>Số lượng khá</th>
                        <th>Số lượng giỏi</th>
                        <th>Số lượng xuất sắc</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diemhoctap as $key => $item)
                    <tr>
                        <th>{{$item->diem_hocky}}</th>
                        <td>{{$item->diem_lop}}</td>
                        <td>
                            {{$item->tong_yeu}}
                        </td>
                        <td>
                            {{$item->tong_trungbinh}}
                        </td>
                        <td>
                            {{$item->tong_kha}}
                        </td>
                        <td>
                           {{$item->tong_gioi}}
                        </td>
                        <td>
                           {{$item->tong_xuatsac}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
           
        </div>
    </div>
</div>
@endsection