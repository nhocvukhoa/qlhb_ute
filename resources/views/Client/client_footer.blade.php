<section class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-4 about-us">
                    <h3 class="about-title">Về chúng tôi</h3>
                    <p class="about-content">Website này được tạo ra nhằm giúp việc quản lý và đăng ký học bổng trực tuyến tại trường
                        Đại học Sư phạm Kỹ Thuật Đà Nẵng trở nên dễ dàng và nhanh chóng hơn.
                    </p>
                </div>
                <div class="col-md-4 col-sm-12 about-contact">
                    <h3 class="about-title">Liên hệ</h3>
                    <ul class="list-contact">
                        <li><i class="bi bi-envelope"></i><a href="#" style="color: #333; font-size: 17px;">dhspktdn@ute.udn.vn</a></li>
                        <li><i class="bi bi-telephone"></i><a href="#" style="color: #333; font-size: 17px;">(0236) 3822571</a></li>
                        <li><i class="bi bi-geo-alt"></i><a href="#" style="color: #333; font-size: 17px;">48 Cao Thắng, Thành phố Đà Nẵng</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-6 get-notifications">
                    <h3 class="about-title">Đăng ký nhận thông báo</h3>
                    <p>Nhập địa chỉ email của bạn để nhận thông báo mới nhất</p>
                    <div class="email-txt">
                        <input type="email" name="email" class="form-control" placeholder="Vui lòng nhập email...">
                        <button type="submit" class="send-email">
                            <img src="{{asset('public/Frontend/images/right.png')}}" alt="">
                        </button>
                    </div>
                    <!-- <div class="map">
                        <a href="https://map.coccoc.com/map/3029289531603817" target="_blank">
                            <img src="{{asset('public/Frontend/images/map.PNG')}}" alt="">
                        </a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p class="text-center wow animate__fadeInUp" animate-wow-duration="1s" 
        style="visibility:visible; animation-duration: 1s; animation-name: fadeInUp;"">Created by Anh Khoa. © 2021</p>
    </div>
</section>
<!-- <div data-tooltip ="Chat với Phòng CTSV" data-tooltip-location="left">
    <a href="http://" target="_blank" class="icon icon_mess">
        <span>Chat với phòng CTSV</span>
        <img src="{{asset('public/Frontend/images/mess.svg')}}" width="48" height="48">
    </a>
</div> -->
<button class="topbtn">
    <i class="fas fa-arrow-up"></i>
</button>
<!--TODO: End Footer-->

</body>


<script src="{{asset('public/Frontend/js/jquery-3.5.1.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}
<script src="{{asset('public/Frontend/js/main.js')}}"></script>
<script src="{{asset('public/Frontend/js/wow.min.js')}}"></script>
<script src="{{asset('public/Frontend/js/sweetalert.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<script>
    $('#alert-box').removeClass('hide');
    $('#alert-box').delay(4000).slideUp(500);
</script>
<script>
    new WOW().init();
  </script>
<script type="text/javascript">
    $(document).ready(function(){
       //TODO: 1. Viết sự kiện cho nút nút quay lại đầu trang
       $(window).scroll(function(){
                if($(this).scrollTop() > 120){
                    $('.topbtn').fadeIn();
                    $('.header').addClass("header-fixed");
                    $('.slider').addClass("slider-fixed");
                }
                else{
                    $('.topbtn').fadeOut();
                }
            });
        $(".topbtn").click(function(){
                $('html, body').animate({scrollTop:0},900);
        });
        //TODO: 2. Sự kiện slider banner
        $(".owl-carousel").owlCarousel({
            items: 1,
            loop: true,
            nav: true,
            dots: true,
            autoplay: true,
            autoplaySpeed: 1000,
            smartSpeed: 1500,
            autoplayHoverPause: true,
        });
        //TODO: 3. Sự kiện slider logo doanh nghiệp
        $('.multiple-items').slick({
            dots: true,
            arrows: false,
            infinite: false,
            slidesToShow: 5,
            slidesToScroll: 5,
            autoplay: true,
            autoplaySpeed: 5000 ,
            slide: 'div',
            cssEase: 'linear',
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                }
            }]
        });
        //TODO: 4. Ajax lọc ghi chú 
      
    });
  </script>
    <script type="text/javascript">
$('.custom-file input').change(function (e) {
    if (e.target.files.length) {
        $(this).next('.custom-file-label').html(e.target.files[0].name);
    }
});

</script>
@yield('ckeditor_content')

</html>