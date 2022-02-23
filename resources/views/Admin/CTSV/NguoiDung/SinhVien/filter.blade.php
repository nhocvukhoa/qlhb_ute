@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách sinh viên</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <div class="d-flex justify-content-end col-md-12">
                    <div class="d-flex p-2 col-md-5 mb-3" style="border: 1px solid gray;">
                        <form action="{{route('import_sinhvien')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" accept=".xlsx"><br>
                            <input type="submit" value="Import file excel" name="import_csv" class="btn btn-warning">
                        </form>
                    </div>
                </div>
                <!-- <form action="{{route('search_sinhvien')}}" method="GET">
                    @csrf
                    <div class="search-box d-flex">
                        <input type="search" class="search-txt form-control mr-2 col-md-3" name="search" placeholder="Nhập tên sinh viên ...">
                        <input type="submit" class="btn btn-info btn-sm mr-4" value="Tìm kiếm" name="search_items">
                    </div>
                </form> -->
                <form action="{{route('filter_sinhvien')}}" method="GET">
                    <div class="d-flex">
                        <div class="flex flex-column col-md-2">
                            <label for="" class="text-primary" style="font-size: 18px;">Chọn lớp</label>
                            <select name="lop" class="form-control">
                                @foreach($lop as $key => $item)
                                    <option @if($lop_sv == $item->lop_id) selected @endif value="{{$item->lop_id}}">{{$item->lop_ten}}</option>
                               @endforeach
                            </select>
                        </div>
                        <div class="d-flex align-items-end ml-2 mt-3">
                            <input type="submit" value="Lọc" class="btn btn-primary">
                        </div>
                    </div>
                </form>

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
                        <th>MSV</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>SDT</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Lớp</th>
                        <th>Cán bộ</th>
                        <th>Chức vụ</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sinhvien as $key=> $item)
                    <tr>
                        <td>{{ $key +1  }}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->fullname}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->diachi}}</td>
                        <td>{{$item->sdt}}</td>
                        <td>{{$item->gioitinh}}</td>
                        <td>{{date('d/m/Y', strtotime($item->ngaysinh));}}</td>
                        <td>{{$item->lop_ten}}</td>
                        <td>
                            @if($item->canbo == NULL || $item->canbo == 0)
                            Không
                            @else
                            Có
                            @endif
                        </td>
                        <td>
                            @if($item->chucvu == NULL)
                            Không
                            @else
                            {{$item->chucvu}}
                            @endif
                        </td>
                        <td>
                            <a href="{{route('edit_canbo_sinhvien', $item->id)}}" class="btn btn-success text-uppercase mb-1" title="Sửa">
                                <i class="bi bi-pen "></i>
                            </a>
                            <a href="{{route('delete_canbo_sinhvien', $item->id)}}" class="btn btn-danger text-uppercase delete" title="Hủy">
                                <i class=" bi bi-x-octagon"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection