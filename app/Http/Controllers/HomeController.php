<?php

namespace App\Http\Controllers;

use App\Models\DangKyHocBong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\LoaiHocBong;
use App\Models\HocKy;
use App\Models\HocBong;
use App\Models\User;
use App\Models\ThongBao;
use App\Models\Slide;
use App\Models\TruyCap;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class HomeController extends Controller
{  

    //TODO: 1. Chuyển sang giao diện trang chủ
    public function index(Request $request) {
        $title = 'Trang chủ';
        //tong thanh vien
       // $user_total = User::orderBy('id', 'asc')->count();
        
        $loaihocbong = LoaiHocBong::orderBy('loaihocbong_id', 'asc')->get();
        $hocky = HocKy::orderBy('hocky_id', 'asc')->get();
        $nhataitro = DB::table('users')->orderBy('id', 'asc')->get();
        $listhocbong = HocBong::orderBy('hocbong_thoigiandang', 'desc')->where('hocbong_tinhtrang', '1')->paginate(6);

        DB::statement("SET SQL_MODE=''");
        $hocbong_luotxem = HocBong::orderBy('hocbong_luotxem', 'desc')->limit(4)->get();
        $hocbong_dangky = HocBong::orderBy('hocbong_soluongdadangky', 'desc')->limit(4)->get();
        $slide = Slide::orderBy('slide_id', 'asc')->get();
        return view('Client.Home.showHocBong', compact('title','loaihocbong', 'hocky', 'nhataitro', 
        'listhocbong', 'hocbong_luotxem', 'hocbong_dangky', 'slide'));
    }

    //TODO: 2. Thực hiện tìm kiếm và trả về giao diện tìm kiếm
    public function searchHocBong(Request $request) {
        $title = 'Kết quả tìm kiếm';
        $result = $request->keyword;
        $loaihocbong = LoaiHocBong::orderBy('loaihocbong_id', 'asc')->get();
        $hocky = HocKy::orderBy('hocky_id', 'asc')->get();
        $nhataitro = DB::table('users')->orderBy('id', 'asc')->get();
        $search_hocbong =  HocBong::orderBy('hocbong_id', 'desc')
        ->where('hocbong_ten','like','%'.$result.'%')
        ->where('hocbong_tinhtrang', '=', 1)
        ->paginate(9);
        DB::statement("SET SQL_MODE=''");
        $hocbong_luotxem = HocBong::orderBy('hocbong_luotxem', 'desc')->limit(4)->get();
        $hocbong_dangky = HocBong::orderBy('hocbong_soluongdadangky', 'desc')->limit(4)->get();
        $slide = Slide::orderBy('slide_id', 'asc')->get();
        return view('Client.Home.searchHocbong', compact('title','loaihocbong', 'hocky', 'nhataitro', 'search_hocbong',
        'hocbong_luotxem', 'hocbong_dangky', 'result','slide'));
    }

    //TODO: 3. Xem chi tiết học bổng
    public function detailHocBongHome(Request $request, $hocbong_id) {
        $title = 'Chi tiết học bổng';
        $loaihocbong = LoaiHocBong::orderBy('loaihocbong_id', 'asc')->get();
        $hocky = HocKy::orderBy('hocky_id', 'asc')->get();
        $nhataitro = DB::table('users')->orderBy('id', 'asc')->get();

        //TODO: check đăng ký
        $userDangKyHocBong = DangKyHocBong::orderBy('dangky_id', 'asc')
                            ->where('user_id', Auth::id())
                            ->where('hocbong_id', $hocbong_id)
                            ->first();
        $canRegister = empty($userDangKyHocBong);

        // $student_id = Auth::user()->id;
        $student = User::where('id', Auth::id())
        ->join('lop', 'lop.lop_id', '=', 'users.lop_id')
        ->join('nganh', 'lop.nganh_id', '=', 'nganh.nganh_id')
        ->join('khoa', 'nganh.khoa_id', '=', 'khoa.khoa_id')
        ->first();      
       
        $detail_hocbong = HocBong::with('tieuchi')
        ->join('loaihocbong', 'loaihocbong.loaihocbong_id' , '=' , 'hocbong.loaihocbong_id')
        ->join('hocky' ,'hocky.hocky_id', '=' , 'hocbong.hocky_id')
        ->join('users', 'users.id', '=' , 'hocbong.user_id')
        ->where('hocbong.hocbong_id', $hocbong_id)
        ->orderBy('hocbong_id', 'asc')
        ->get();

        foreach($detail_hocbong as $key => $value) {
            $loaihocbong_id = $value->loaihocbong_id;
            $hocbong_id = $value->hocbong_id;
        }

        //TODO: update lượt xem
        $view= HocBong::where('hocbong_id', $hocbong_id)->first();
        $view->hocbong_luotxem = $view->hocbong_luotxem + 1;
        $view->save();
       
        //TODO: học bổng liên quan
        $relate_hocbong = HocBong::with('tieuchi')
        ->join('loaihocbong', 'loaihocbong.loaihocbong_id', '=', 'hocbong.loaihocbong_id')
        ->join('hocky', 'hocky.hocky_id', '=', 'hocbong.hocky_id')
        ->join('users', 'users.id', '=' , 'hocbong.user_id')
        ->where('loaihocbong.loaihocbong_id', $loaihocbong_id)
        ->where('hocbong_tinhtrang', '=', 1)
        ->whereNotIn('hocbong.hocbong_id', [$hocbong_id])
        ->orderBy('hocbong_id', 'asc')
        ->limit(3)
        ->get();

        return view('Client.Home.detailHocBongHome', compact('title' ,'loaihocbong', 'hocky', 'nhataitro', 
        'detail_hocbong', 'relate_hocbong', 'userDangKyHocBong', 'canRegister', 'student', 'view'));
    }

    //TODO: 4. Chuyển sang trang thông báo
    public function listThongBao() {
        $title = 'Thông báo';
        $users = User::orderBy('id', 'asc')->get();
        $thongbao = ThongBao::join('users', 'users.id', '=', 'thongbao.user_id')
        ->orderBy('thongbao_id', 'desc')
        ->paginate(5);
        return view('Client.ThongBao.list', compact('title', 'users', 'thongbao'));
    }

    //TODO: 5. Xem chi tiết thông báo
    public function detailThongBao($thongbao_id) {
        $title = "Chi tiết thông báo";
        $users = User::orderBy('id', 'asc')->get();
        $detail_thongbao = ThongBao::join('users', 'users.id', '=', 'thongbao.user_id')
        ->where('thongbao.thongbao_id', $thongbao_id)
        ->orderBy('thongbao_id', 'desc')
        ->get();
        return view('Client.ThongBao.detail', compact('title', 'users', 'detail_thongbao'));
     }

     //TODO: 6. Lọc tất cả học bổng được tạo ra trong khoảng thời gian nào đó
     public function filterHocBong(Request $request) {
         $title = 'Lọc thông tin học bổng';
         $request->validate(
            [
                'hocbong_thoigianbatdau'=>'required',
                'hocbong_thoigianketthuc'=>'required',
            ],
            [
                'hocbong_thoigianbatdau.required' => 'Vui lòng chọn ngày',
                'hocbong_thoigianketthuc.required' => 'Vui lòng chọn ngày',
            ]);
         $loaihocbong = LoaiHocBong::orderBy('loaihocbong_id', 'asc')->get();
         $start = $request->hocbong_thoigianbatdau;
         $end = $request->hocbong_thoigianketthuc;
         $get_all_hocbong = HocBong::whereBetween('hocbong_thoigiandang', [$start, $end])
         ->orderBy('hocbong_thoigiandang','desc')
         ->where('hocbong_tinhtrang', '=', 1)
         ->paginate(9);
         DB::statement("SET SQL_MODE=''");
         $hocbong_luotxem = HocBong::orderBy('hocbong_luotxem', 'desc')->limit(4)->get();
         $hocbong_dangky = HocBong::orderBy('hocbong_soluongdadangky', 'desc')->limit(4)->get();
         $slide = Slide::orderBy('slide_id', 'asc')->get();
         return view('Client.Home.filterHocBong', compact('title','loaihocbong', 'start', 'end', 'get_all_hocbong',
        'hocbong_luotxem', 'hocbong_dangky', 'slide')); 
     }
    
}
