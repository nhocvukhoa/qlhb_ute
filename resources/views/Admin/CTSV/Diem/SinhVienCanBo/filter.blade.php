@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách sinh viên cán bộ</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="margin-top: 20px;">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0"> 
                <div class="d-flex justify-content-end col-md-12">
                    <div class="d-flex p-2 col-md-5 mb-3" style="border: 1px solid gray;">
                        <form action="{{route('import_sinhviencanbo')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" accept=".xlsx"><br>
                            <input type="submit" value="Import file excel" name="import_csv" class="btn btn-warning">
                        </form>
                    </div>
                </div> 
                <div class="d-flex col-md-12 flex-wrap" style="margin-bottom: 40px;">
                    <form action="{{route('filter_sinhviencanbo')}}" method="GET">
                        <div class="flex flex-column col-md-2">
                            <label for="" class="text-primary" style="font-size: 18px;">Chọn học kỳ</label>
                            <select name="sinhvien_hocky" class="form-control">
                                @foreach($sinhvien_hocky as $key => $hocky)
                                <option @if($Hocky==$hocky->hocky) selected @endif value="{{$hocky->hocky}}">{{$hocky->hocky}}</option>
                                @endforeach
                            </select>
                        </div>
                      
                        <div class="flex flex-column col-md-2">
                            <label for="" class="text-primary" style="font-size: 18px;">Chọn lớp</label>
                            <select name="lop" class="form-control">
                                @foreach($lop as $key => $item)
                                    <option @if($lop_sv == $item->lop_ten) selected @endif value="{{$item->lop_ten}}">{{$item->lop_ten}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex align-items-end ml-3 mt-3">
                            <input type="submit" value="Lọc" class="btn btn-primary">
                        </div>
                    </form>
                </div>
                <div class="form-group">
                    <?php
                    $message =  session()->get('message');
                    if ($message) {
                        echo '<p class="alert alert-success mt-2" id="alert-box">' . $message . '</p>';
                        session()->put('message', null);
                    }
                    ?>
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
                        <th>Chức vụ</th>
                        <th>Điểm thưởng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sinhvien as $key => $item)
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$item->hocky}}</td>
                        <td>{{$item->masinhvien}}</td>
                        <td>{{$item->tensinhvien}}</td>
                        <td>{{ date('d/m/Y', strtotime($item->ngaysinh)) }}</td>
                        <td>{{$item->khoa}}</td>
                        <td>{{$item->nganh}}</td>
                        <td>{{$item->lop}}</td>
                        <td>{{$item->chucvu}}</td>
                        <td>{{$item->diemthuong}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection