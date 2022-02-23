@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách điểm học tập các lớp</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="margin-top: 20px;">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
              
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Học kỳ</th>
                        <th>Mã sinh viên</th>
                        <th>Tên sinh viên</th>
                        <th>Ngày sinh</th>
                        <th>Khoa</th>
                        <th>Ngành</th>
                        <th>Lớp</th>
                        <th>Tín chỉ</th>
                        <th>Điểm thang 4</th>
                        <th>Điểm thang 10</th>
                        <th>Xếp loại</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diemhoctap as $key => $item)
                    <tr>
                        <td>{{$key+ $diemhoctap->firstItem()}}</td>
                        <td>{{$item->diemhoctap_hocky}}</td>
                        <td>{{$item->diemhoctap_msv}}</td>
                        <td>{{$item->diemhoctap_tensv}}</td>
                        <td>{{date('d-m-Y', strtotime($item->diemhoctap_ngaysinh));}}</td>
                        <td>{{$item->diemhoctap_khoa}}</td>
                        <td>{{$item->diemhoctap_nganh}}</td>
                        <td>{{$item->diemhoctap_lop}}</td>
                        <td>{{$item->diemhoctap_tinchi}}</td>
                        <td>{{$item->diemhoctap_thang4}}</td>
                        <td>{{$item->diemhoctap_thang10}}</td>
                        <td>{{$item->diemhoctap_xeploai}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-sm-12 text-right text-center-xs mt-2">
                <div class="pagination d-flex justify-content-center"> {{$diemhoctap->links('paginationlinks')}}</div>
            </div>
        </div>
    </div>
</div>
@endsection