@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách điểm học tập các lớp</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="margin-top: 20px;">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <div class="form-group">
                    <?php
                    $message =  session()->get('message');
                    if ($message) {
                        echo '<p class="alert alert-success mt-2" id="alert-box">' . $message . '</p>';
                        session()->put('message', null);
                    }
                    ?>
                </div>
                <div class="d-flex col-md-12 flex-wrap" style="margin-bottom: 40px;">
                    <form action="{{route('filter_diemht_cbk')}}" method="GET">
                        <div class="flex flex-column col-md-2">
                            <label for="" class="text-primary" style="font-size: 18px;">Nhập số lượng</label>
                            <input type="number" class="col-md-12 form-control" name="soluong">
                        </div>
                        <div class="flex flex-column col-md-2">
                            <label for="" class="text-primary" style="font-size: 18px;">Chọn học kỳ</label>
                            <select name="diemhoctap_hocky" class="form-control">
                                @foreach($diemhoctap_hocky as $key => $hocky)
                                    <option  @if($Hocky==$hocky->diemhoctap_hocky) selected @endif value="{{$hocky->diemhoctap_hocky}}">{{$hocky->diemhoctap_hocky}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-column col-md-3">
                            <label for="" class="text-primary" style="font-size: 18px;">Chọn khoa</label>
                            <select name="diemhoctap_khoa" class="form-control">
                                @foreach($diemhoctap_khoa as $key => $khoa)
                                    <option @if($Khoa==$khoa->diemhoctap_khoa) selected @endif value="{{$khoa->diemhoctap_khoa}}">{{$khoa->diemhoctap_khoa}}</option>
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