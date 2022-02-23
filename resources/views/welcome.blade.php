@include('Client.client_header')
@include('Client.client_slider')

<section class="scholarship">
    <div class="container">
        <div class="row">
            <div class="col-md-3 scholarship-right d-flex flex-column">
                <div class="category-content">
                    <h1 class="text-center">Loại học bổng</h1>
                    <ul class="category-list">
                        @foreach($loaihocbong as $item)
                        <li class="category-item active">
                            <a href="{{URL::to('danhmuc-hocbong/'.$item->loaihocbong_id)}}">
                                <h2 class="category-title">{{$item->loaihocbong_ten}}</h2>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <form action="{{route('filterHocBong')}}" method="POST" style="margin-top: 20px;">
                    @csrf
                    <h1 class="text-center" class="filter-title" style="font-size: 20px; padding: 15px 0; 
                        background: #dc3545; color: #fff;">Lọc học bổng</h1>
                    <div class="filter" style="padding: 0 10px; border: 1px solid #aaaaaa; color: #000;">
                        <div class="form-group mt-2">
                            <label for="input" style="font-size: 18px; line-height: 20px;">Từ ngày</label>
                            <input type="date" class="form-control" name="hocbong_thoigianbatdau" style="font-size: 17px; 
                            line-height: 20px; color: #000;">
                             @if($errors->has('hocbong_thoigianbatdau'))
                                <span class="text text-danger mt-1">{{$errors->first('hocbong_thoigianbatdau')}}</span>
                             @endif
                        </div>
                        <div class="form-group">
                            <label for="input" style="font-size: 18px; line-height: 20px;">Đến ngày</label>
                            <input type="date" class="form-control" name="hocbong_thoigianketthuc" style="font-size: 17px; 
                            line-height: 20px; color: #000;">
                             @if($errors->has('hocbong_thoigianketthuc'))
                                <span class="text text-danger mt-1">{{$errors->first('hocbong_thoigianketthuc')}}</span>
                             @endif
                        </div>
                        <hr>
                        <div class="d-flex justify-content-center mb-2">
                            <input type="submit" value="Lọc" class="btn btn-danger" style="color: #fff;outline: none; border:none;
                             padding: 8px 40px; border-radius: 5px;">
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-9 scholarship-left">
                @yield('welcome_content')
            </div>
        </div>
    </div>
</section>

@include('Client.client_topView')
@include('Client.client_topRegister')
@include('Client.client_relationship')
@include('Client.client_footer')