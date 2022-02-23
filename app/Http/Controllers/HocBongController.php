<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use App\Http\Requests;
use App\Models\DangKyHocBong;
use Illuminate\Support\Facades\Redirect;
use App\Models\LoaiHocBong;
use App\Models\HocKy;
use App\Models\HocBong;
use App\Models\User;
use App\Models\TieuChi;
use App\Models\TieuChiHocBong;
use App\Models\HoSoDangKy;
use App\Models\HinhThucDuyet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Exports\ExportDanhSachNhanHB;
use Maatwebsite\Excel\Facades\Excel;
use Brian2694\Toastr\Facades\Toastr;
session_start();


class HocBongController extends Controller
{
    //TODO: 1. Chuyển sang trang quản lý học bổng
    public function list() {
        if(Gate::allows('ctsv')) {
            $title = "Danh sách học bổng";
            $listHocBong = HocBong::orderBy('hocbong_thoigiandang', 'desc')
            ->join('loaihocbong', 'loaihocbong.loaihocbong_id', '=', 'hocbong.loaihocbong_id')
            ->join('hocky', 'hocky.hocky_id', '=', 'hocbong.hocky_id')
            ->join('users', 'users.id', '=', 'hocbong.user_id')
            ->where('hocbong_tinhtrang', '1')
            ->paginate(5);
            return view('Admin.CTSV.HocBong.list',compact('title','listHocBong'));
        }
        return redirect()->back();
    }

    //TODO: 2. Chuyển sang trang thêm học bổng
    public function add() {
        if(Gate::allows('ctsv')) {
            $title = "Thêm học bổng";
            $hocky_hocbong = HocKy::orderBy('hocky_id','asc')->get();
            $loaihocbong_hocbong = LoaiHocBong::orderBy('loaihocbong_id','asc')->get(); 
            $nhataitro_hocbong = User::orderBy('id','asc')->where('quyen', '=', '3')->get();
            $hinhthucduyet_hocbong = HinhThucDuyet::orderBy('hinhthucduyet_id', 'asc')->get();
            return view('Admin.CTSV.HocBong.add',compact('title','hocky_hocbong','loaihocbong_hocbong',
            'nhataitro_hocbong', 'hinhthucduyet_hocbong'));
        }
        return redirect()->back();
    }

    //TODO: 3. Thực hiện thêm học bổng
    public function insert(Request $request ) {
        $request->validate(
            [
                'hocbong_ten' => 'required|max:255', 
                'hocbong_noidung' => 'required|max:255', 
                'hocbong_thoigianbatdau' => 'required', 
                'hocbong_thoigianketthuc' => 'required', 
                'hocbong_kinhphi' => 'required', 
                'hocbong_tongsoluong' => 'required', 
            ],
            [
                'hocbong_ten.required' => 'Vui lòng nhập tên học bổng',
                'hocbong_noidung.required' => 'Vui lòng nhập nội dung học bổng',
                'hocbong_thoigianbatdau.required' => 'Vui lòng chọn thời gian bắt đầu học bổng',
                'hocbong_thoigianketthuc.required' => 'Vui lòng chọn thời gian kết thúc học bổng',
                'hocbong_kinhphi.required' => 'Vui lòng nhập kinh phí học bổng',
                'hocbong_tongsoluong.required' => 'Vui lòng nhập tổng số suất học bổng',
            ]);

        $data = array();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $data['hocbong_ten'] = $request->hocbong_ten;
        $data['loaihocbong_id'] = $request->loaihocbong_id;
        $data['hocky_id'] = $request->hocky_id;
        $data['hinhthucduyet_id'] = $request->hinhthucduyet_id;
        $data['hocbong_hinhanh'] = $request->hocbong_hinhanh;
        $data['hocbong_file'] = $request->hocbong_file;
        $data['hocbong_noidung'] = $request->hocbong_noidung;
        $data['hocbong_thoigianbatdau'] = $request->hocbong_thoigianbatdau;
        $data['hocbong_thoigianketthuc'] = $request->hocbong_thoigianketthuc;
        $data['hocbong_thoigiandang'] = now();
        $data['hocbong_kinhphi'] = $request->hocbong_kinhphi;
        $data['hocbong_tongsoluong'] = $request->hocbong_tongsoluong;
        $data['hocbong_tinhtrang'] = $request->hocbong_tinhtrang;
        $data['hocbong_nguoiduyet'] = $request->hocbong_nguoiduyet;
        $data['user_id'] = $request->user_id;
        $data['hocbong_ngayduyet'] = now();

        $get_image = $request->file('hocbong_hinhanh');
        if($get_image) {
            $get_name_image =  $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move(base_path().'/public/Upload/HocBong',$new_image);
            $data['hocbong_hinhanh'] = $new_image;
            if(HocBong::where('hocbong_ten', '=', $data['hocbong_ten'])->count() >0){
                session()->put('message','Tên học bổng này đã tồn tại');
                return redirect()->back();
            }
            HocBong::insert($data);
            session()->put('message','Thêm học bổng thành công');
            return redirect()->route('show_hocbong');
        }
       
        $data['hocbong_hinhanh'] = '';
        if(HocBong::where('hocbong_ten', '=', $data['hocbong_ten'])->count() >0){
            session()->put('message','Tên học bổng này đã tồn tại');
            return redirect()->back();
        }
        HocBong::insert($data);
        session()->put('message','Thêm học bổng thành công');
        return redirect()->route('show_hocbong');
    }

    //TODO: 4. Chuyển sang trang cập nhật học bổng
    public function edit($hocbong_id) {
        if(Gate::allows('ctsv')) {
            $title = "Cập nhật bài đăng";
            $loaihocbong = LoaiHocBong::orderBy('loaihocbong_id', 'asc')->get();
            $hocky = HocKy::orderBy('hocky_id', 'asc')->get();
            $user = User::orderBy('id', 'asc')->where('quyen', '=', 3)->get();
            $hinhthucduyet = HinhThucDuyet::orderBy('hinhthucduyet_id', 'asc')->get();
            $hocbong = HocBong::where('hocbong_id', $hocbong_id)
                ->join('hocky', 'hocky.hocky_id', '=', 'hocbong.hocky_id')
                ->join('hinhthucduyet', 'hinhthucduyet.hinhthucduyet_id', '=', 'hocbong.hinhthucduyet_id')
                ->first();
            return view('Admin.CTSV.HocBong.edit', compact('title', 'hocbong', 'hocky', 'loaihocbong', 'user',
            'hinhthucduyet'));
        }
        return redirect()->back();
    }

    //TODO: 5. Thực hiện cập nhật thông tin học bổng
    public function update(Request $request, $hocbong_id) {
        $data = array();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $data['hocbong_ten'] = $request->hocbong_ten;
        $data['loaihocbong_id'] = $request->loaihocbong_id;
        $data['hocky_id'] = $request->hocky_id;
        $data['hinhthucduyet_id'] = $request->hinhthucduyet_id;
        $data['hocbong_file'] = $request->hocbong_file;
        $data['hocbong_noidung'] = $request->hocbong_noidung;
        $data['hocbong_thoigianbatdau'] = $request->hocbong_thoigianbatdau;
        $data['hocbong_thoigianketthuc'] = $request->hocbong_thoigianketthuc;
        $data['hocbong_kinhphi'] = $request->hocbong_kinhphi;
        $data['hocbong_tongsoluong'] = $request->hocbong_tongsoluong;
        $data['user_id'] = $request->user_id;
        $data['hocbong_thoigiancapnhat'] = now();

        $get_image = $request->file('hocbong_hinhanh');
        if($get_image) {
            $get_name_image =  $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move(base_path().'/public/Upload/HocBong',$new_image);
            $data['hocbong_hinhanh'] = $new_image;
            HocBong::where('hocbong_id', $hocbong_id)->update($data);
            session()->put('message','Cập nhật học bổng thành công');
            return redirect()->route('show_hocbong');
        }
        HocBong::where('hocbong_id', $hocbong_id)->update($data);
        session()->put('message','Cập nhật học bổng thành công');
        return redirect()->route('show_hocbong');
    }

    //TODO: 6. Xem thông tin chi tiết học bổng
    public function detail($hocbong_id) {
        if(Gate::allows('ctsv')) {
            $title = 'Chi tiết học bổng';
            $hocky = HocKy::orderBy('hocky_id','asc')->get();
            $hinhthucduyet = HinhThucDuyet::orderBy('hinhthucduyet_id', 'asc')->get();
            $detail_hocbong = HocBong::with('tieuchi')
            ->join('loaihocbong', 'loaihocbong.loaihocbong_id' , '=' , 'hocbong.loaihocbong_id')
            ->join('hocky', 'hocky.hocky_id' , '=' , 'hocbong.hocky_id')
            ->join('users', 'users.id' , '=' , 'hocbong.user_id')
            ->join('hinhthucduyet', 'hinhthucduyet.hinhthucduyet_id', '=', 'hocbong.hinhthucduyet_id')
            ->where('hocbong.hocbong_id', $hocbong_id)
            ->get();
            return view('Admin.CTSV.HocBong.detail', compact('title', 'detail_hocbong', 'hocky', 'hinhthucduyet'));
        }
        return redirect()->back();
       
    }

    //TODO: 7. Xóa học bổng
    public function delete($hocbong_id) {
        if(Gate::allows('ctsv')) {
            $hocbong = HocBong::find($hocbong_id);
            $hocbong->delete();
            session()->put('message', 'Xóa học bổng thành công');
            return redirect()->route('show_hocbong');
        }
        return redirect()->back();
    }

    //TODO: 8. Xem danh sách đăng ký học bổng
    public function apply(Request $request, $hocbong_id) {
        if(Gate::allows('ctsv')) {
            $title = 'Danh sách đăng ký học bổng';
            $hocbong= HocBong::orderBy('hocbong_id', 'asc')->where('hocbong_id', '=', $hocbong_id)->first();
            $get_hocbong_ten = $hocbong->hocbong_ten;
            $get_hocbong_soluong = $hocbong->hocbong_tongsoluong;
            $dangky_ghichu = DangKyHocBong::select('dangky_ghichu')
            ->groupBy('dangky_ghichu')
            ->orderBy('dangky_ghichu', 'desc')
            ->where('hocbong_id', $hocbong_id)
            ->get();
            //TODO: Tổng số sinh viên đã được duyệt
            $total = DangKyHocBong::where('dangky_ketqua', '=', '1')->where('hocbong_id', '=', $hocbong_id)
            ->sum('dangky_ketqua');
            //TODO: Tổng số sinh viên đăng ký học bổng
            $total_apply = DangKyHocBong::where('hocbong_id', '=', $hocbong_id)->count('dangky_id');
            DB::statement("SET SQL_MODE=''");
            $Ghichu = $request->dangky_ghichu;
            $user_apply = DangKyHocBong::join('users', 'users.id', '=', 'dangkyhocbong.user_id')
            ->join('hocbong', 'hocbong.hocbong_id', '=', 'dangkyhocbong.hocbong_id')
            ->orderBy('dangkyhocbong.dangky_id', 'desc')
            ->where('dangkyhocbong.hocbong_id', $hocbong_id)
            ->paginate(5);
            return view('Admin.CTSV.HocBong.apply', compact('title', 'user_apply', 'hocbong_id',
            'dangky_ghichu', 'total', 'Ghichu', 'total_apply', 'hocbong', 'get_hocbong_ten', 'get_hocbong_soluong'));
        }
        return redirect()->back();
    }   

    //TODO: 8.1 Lọc ghi chú
    public function filterNoteAdmin(Request $request, $hocbong_id)
    {
        $title = 'Lọc ghi chú';
        $hocbong= HocBong::orderBy('hocbong_id', 'asc')->where('hocbong_id', '=', $hocbong_id)->first();
        $get_hocbong_ten = $hocbong->hocbong_ten;
        $get_hocbong_soluong = $hocbong->hocbong_tongsoluong;
        $dangky_ghichu = DangKyHocBong::select('dangky_ghichu')
            ->groupBy('dangky_ghichu')
            ->orderBy('dangky_ghichu', 'desc')
            ->where('hocbong_id', $hocbong_id)
            ->get();
        //TODO: Tổng số sinh viên đã được duyệt
        $total = DangKyHocBong::where('dangky_ketqua', '=', '1')->where('hocbong_id', '=', $hocbong_id)
        ->sum('dangky_ketqua');
        //TODO: Tổng số sinh viên đăng ký học bổng
        $total_apply = DangKyHocBong::where('hocbong_id', '=', $hocbong_id)->count('dangky_id');
        $Ghichu = $request->dangky_ghichu;
        DB::statement("SET SQL_MODE=''");
        $user_apply = DangKyHocBong::orderBy('dangkyhocbong.dangky_id', 'desc')
            ->when($Ghichu, function ($query) use ($Ghichu) {
                $query->where('dangky_ghichu', 'like', '%' . $Ghichu . '%');
            })
            ->where('dangkyhocbong.hocbong_id', $hocbong_id)
            ->join('users', 'users.id', '=', 'dangkyhocbong.user_id')
            ->join('hocbong', 'hocbong.hocbong_id', '=', 'dangkyhocbong.hocbong_id')
            ->get();
        return view('Admin.CTSV.HocBong.filter', compact(
            'title',
            'hocbong_id',
            'user_apply',
            'dangky_ghichu',
            'Ghichu',
            'total', 'total_apply', 'hocbong', 'get_hocbong_ten', 'get_hocbong_soluong'
        ));
    }
    //TODO: 8.2 Duyệt sau khi lọc
    public function acceptApplyFilterNote(Request $request, $dangky_id) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $hocbong_id = $request->hocbong_id;
        $total = DangKyHocBong::where('dangky_ketqua', '=', '1')->where('hocbong_id', '=', $hocbong_id)
        ->sum('dangky_ketqua');
        DangKyHocBong::join('hosodangky', 'hosodangky.dangky_id', '=', 'dangkyhocbong.dangky_id')
        ->where('dangkyhocbong.dangky_id', $dangky_id)
        ->update([
            'dangky_tinhtrang' => 1,
            'dangky_ketqua' => 1,
            'dangky_nguoiduyet' => auth()->user()->fullname,
            'dangky_thoigianduyet' => now()
        ]);
        session()->put('message','Duyệt hồ sơ thành công');
        return redirect()->back()->with('total', $total);
    }

    //TODO: 8.3 Quay về trang danh sách đăng ký
    public function applyReturn($hocbong_id, Request $request) {
        $hocbong_id = $request->hocbong_id;
        return redirect()->route('apply_hocbong', ['hocbong_id' => $hocbong_id]);
    }

    //TODO: 9. Xem chi tiết hồ sơ đăng kí
    public function detailApply(Request $request, $dangky_id) {
        $title = 'Hồ sơ đăng kí';
        $id = DangKyHocBong::orderBy('dangky_id', 'asc')
        ->where('dangky_id', '=', $dangky_id)->first();
        $get_username = $id->user_fullname;
        $apply_detail = HoSoDangKy::orderBy('hosodangky_id', 'asc')
        ->join('tieuchi', 'tieuchi.tieuchi_id', '=', 'hosodangky.tieuchi_id')
        ->join('dangkyhocbong', 'dangkyhocbong.dangky_id', '=', 'hosodangky.dangky_id')
        ->join('hocbong', 'hocbong.hocbong_id', '=', 'dangkyhocbong.hocbong_id')
        ->where('hosodangky.dangky_id', $dangky_id)
        ->get();
        return view('Admin.CTSV.HocBong.apply_detail', compact('title', 'apply_detail', 'dangky_id',
        'id', 'get_username'));
    }

    //TODO: 9.1 Ghi chú hồ sơ
    public function addNoteAdmin(Request $request, $dangky_id)
    {
        $request->validate(
            [
                'hoso_ghichu' => 'required|max:255',
            ],
            [
                'hoso_ghichu.required' => 'Vui lòng nhập ghi chú',
            ]
        );
        $hocbong_id = $request->hocbong_id;
        HoSoDangKy::where('dangky_id', $dangky_id)
            ->update([
                'hoso_ghichu' => $request->hoso_ghichu,
            ]);
        DangKyHocBong::join('hosodangky', 'hosodangky.dangky_id', '=', 'dangkyhocbong.dangky_id')
            ->where('dangkyhocbong.dangky_id', $dangky_id)
            ->update([
                'dangky_ghichu' => $request->hoso_ghichu,
            ]); 
        session()->put('message','Ghi chú hồ sơ thành công');
        return redirect()->route('apply_hocbong', ['hocbong_id' => $hocbong_id]);
    }


    //TODO: 10. Duyệt hồ sơ
    public function acceptApply(Request $request, $dangky_id) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $hocbong_id = $request->hocbong_id;
        $total = DangKyHocBong::where('dangky_ketqua', '=', '1')->where('hocbong_id', '=', $hocbong_id)
        ->sum('dangky_ketqua');
        DangKyHocBong::join('hosodangky', 'hosodangky.dangky_id', '=', 'dangkyhocbong.dangky_id')
        ->where('dangkyhocbong.dangky_id', $dangky_id)
        ->update([
            'dangky_tinhtrang' => 1,
            'dangky_ketqua' => 1,
            'dangky_nguoiduyet' => auth()->user()->fullname,
            'dangky_thoigianduyet' => now()
        ]);
        session()->put('message','Duyệt hồ sơ thành công');
        return redirect()->back()->with('total', $total);
    }

    //TODO: 11. Xuất file excel danh sách sinh viên được nhận học bổng
    public function exportSelectedList(Request $request, $hocbongId) {
        return Excel::download(new ExportDanhSachNhanHB($hocbongId), 'DS_SinhVien_NhanHB.xlsx');
    }

    //TODO: 12. Hiển thị học bổng cùng loại
    public function showHocBongByType($loaihocbong_id) {
        $title = 'Học bổng theo loại';
        $loaihocbong =LoaiHocBong::orderBy('loaihocbong_id', 'asc')->get();
        $hocky = HocKy::orderBy('hocky_id', 'asc')->get();
        $user = User::orderBy('user_id', 'asc')->get();
       
        $loaihocbong_id = HocBong::orderby('hocbong_id', 'asc')
        ->join('loaihocbong', 'loaihocbong.loaihocbong_id' , '=' , 'hocbong.loaihocbong_id')
        ->join('hocky', 'hocky.hocky_id' , '=' , 'hocbong.hocky_id')
        ->join('users', 'users.id' , '=' , 'hocbong.user_id')
        ->where('loaihocbong.loaihocbong_id', $loaihocbong_id)
        ->get();
        return view('Client.Home.showHocBongByType', compact('title', 'loaihocbong', 'hocky', 'user', 
        'loaihocbong_id'));
    }

    //TODO: 13. Tìm kiếm học bổng
    public function search(Request $request) {
        $title = 'Kết quả tìm kiếm';
        $search = $request->get('search');
        $listHocBong = HocBong::orderBy('hocbong_id', 'asc')
        ->join('loaihocbong', 'loaihocbong.loaihocbong_id' , '=' , 'hocbong.loaihocbong_id')
        ->join('hocky', 'hocky.hocky_id' , '=' , 'hocbong.hocky_id')
        ->join('users', 'users.id' , '=' , 'hocbong.user_id')
        ->where('hocbong_ten', 'like', '%'.$search.'%')
        ->paginate(10);
        return view('Admin.CTSV.HocBong.list', compact('title','listHocBong'));
    }
}
