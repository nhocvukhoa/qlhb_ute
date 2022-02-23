@extends('Client.Layout.index')
@section('content')
<div class="post-history">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul id="breadcrumb" style="width: 100%;">
                    <li><a href="{{route('home')}}"><span class="icon fas fa-home mr-2"></span>Trang chủ</a></li>
                    <li><a href="{{route('lichsu_ntt')}}"><span class="icon far fa-list-alt mr-2"></span>Lịch sử đăng bài</a></li>
                    <li><a href="#"><span class="icon far fa-list-alt mr-2"></span>Danh sách sinh viên đăng ký</a></li>
                    <li><a href="#"><span class="icon far fa-list-alt mr-2"></span>Hồ sơ đăng ký</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="line3"></div>
        <div class="card shadow mb-4" style="margin-top: 20px;">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-center">Hồ sơ đăng ký của sinh viên: {{$get_username}}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                        <div class="d-flex justify-content-start align-items-center mb-3">
                           
                            <div class="add-note d-flex flex-column">
                               
                                <label for="" class="mb-2">* Ghi chú hồ sơ cho sinh viên</label>
                             
                                <form action="{{route('add.note', ['dangky_id' => $dangky_id])}}" method="POST">
                                    @csrf
                                    <div class="note-content d-flex">
                                        <input type="text" class="form-control" name="hoso_ghichu" placeholder="Nhập ghi chú...">
                                        <input type="submit" class="btn btn-info ml-2" value="Ghi chú">
                                        @foreach($detail_apply as $key => $item) 
                                            <input type="hidden" name="hocbong_id" value="{{$item->hocbong_id}}">
                                        @endforeach
                                    </div>
                                </form>
                            </div>
                            <!-- <a href="{{route('apply_accept_hocbong_ntt', ['dangky_id' => $dangky_id])}}" class="btn btn-primary text-uppercase mr-2" 
                            title="Duyệt hồ sơ">
                                <i class="fas fa-check mr-2"></i>Duyệt hồ sơ
                            </a> -->
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
                                <th>Mã đăng ký</th>
                                <th>Tên tiêu chí</th>
                                <th>File minh chứng</th>
                                <th>Ghi chú hồ sơ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detail_apply as $key => $detail)
                            <tr>
                                <td>{{ $key +1 }}</td>
                                <td>{{ $dangky_id}}</td>
                                <td>{{ $detail->tieuchi_ten}}</td>
                                <td>
                                    @if($detail->hoso_hinhanh)
                                    <a href="{{asset('public/Upload/HoSo/'.$detail->hoso_hinhanh)}}" target="_blank">
                                        Xem file
                                    </a>
                                    @else
                                    Không có file đính kém
                                    @endif
                                </td>
                                <td>
                                    @if($detail->hoso_ghichu)
                                        {{$detail->hoso_ghichu}}
                                    @else
                                        Chưa có chú thích
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
    
                </div>
            </div>
        </div>
    </div>
</div>


@endsection