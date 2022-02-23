@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Hồ sơ đăng ký của sinh viên {{ $get_username }}</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <div class="d-flex justify-content-end mb-3">
                    <!-- <a href="{{route('apply_accept', ['dangky_id' => $dangky_id])}}" class="btn btn-primary text-uppercase mr-2" title="Quay lại">
                        <i class="fas fa-check mr-2"></i>Duyệt hồ sơ
                    </a> -->
                </div>
                <div class="d-flex justify-content-start align-items-center mb-3">

                    <div class="add-note d-flex flex-column">
                      
                        <label for="" class="mb-2">* Ghi chú hồ sơ sinh viên:</label>
                   
                        <form action="{{route('add.note_admin', ['dangky_id' => $dangky_id])}}" method="POST">
                            @csrf
                            <div class="note-content d-flex">
                                <input type="text" class="form-control" name="hoso_ghichu" placeholder="Nhập ghi chú...">
                                <input type="submit" class="btn btn-info ml-2" value="Ghi chú">
                                @foreach($apply_detail as $key => $item)
                                    <input type="hidden" name="hocbong_id" value="{{$item->hocbong_id}}">
                                @endforeach
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
                            <th>Mã đăng ký</th>
                            <th>Tên tiêu chí</th>
                            <th>File minh chứng</th>
                            <th>Ghi chú hồ sơ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($apply_detail as $key => $detail)
                        <tr>
                            <td>{{ $key +1 }}</td>
                            <td>{{ $dangky_id}}</td>
                            <td>{{ $detail->tieuchi_ten}}</td>
                            <td>
                                @if($detail->hoso_hinhanh)
                                <a href="{{asset('public/Upload/HoSo/'.$detail->hoso_hinhanh)}}">
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




@endsection