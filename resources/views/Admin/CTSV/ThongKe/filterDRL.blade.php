@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Thống kê điểm rèn luyện sau khi lọc</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <div class="d-flex col-md-12 flex-wrap" style="margin-bottom: 40px;">
                    <form action="{{'thongke_filter_drl'}}" method="GET">
                        <div class="flex flex-column col-md-2">
                            <label for="" class="text-primary" style="font-size: 18px;">Chọn học kỳ</label>
                            <select name="diemrenluyen_hocky" class="form-control">
                                @foreach($diemrenluyen_hocky as $key => $hocky)
                                <option @if($Hocky==$hocky->diemrenluyen_hocky) selected @endif value="{{$hocky->diemrenluyen_hocky}}">{{$hocky->diemrenluyen_hocky}}</option>
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
                        <th>Tên lớp</th>
                        <th>Số lượng kém</th>
                        <th>Số lượng yếu</th>
                        <th>Số lượng trung bình</th>
                        <th>Số lượng khá</th>
                        <th>Số lượng tốt</th>
                        <th>Số lượng xuất sắc</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diemrenluyen as $key => $item)
                    <tr>
                        <td>{{$key+ $diemrenluyen->firstItem()}}</td>
                        <th>{{$item->diemrenluyen_hocky}}</th>
                        <td>{{$item->diemrenluyen_lop}}</td>
                        <td>
                            {{$item->tong_kem}}
                        </td>
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
                            {{$item->tong_tot}}
                        </td>
                        <td>
                            {{$item->tong_xuatsac}}
                        </td>
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