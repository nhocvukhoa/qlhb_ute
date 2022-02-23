@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách điểm</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="margin-top: 20px;">
            <table class="table table-bordered" id="data" width="100%" cellspacing="0"> 
                <div class="d-flex col-md-12 flex-wrap" style="margin-bottom: 40px;">
                    <form action="{{route('filter_Diem')}}" method="GET">
                        <div class="flex flex-column col-md-2">
                            <label for="" class="text-primary" style="font-size: 18px;">Nhập số lượng</label>
                            <input @if($Soluong) value="{{$Soluong}}" @endif  type="number" class="col-md-12 form-control" name="soluong">
                        </div>
                        <div class="flex flex-column col-md-2">
                            <label for="" class="text-primary" style="font-size: 18px;">Chọn học kỳ</label>
                            <select name="diem_hocky" class="form-control">
                                @foreach($diem_hocky as $key => $hocky)
                                <option @if($Hocky==$hocky->diem_hocky) selected @endif value="{{$hocky->diem_hocky}}">{{$hocky->diem_hocky}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-column col-md-4">
                            <label for="" class="text-primary" style="font-size: 18px;">Chọn ngành</label>
                            <select name="nganh" class="form-control">
                                @foreach($nganh as $key => $item)
                                    <option @if($nganh_sv == $item->nganh_ten) selected  @endif value="{{$item->nganh_ten}}">{{$item->nganh_ten}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex align-items-end ml-3 mt-3">
                            <input type="submit" value="Lọc" class="btn btn-primary">
                        </div>
                        <div class="d-flex align-items-end">
                            <input type="button" onclick="export_data()" value="Export file excel" class="btn btn-success ml-3">
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
                        <th>Tín chỉ</th>
                        <th>Điểm thang 4</th>
                        <th>Điểm thang 10</th>
                        <th>Điểm rèn luyện</th>
                        <th>Loại học lực</th>
                        <th>Loại rèn luyện</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diem as $key => $item) 
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$item->diem_hocky}}</td>
                        <td>{{$item->diem_masv}}</td>
                        <td>{{$item->diem_tensv}}</td>
                        <td>{{date('d/m/Y', strtotime($item->diem_ngaysinh));}}</td>
                        <td>{{$item->diem_khoa}}</td>
                        <td>{{$item->diem_nganh}}</td>
                        <td>{{$item->diem_lop}}</td>
                        <td>{{$item->diem_tinchi}}</td>
                        <td>{{$item->diem_thang4}}</td>
                        <td>{{$item->diem_thang10}}</td>
                        <td>{{$item->diem_renluyen}}</td>
                        <td>{{$item->diem_loaihocluc}}</td>
                        <td>{{$item->diem_loairenluyen}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script>
    function export_data() {
        let data = document.getElementById('data');
        var fp = XLSX.utils.table_to_book(data, {sheet: 'sheet1'});
        XLSX.write(fp, {
            bookType: 'xlsx',
            type: 'base64'
        });
        XLSX.writeFile(fp, 'DanhSach.xlsx');
    }
</script>
@endsection