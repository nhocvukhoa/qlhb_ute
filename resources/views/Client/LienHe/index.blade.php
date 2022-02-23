@extends('Client.Layout.index')
@section('content')
<section class="contact d-flex flex-column">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul id="breadcrumb" style="width: 100%;">
                    <li><a href="{{route('home')}}"><span class="icon fas fa-home mr-2"></span>Trang chủ</a></li>
                    <li><a href="#"><span class="icon bi bi-file-earmark-post-fill mr-2"></span>Liên hệ</a></li>
                </ul>
                <div class="line3"></div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-7">
                <div class="contact-info">
                    <h2 class="title text-center text-uppercase">Thông tin liên hệ</h2>
                    <div class="contact-info-content">
                        <p class="contact-name text-uppercase"><b>Trường Đại học Sư phạm Kỹ thuật Đà Nẵng</b></p>
                        <span class="contact-address">Địa chỉ: 48 Cao Thắng, Phường Thanh Bình, Quận Hải Châu, Thành phố Đà Nẵng</span>
                        <span class="contact-phone">Số điện thoại: 0965072230</span>
                        <span class="contact-email">Email: spkt@gmail.com</span>
                    </div>
                </div>
                <div style="margin-top:40px;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3833.7729784366875!2d108.2107152642241!3d16.077266293494457!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142184792140755%3A0xd4058cb259787dac!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBTxrAgUGjhuqFtIEvhu7kgdGh14bqtdCAtIMSQ4bqhaSBo4buNYyDEkMOgIE7hurVuZw!5e0!3m2!1svi!2s!4v1638944344996!5m2!1svi!2s" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" style="margin-top:30px;"></iframe>
                </div>
            </div>
            <div class="col-md-5">
                <div class="contact-form" style="padding: 0 40px;">
                    <h2 class="title text-center text-uppercase">Đóng góp ý kiến</h2>
                    @if(count($errors) > 0)
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">x</button>
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="form-group">
                        <?php
                        $message =  session()->get('message');
                        if ($message) {
                            echo '<p class="alert alert-success mt-2" id="alert-box">' . $message . '</p>';
                            session()->put('message', null);
                        }
                        ?>
                    </div>
                    <form action="{{URL::to('/send')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="" style="font-size: 18px;">Họ tên của bạn</label>
                            <input type="text" name="name" class="form-control" placeholder="Nhập họ tên của bạn...."
                            style="font-size: 18px;">
                        </div>
                        <!-- <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Nhập email....">
                        </div> -->
                        <div class="form-group">
                            <label for="" style="font-size: 18px;">Nội dung đóng góp</label>
                            <textarea name="message" class="form-control" rows="10"></textarea>
                        </div>
                        <div class="form-group d-flex justify-content-end">
                            <input type="submit" name="send" value="Gửi" class="btn btn-info">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection