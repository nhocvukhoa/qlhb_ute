<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HocBong;
use App\Models\DangKyHocBong;
use App\Models\HocKy;
use App\Models\DiemRenLuyen;
use App\Models\DiemHocTap;
use App\Models\Diem;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    protected $dangKyHocBong;
    protected $hocBong;
    protected $hocKy;
    public function __construct( DangKyHocBong $dangKyHocBong, HocBong $hocBong, HocKy $hocKy)
    {
            $this->dangKyHocBong = $dangKyHocBong;
            $this->hocBong       = $hocBong;
            $this->hocKy      = $hocKy;
    }

    //TODO: ----------------------I. Công tác sinh viên ----------------------
    //TODO: 1. Thống kê Top 5 học bổng được xem nhiều nhất
    public function index(Request $request) {
        $title = 'Thống kê top n';
        DB::statement("SET SQL_MODE=''");
        $topN = $request->input('topn');
      
        $hocbong = HocBong::orderBy('hocbong_luotxem', 'desc')->limit(3)->get();
        $data = "";
        foreach($hocbong as $val) {
            $data.="['".$val->hocbong_ten."', ".$val->hocbong_luotxem."],";
        }
        $chartData = $data;
        return view('Admin.CTSV.ThongKe.index', compact('title', 'hocbong', 'chartData' ,'topN'));
    }

    //TODO: 1.1 Thống kê top có lọc
    public function filterTop(Request $request) {
        $title = 'Thống kê top n';
        DB::statement("SET SQL_MODE=''");
        //$hocbong = HocBong::orderBy('hocbong_luotxem', 'desc')->limit(5)->get();
        $topN = $request->input('topn');
        if($topN == 1) {
            $hocbong = HocBong::orderBy('hocbong_luotxem', 'desc')->limit(3)->get();
        }elseif($topN == 2){
            $hocbong = HocBong::orderBy('hocbong_luotxem', 'desc')->limit(5)->get();
        }else{
            $hocbong = HocBong::orderBy('hocbong_luotxem', 'desc')->limit(10)->get();
        }
        $data = "";
        foreach($hocbong as $val) {
            $data.="['".$val->hocbong_ten."', ".$val->hocbong_luotxem."],";
        }
        $chartData = $data;
        return view('Admin.CTSV.ThongKe.index', compact('title', 'hocbong', 'chartData','topN'));
    }


    //TODO:Thống kê top 10 học bổng được đăng kí nhiều nhất
    public function maxRegister() {
        $title = 'Thống kê 2';
        DB::statement("SET SQL_MODE=''");
        $danhsach = $this->dangKyHocBong->select(
            'hocbong.hocbong_ten',
            DB::raw('COUNT(dangkyhocbong.hocbong_id) AS total_amount')
        )
        ->join('hocbong', 'hocbong.hocbong_id', 'dangkyhocbong.hocbong_id')
        // ->groupBy('dangkyhocbong.hocbong_id')
        ->get();
        
        return view('Admin.CTSV.ThongKe.max_register', compact('title', 'danhsach'));
    }

    //TODO: 2. Thống kê số lượng học bổng trong từng học kỳ
    public function totalBySemester() {
        $title = 'Thống kê học kỳ';
        DB::statement("SET SQL_MODE=''");
        $total_bysemester = $this->hocBong->select(
            'hocky.hocky_ten',
            DB::raw('COUNT(hocbong.hocky_id) AS total_bySemester')
        )
        ->join('hocky', 'hocky.hocky_id', 'hocbong.hocky_id')
        ->groupBy('hocbong.hocky_id')
        ->get();
        $data = "";
        foreach($total_bysemester as $val) {
            $data.="['".$val->hocky_ten."', ".$val->total_bySemester."],";
        }
        $chartData = $data;
        return view('Admin.CTSV.ThongKe.total_bySemester', compact('title', 'total_bysemester', 'chartData'));
    }

    //TODO: 3. Thống kê số lượng sinh viên đăng ký và được nhận của mỗi học bổng
    public function totalStudentApply() {
        $title= 'Thống kê đăng ký và được nhận';
        DB::statement("SET SQL_MODE=''");
        $total_studentApply = $this->dangKyHocBong->select(
            'hocbong.hocbong_ten',
            DB::raw('COUNT(dangkyhocbong.hocbong_id) AS total_apply, 
                     SUM(dangkyhocbong.dangky_ketqua = 1) as total_accept'),
            //DB::raw('COUNT(dangkyhocbong.dangky_ketqua) as total_accept')
        )
        ->join('hocbong', 'hocbong.hocbong_id', '=', 'dangkyhocbong.hocbong_id')
        ->groupBy('dangkyhocbong.hocbong_id')
        ->get();
        //dd($total_studentApply);
        $data = "";
        foreach($total_studentApply as $val) {
            $data.="['".$val->hocbong_ten."', ".$val->total_apply.",  ".$val->total_accept.",],";
        }
        $chartData = $data;
        return view('Admin.CTSV.ThongKe.total_studentApply', compact('title', 'total_studentApply', 'chartData'));
    }

    //TODO: 4. Thống kê tổng loại điểm rèn luyện của từng lớp
    public function pointTraining(Request $request) {
        $title = 'Thống kê điểm rèn luyện';
        DB::statement("SET SQL_MODE=''");
        $diem = Diem::orderBy('diem_id', 'asc')
        ->select(
            'diem_lop', 'diem_renluyen', 'diem_hocky',
             DB::raw('SUM(diem_renluyen >= 90 AND diem_renluyen <= 100) as tong_xuatsac,
                      SUM(diem_renluyen >= 80 AND diem_renluyen < 90) as tong_tot,
                      SUM(diem_renluyen >= 65 AND diem_renluyen < 80) as tong_kha,
                      SUM(diem_renluyen >= 50 AND diem_renluyen < 65) as tong_trungbinh,
                      SUM(diem_renluyen >= 35 AND diem_renluyen < 50) as tong_yeu,
                      SUM(diem_renluyen < 35) as tong_kem')
        )
        ->groupBy('diem_lop')
        ->paginate(10);
        return view('Admin.CTSV.ThongKe.diemrenluyen', compact('title', 'diem'));
    }
  
    //TODO: 5. Thống kê tổng loại học tập của từng lớp
    public function pointStudy() {
        $title = 'Thống kê điểm học tập';
        DB::statement("SET SQL_MODE=''");
        $diemhoctap = Diem::orderBy('diem_id', 'asc')
        ->select(
            'diem_lop', 'diem_thang4', 'diem_hocky',
             DB::raw('SUM(diem_thang4 >= 3.6) as tong_xuatsac, 
                      SUM(diem_thang4 >=3.2 AND diem_thang4 < 3.6) as tong_gioi,
                      SUM(diem_thang4 >= 2.5 AND diem_thang4 <3.2) as tong_kha,
                      SUM(diem_thang4 >= 2 AND diem_thang4 < 2.5) as tong_trungbinh,
                      SUM(diem_thang4 < 2) as tong_yeu')
        )
        ->groupBy('diem_lop')
        ->paginate(10);
        return view('Admin.CTSV.ThongKe.diemhoctap', compact('title', 'diemhoctap'));
    }
}
