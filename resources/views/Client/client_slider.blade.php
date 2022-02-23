 <!--TODO: Slider-->
 <section class="slider">
    <div class="owl-carousel owl-theme">
        @foreach($slide as $item)
        <div class="slide slide-1">
            <img src="{{asset('public/Upload/Slide/'.$item->slide_hinhanh)}}" alt="" />
        </div>
        @endforeach      
        <!-- <div class="slide slide-2">
            <img src="http://icdn.dantri.com.vn/zoom/1200_630/2019/11/08/img-4293-1573205996358.jpg" alt="" />
        </div>
        <div class="slide slide-3">
            <img src="https://ute.udn.vn/Upload/CanBo/2019/T11/Hoc-Bong-UTE-06.jpg" alt="" />
        </div> -->
    </div> 
 <!--TODO: end Slider-->
 </section>
 <!--TODO: end Slider-->