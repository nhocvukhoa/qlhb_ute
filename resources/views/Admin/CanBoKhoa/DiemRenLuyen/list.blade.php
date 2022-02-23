@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách điểm rèn luyện</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="margin-top: 20px;">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <div class="d-flex justify-content-end col-md-12">
                    <form action="{{route('export_diemrl_cbk')}}" method="GET" enctype="multipart/form-data">
                        <input type="submit" value="Export" name="export_csv" class="btn btn-success ml-3">
                    </form>
                </div>
                <div class="d-flex col-md-12 flex-wrap" style="margin-bottom: 40px;">
                    <form action="{{route('filter_diemrl_cbk')}}" method="GET">
                        <div class="flex flex-column col-md-2">
                            <label for="" class="text-primary" style="font-size: 18px;">Nhập số lượng</label>
                            <input type="number" class="col-md-12 form-control" name="soluong">
                        </div>
                        <div class="flex flex-column col-md-2">
                            <label for="" class="text-primary" style="font-size: 18px;">Chọn học kỳ</label>
                            <select name="diemrenluyen_hocky" class="form-control">
                                @foreach($diemrenluyen_hocky as $key => $hocky)
                                <option @if($Hocky==$hocky->diemrenluyen_hocky) selected @endif value="{{$hocky->diemrenluyen_hocky}}">{{$hocky->diemrenluyen_hocky}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-column col-md-3">
                            <label for="" class="text-primary" style="font-size: 18px;">Chọn khoa</label>
                            <select name="diemrenluyen_khoa" class="form-control">
                                @foreach($diemrenluyen_khoa as $key => $khoa)
                                <option @if($Khoa==$khoa->diemrenluyen_khoa) selected @endif value="{{$khoa->diemrenluyen_khoa}}">{{$khoa->diemrenluyen_khoa}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-column col-md-3">
                            <label for="" class="text-primary" style="font-size: 18px;">Chọn ngành</label>
                            <select name="diemrenluyen_nganh" class="form-control">
                                @foreach($diemrenluyen_nganh as $key => $nganh)
                                <option @if($Nganh==$nganh->diemrenluyen_nganh) selected @endif value="{{$nganh->diemrenluyen_nganh}}">{{$nganh->diemrenluyen_nganh}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-column col-md-2">
                            <label for="" class="text-primary" style="font-size: 18px;">Chọn lớp</label>
                            <select name="diemrenluyen_lop" class="form-control">
                                @foreach($diemrenluyen_lop as $key => $lop)
                                <option @if($Lop==$lop->diemrenluyen_lop) selected @endif value="{{$lop->diemrenluyen_lop}}">{{$lop->diemrenluyen_lop}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex align-items-end ml-3 mt-3">
                            <input type="submit" value="Lọc" class="btn btn-primary">
                        </div>
                    </form>
                </div>

                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Học kỳ</th>
                        <th>MSV</th>
                        <th>Tên sinh viên</th>
                        <th>Ngày sinh</th>
                        <th>Khoa</th>
                        <th>Ngành</th>
                        <th>Lớp</th>
                        <th>Điểm</th>
                        <th>Xếp loại</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diemrenluyen as $key => $item)
                    <tr>
                        <td>{{$item->diemrenluyen_id}}</td>
                        <td>{{$item->diemrenluyen_hocky}}</td>
                        <td>{{$item->diemrenluyen_msv}}</td>
                        <td>{{$item->diemrenluyen_tensv}}</td>
                        <td>{{date('d-m-Y', strtotime($item->diemrenluyen_ngaysinh));}}</td>
                        <td>{{$item->diemrenluyen_khoa}}</td>
                        <td>{{$item->diemrenluyen_nganh}}</td>
                        <td>{{$item->diemrenluyen_lop}}</td>
                        <td>{{$item->diemrenluyen_diem}}</td>
                        <td>{{$item->diemrenluyen_xeploai}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-sm-12 text-right text-center-xs mt-2">
                <div class="pagination d-flex justify-content-center"> {{$diemrenluyen->links('paginationlinks')}}</div>
            </div>
        </div>
    </div>
</div>
@endsection