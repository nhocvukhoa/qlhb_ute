@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Danh sách cán bộ khoa</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <div class="d-flex col-md-12">
                    <!-- <form action="{{route('search_canbokhoa')}}" method="GET">
                        @csrf
                        <div class="search-box d-flex">
                            <input type="search" class="search-txt form-control mr-2 col-md-7" name="search" placeholder="Nhập tên cán bộ...">
                            <input type="submit" class="btn btn-info btn-sm mr-4" value="Tìm kiếm" name="search_items">
                        </div>
                    </form> -->
                    <form action="{{route('filter_canbo')}}" method="GET">
                    <div class="d-flex">
                        <div class="flex flex-column col-md-12">
                            <label for="" class="text-primary" style="font-size: 18px;">Chọn khoa</label>
                            <select name="khoa" class="form-control">
                               @foreach($khoa as $key => $item)
                                    <option @if($khoa_cb == $item->khoa_id) selected @endif value="{{$item->khoa_id}}">{{$item->khoa_ten}}</option>
                               @endforeach
                            </select>
                        </div>
                        <div class="d-flex align-items-end ml-2 mt-3">
                            <input type="submit" value="Lọc" class="btn btn-primary">
                        </div>
                    </div>
                </form>
                    <div class="d-flex align-items-end" style="margin-left: 670px;">
                        <a href="{{route('add_canbo')}}" class="btn btn-primary text-uppercase" title="Thêm">
                            <i class="bi bi-plus-circle mr-2"></i>Thêm
                        </a>
                    </div>
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
                        <th>MCB</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>SDT</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Khoa</th>
                        <th>Chức vụ</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($canbo as $key=> $item)
                    <tr>
                        <td>{{$key+ $canbo->firstItem()}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->fullname}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->diachi}}</td>
                        <td>{{$item->sdt}}</td>
                        <td>{{$item->gioitinh}}</td>
                        <td>{{date('d/m/Y', strtotime($item->ngaysinh));}}</td>
                        <td>{{$item->khoa_ten}}</td>
                        <td>
                            @if($item->chucvu == NULL)
                            Không
                            @else
                            {{$item->chucvu}}
                            @endif
                        </td>
                        <td>
                            <a href="{{route('edit_canbo', $item->id)}}" class="btn btn-success text-uppercase mb-1" title="Sửa">
                                <i class="bi bi-pen "></i>
                            </a>
                            <a href="{{route('delete_canbo', $item->id)}}" class="btn btn-danger text-uppercase delete" title="Hủy">
                                <i class=" bi bi-x-octagon"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-sm-12 text-right text-center-xs mt-2">
                <div class="pagination d-flex justify-content-center"> {{$canbo->links('paginationlinks')}}</div>
            </div>
        </div>
    </div>
</div>
@endsection