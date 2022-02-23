@extends('Client.Layout.index')
@section('content')
<section class="post-history">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul id="breadcrumb" style="width: 100%;">
                    <li><a href="{{route('home')}}"><span class="icon fas fa-home mr-2"></span>Trang chủ</a></li>
                    <li><a href="#"><span class="icon far fa-list-alt mr-2"></span>Quản lý bài đăng</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="line3"></div>
        <div class="card shadow mb-4" style="margin-top: 20px;">
            <div class="card-header py-3">
                <h1 class="m-0 font-weight-bold text-center" style="font-size: 18px;">Danh sách bài đăng</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0" style="font-size: 17px;">
                        <div class="d-flex justify-content-end mb-3">
                        </div>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th class="text-center col-md-2">Tên bài đăng</th>
                                <th>Người đăng</th>
                                <th>Thời gian bắt đầu</th>
                                <th>Thời gian kết thúc</th>
                                <th class="text-center">Tình trạng</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list_post as $key => $post)
                            <tr>
                                <td>{{ ($key +1 ) }}</td>
                                <td>
                                    {{ $post->hocbong_ten }}
                                </td>
                                <td>{{ $post->fullname}}</td>
                                <td>{{date('d-m-Y', strtotime($post->hocbong_thoigianbatdau))}}</td>
                                <td>{{date('d-m-Y', strtotime($post->hocbong_thoigianketthuc))}}</td>
                                <td class="text-center">
                                    @if($post->hocbong_tinhtrang == 0)
                                    <i class="bi bi-x-lg text-danger" style="font-size: 22px;"></i>
                                    @else
                                    <i class="bi bi-check-lg text-success" style="font-size: 25px;"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('apply_hocbong_ntt', $post->hocbong_id)}}" class="btn btn-warning text-uppercase mb-1" title="Xem danh sách đăng ký">
                                        <i class="bi bi-list-check"></i>
                                    </a>
                                    <a href="{{route('edit_baidang_ntt', $post->hocbong_id)}}" class="btn btn-success text-uppercase mb-1 edit" title="Sửa">
                                        <i class="bi bi-pen"></i>
                                    </a>
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
</section>