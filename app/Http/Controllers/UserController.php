<?php

namespace App\Http\Controllers;

use App\Models\DangKyHocBong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\Lop;
use App\Models\Nganh;
use App\Models\Khoa;
use App\Models\HocKy;
use App\Models\HocBong;
use App\Models\LoaiHocBong;
use App\Models\HoSoDangKy;
use App\Models\TruyCap;
use App\Models\HinhThucDuyet;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\HocBongRequest;
use App\Exports\ExportDanhSachNhanHB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportDanhSachSV;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;


class UserController extends Controller
{
    //TODO: ---------------------------------I. Khách vãng lai-------------------------
    //TODO: 1. Hiển thị trang Login Client
    public function showLoginHome()
    {
        $title = 'Đăng nhập';
        return view('Client.Layout.client_login', compact('title'));
    }

    //TODO: 2. Thực hiện đăng nhập
    public function loginClient(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'password' => 'required',
            ],
            [
                'name.required' => 'Vui lòng nhập tên đăng nhập',
                'password.required' => 'Vui lòng nhập mật khẩu',
            ]
        );

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            if ((Auth::user()->quyen == 2 || Auth::user()->quyen == 3) && Auth::user()->tinhtrang == 1) {
                return Redirect::to('/trangchu');
            }
            session()->put('message', 'Tài khoản này không có quyền truy cập');
            Auth::logout();
            return Redirect::to('/user/login');
        } else {
            session()->put('message', 'Tài khoản hoặc mật khẩu sai');
            Auth::logout();
            return Redirect::to('/user/login');
        }
    }

    //TODO: 3. Hiển thị trang đăng ký Client
    public function showRegisterHome()
    {
        $title = 'Đăng kí';
        return view('Client.Layout.client_register', compact('title'));
    }

    //TODO: 4. Thực hiện đăng ký
    public function registerClient(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->quyen = $request->quyen;
        $user->fullname = $request->fullname;
        $user->diachi = $request->diachi;
        $user->sdt = $request->sdt;
        $user->tinhtrang = $request->tinhtrang;

        if (User::where('name', '=', $user->name)->count() > 0) {
            //Toastr::warning('Tên đăng nhập đã tồn tại', 'Thất bại');
            session()->put('message', 'Tên đăng nhập đã tồn tại');
            Auth::logout();
            return redirect()->back();
        }
        $user->save();
        Toastr::success('Đăng ký thành công', 'Vui lòng đợi duyệt');
        return redirect()->back();
    }

    //TODO: 5. Đăng xuất
    public function logoutClient()
    {
        Auth::logout();
        return Redirect::to('/trangchu');
    }



    //TODO: ------------------------------II. Sinh Viên-------------------------
    //TODO: 1. Hiển thị trang thông tin sinh viên
    public function studentInformation()
    {
        if (Gate::allows('sv')) {
            $title = 'Cập nhật thông tin sinh viên';
            $student_id = Auth::user()->id;

            $lop = Lop::orderBy('lop_id', 'asc')->get();
            $nganh = Nganh::orderBy('nganh_id', 'asc')->get();
            $khoa = Khoa::orderBy('khoa_id', 'asc')->get();
            $student = User::where('id', $student_id)
                ->join('lop', 'lop.lop_id', '=', 'users.lop_id')
                ->join('nganh', 'lop.nganh_id', '=', 'nganh.nganh_id')
                ->join('khoa', 'nganh.khoa_id', '=', 'khoa.khoa_id')
                ->first();
            return view('Client.User.SinhVien.showStudentInformation', compact('title', 'student', 'lop'));
        } else {
            return redirect()->back();
        }
    }

    //TODO: 2. Cập nhật thông tin sinh viên
    public function updateStudent(Request $request)
    {
        $data = $request->all();
        $data['id'] = Auth::user()->id;
        $student = User::find($data['id']);
        $student->ngaysinh = $data['ngaysinh'];
        $student->gioitinh = $data['gioitinh'];
        $student->diachi = $data['diachi'];
        $student->sdt = $data['sdt'];
        $student->save();
        //  session()->put('message', 'Cập nhật thông tin nhà tài trợ thành công');
        Toastr::success('Cập nhật thông tin thành công', 'Thành công');
        return redirect()->back();
    }
    //TODO: 3. Hiển thị trang danh sách đã đăng ký của sinh viên
    public function listRegister()
    {
        if (Gate::allows('sv')) {
            $title = 'Danh sách đăng ký';
            $user_id = Auth::user()->id;
            $listRegistered = DangKyHocBong::orderBy('dangky_thoigiandk', 'desc')
                ->join('users', 'users.id', '=', 'dangkyhocbong.user_id')
                ->join('hocbong', 'hocbong.hocbong_id', '=', 'dangkyhocbong.hocbong_id')
                ->where('dangkyhocbong.user_id', $user_id)
                ->get();
            return view('Client.User.SinhVien.listRegister', compact('title', 'listRegistered'));
        }
        return redirect()->back();
    }


    //TODO: ------------------------------III. Nhà tài trợ----------------------
    //TODO: 1. Hiển thị thông tin nhà tài trợ
    public function sponsorInformation()
    {
        if (Gate::allows('ntt')) {
            $title = 'Cập nhật thông tin nhà tài trợ';
            $sponsor_id = Auth::user()->id;
            $sponsor = User::where('id', $sponsor_id)->first();
            return view('Client.User.NhaTaiTro.showSponsorInformation', compact('title', 'sponsor'));
        } else {
            return redirect()->back();
        }
    }

    //TODO: 2. Cập nhật thông tin nhà tài trợ
    public function updateSponsor(Request $request)
    {
        if (Gate::allows('ntt')) {
            $data = $request->all();
            $data['id'] = Auth::user()->id;
            $sponsor = User::find($data['id']);
            $sponsor->fullname = $data['fullname'];
            $sponsor->diachi = $data['diachi'];
            $sponsor->sdt = $data['sdt'];
            $sponsor->email = $data['email'];
            $sponsor->save();
            // session()->put('message', 'Cập nhật thông tin nhà tài trợ thành công');
            Toastr::success('Cập nhật thông tin thành công', 'Thành công');
            return redirect()->back();
        }
        return redirect()->back();
    }

    //TODO: 3. Đăng thông tin học bổng 
    public function post()
    {
        if (Gate::allows('ntt')) {
            $title = 'Đăng thông tin học bổng';
            $hocky_hocbong = HocKy::orderBy('hocky_id', 'asc')->get();
            $hinhthucduyet_hocbong = HinhThucDuyet::orderBy('hinhthucduyet_id', 'asc')->get();
            return view('Client.User.NhaTaiTro.uploadHocBong', compact('title', 'hocky_hocbong', 'hinhthucduyet_hocbong'));
        }
        return redirect()->back();
    }

    //TODO: 4. Thực hiện đăng thông tin học bổng
    public function save(HocBongRequest $request)
    {
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
        $data['user_id'] = $request->user_id;

        $get_image = $request->file('hocbong_hinhanh');
        if ($get_image) {
            $get_name_image =  $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move(base_path() . '/public/Upload/HocBong', $new_image);
            $data['hocbong_hinhanh'] = $new_image;
            if (HocBong::where('hocbong_ten', '=', $data['hocbong_ten'])->count() > 0) {
                session()->put('error', 'Tên học bổng này đã tồn tại');
                return redirect()->back();
            }
            DB::table('hocbong')->insert($data);
            session()->put('message', 'Đăng học bổng thành công. Vui lòng chờ duyệt!');
            //Toastr::success('Đăng tin học bổng thành công. Vui lòng chờ duyệt', 'Thành công');
            return redirect()->back();
        }
        $data['hocbong_hinhanh'] = '';
        if (HocBong::where('hocbong_ten', '=', $data['hocbong_ten'])->count() > 0) {
            session()->put('error', 'Tên học bổng này đã tồn tại');
            return redirect()->back();
        }
        DB::table('hocbong')->insert($data);
        session()->put('message', 'Đăng học bổng thành công. Vui lòng chờ duyệt!');
        return redirect()->back();
    }

    //TODO: 5. Hiển thị trang lịch sử đăng bài của nhà tài trợ
    public function showHistory()
    {
        $title = 'Lịch sử đăng bài';
        $user_id = Auth::user()->id;
        $user = User::orderBy('id', 'asc')->get();
        $list_post = HocBong::orderBy('hocbong_thoigiandang', 'desc')
            ->join('users', 'users.id', '=', 'hocbong.user_id')
            ->where('hocbong.user_id', $user_id)
            ->get();
        return view('Client.User.NhaTaiTro.postHistory', compact('title', 'user', 'list_post'));
    }

    //TODO: 6. Xem danh sách đăng ký học bổng của nhà tài trợ
    public function listApply(Request $request, $hocbong_id)
    {
        $title = "Danh sách đăng ký học bổng";
        $hocbong = HocBong::orderBy('hocbong_id', 'asc')->where('hocbong_id', '=', $hocbong_id)->first();
        $get_hocbong_ten = $hocbong->hocbong_ten;
        $get_hocbong_soluong = $hocbong->hocbong_tongsoluong;
        $dangky_ghichu = DangKyHocBong::select('dangky_ghichu')
            ->groupBy('dangky_ghichu')
            ->orderBy('dangky_ghichu', 'desc')
            ->where('hocbong_id', $hocbong_id)
            ->get();
        $Ghichu = $request->dangky_ghichu;
        DB::statement("SET SQL_MODE=''");
        //TODO: Tổng số sinh viên đã duyệt
        $total = DangKyHocBong::where('dangky_ketqua', '=', '1')->where('hocbong_id', '=', $hocbong_id)
            ->sum('dangky_ketqua');
        //TODO: Tổng số sinh viên đăng ký
        $total_apply = DangKyHocBong::where('hocbong_id', '=', $hocbong_id)->count('dangky_id');
        
        $user_apply = DangKyHocBong::join('users', 'users.id', '=', 'dangkyhocbong.user_id')
            ->join('hocbong', 'hocbong.hocbong_id', '=', 'dangkyhocbong.hocbong_id')
            ->orderBy('dangkyhocbong.dangky_id', 'desc')
            ->where('dangkyhocbong.hocbong_id', $hocbong_id)
            ->paginate(5);
        return view('Client.User.NhaTaiTro.listApply', compact(
            'title',
            'Ghichu',
            'dangky_ghichu',
            'user_apply',
            'hocbong_id',
            'total',
            'total_apply',
            'hocbong',
            'get_hocbong_ten',
            'get_hocbong_soluong'
        ));
    }

    //TODO: 6.1 Lọc ghi chú
    public function filterNote(Request $request, $hocbong_id)
    {
        $title = 'Lọc ghi chú';
        $hocbong = HocBong::orderBy('hocbong_id', 'asc')->where('hocbong_id', '=', $hocbong_id)->first();
        $get_hocbong_ten = $hocbong->hocbong_ten;
        $get_hocbong_soluong = $hocbong->hocbong_tongsoluong;
        $dangky_ghichu = DangKyHocBong::select('dangky_ghichu')
            ->groupBy('dangky_ghichu')
            ->orderBy('dangky_ghichu', 'desc')
            ->where('hocbong_id', $hocbong_id)
            ->get();
        DB::statement("SET SQL_MODE=''");
        //TODO: Tổng số sinh viên đã duyệt
        $total = DangKyHocBong::where('dangky_ketqua', '=', '1')->where('hocbong_id', '=', $hocbong_id)
            ->sum('dangky_ketqua');
        //TODO: Tổng số sinh viên đăng ký
        $total_apply = DangKyHocBong::where('hocbong_id', '=', $hocbong_id)->count('dangky_id');
        $Ghichu = $request->dangky_ghichu;
        $user_apply = DangKyHocBong::orderBy('dangkyhocbong.dangky_id', 'desc')
            ->when($Ghichu, function ($query) use ($Ghichu) {
                $query->where('dangky_ghichu', 'like', '%' . $Ghichu . '%');
            })
            ->where('dangkyhocbong.hocbong_id', $hocbong_id)
            ->join('users', 'users.id', '=', 'dangkyhocbong.user_id')
            ->join('hocbong', 'hocbong.hocbong_id', '=', 'dangkyhocbong.hocbong_id')
            ->get();
        return view('Client.User.NhaTaiTro.filterApply', compact(
            'title',
            'hocbong_id',
            'user_apply',
            'dangky_ghichu',
            'Ghichu',
            'total',
            'total_apply',
            'hocbong',
            'get_hocbong_ten',
            'get_hocbong_soluong'
        ));
    }
    //TODO: 6.2 Duyệt sau khi lọc (duyệt từng sinh viên)
    public function acceptApplyFilter(Request $request, $dangky_id)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $hocbong_id = $request->hocbong_id;
        $total = DangKyHocBong::where('dangky_ketqua', '=', '1')->where('hocbong_id', '=', $hocbong_id)
            ->sum('dangky_ketqua');
        $total_apply = DangKyHocBong::where('hocbong_id', '=', $hocbong_id)->count('dangky_id');
        DangKyHocBong::join('hosodangky', 'hosodangky.dangky_id', '=', 'dangkyhocbong.dangky_id')
            ->where('dangkyhocbong.dangky_id', $dangky_id)
            ->update([
                'dangky_tinhtrang' => 1,
                'dangky_ketqua' => 1,
                'dangky_nguoiduyet' => auth()->user()->fullname,
                'dangky_thoigianduyet' => now()
            ]);
        Toastr::success('Duyệt hồ sơ thành công', 'Thành công');
        return redirect()->back()->with('total', $total)->with('total_apply', $total_apply);
    }
    //TODO: 6.3 Duyệt sau khi lọc (duyệt bằng checkbox)
    public function acceptApplyCheckbox(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $hocbong_id = $request->hocbong_id;
        //TODO: Tổng số sinh viên đã duyệt
        $total = DangKyHocBong::where('dangky_ketqua', '=', '1')->where('hocbong_id', '=', $hocbong_id)
            ->sum('dangky_ketqua');
        //TODO: Tổng số sinh viên đăng ký
        $total_apply = DangKyHocBong::where('hocbong_id', '=', $hocbong_id)->count('dangky_id');
        Toastr::success('Duyệt hồ sơ thành công', 'Thành công');
        return redirect()->back()->with('total', $total)->with('total_apply', $total_apply);
    }

    //TODO: 6.4. Quay trở về trang danh sách
    public function applyReturnDS(Request $request, $hocbong_id)
    {
        $hocbong_id = $request->hocbong_id;
        return redirect()->route('apply_hocbong_ntt', ['hocbong_id' => $hocbong_id]);
    }

    //TODO: 7. Xem hồ sơ mà sinh viên đã đăng ký
    public function detailApply(Request $request, $dangky_id)
    {
        $title = "Hồ sơ đăng ký";
        $id = DangKyHocBong::orderBy('dangky_id', 'asc')
            ->where('dangky_id', '=', $dangky_id)->first();
        $get_username = $id->user_fullname;
        $detail_apply = HoSoDangKy::join('tieuchi', 'tieuchi.tieuchi_id', '=', 'hosodangky.tieuchi_id')
            ->join('dangkyhocbong', 'dangkyhocbong.dangky_id', '=', 'hosodangky.dangky_id')
            ->join('hocbong', 'hocbong.hocbong_id', '=', 'dangkyhocbong.hocbong_id')
            ->where('hosodangky.dangky_id', $dangky_id)
            ->orderBy('hosodangky_id', 'asc')
            ->get();

        return view('Client.User.NhaTaiTro.detailApply', compact(
            'title',
            'detail_apply',
            'dangky_id',
            'id',
            'get_username'
        ));
    }


    //TODO: 7.1. Chú thích cho hồ sơ
    public function addNote(Request $request, $dangky_id)
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
        Toastr::success('Chú thích thành công', 'Thành công');
        return redirect()->route('apply_hocbong_ntt', ['hocbong_id' => $hocbong_id]);
    }

    //TODO: 8. Duyệt hồ sơ mà sinh viên đã đăng ký (ko cần lọc)
    public function acceptApply(Request $request, $dangky_id)
    {
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
        Toastr::success('Duyệt hồ sơ thành công', 'Thành công');
        return redirect()->back()->with('total', $total);
    }

    //TODO: 9. Xuất danh sách sinh viên được nhận học bổng
    public function exportSelected(Request $request, $hocbong_id)
    {
        return Excel::download(new ExportDanhSachNhanHB($hocbong_id), 'DS_SinhVien_NhanHB.xlsx');
    }

    //TODO: 10. Cập nhật bài đăng
    public function editPost($hocbong_id)
    {
        $title = "Cập nhật bài đăng";
        $hocky = HocKy::orderBy('hocky_id', 'asc')->get();
        $hinhthucduyet = HinhThucDuyet::orderBy('hinhthucduyet_id', 'asc')->get();
        $hocbong = HocBong::where('hocbong_id', $hocbong_id)
            ->join('hocky', 'hocky.hocky_id', '=', 'hocbong.hocky_id')
            ->join('hinhthucduyet', 'hinhthucduyet.hinhthucduyet_id', '=', 'hocbong.hinhthucduyet_id')
            ->first();
        return view('Client.User.NhaTaiTro.editPost', compact('title', 'hocbong', 'hocky', 'hinhthucduyet'));
    }

    //TODO: 11. Thực hiện cập nhật bài đăng
    public function updatePost(Request $request, $hocbong_id)
    {
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
        $data['hocbong_thoigiancapnhat'] = now();
        $data['user_id'] = $request->user_id;

        $get_image = $request->file('hocbong_hinhanh');
        if ($get_image) {
            $get_name_image =  $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move(base_path() . '/public/Upload/HocBong', $new_image);
            $data['hocbong_hinhanh'] = $new_image;
            HocBong::where('hocbong_id', $hocbong_id)->update($data);
            session()->put('message', 'Cập nhật bài đăng thành công');
            return redirect()->back();
        }
        HocBong::where('hocbong_id', $hocbong_id)->update($data);
        //session()->put('message', 'Cập nhật bài đăng thành công');
        Toastr::success('Cập nhật bài đăng thành công', 'Thành công');
        return redirect()->back();
    }


    //TODO: Đăng ký học bổng
    public function dangkyHocBong(Request $request)
    {

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $user_id = Auth::id();
        $user_name = $request->user_name;
        $user_fullname = $request->user_fullname;
        $user_nganh = $request->user_nganh;
        $user_lop = $request->user_lop;
        $hocbong_id = $request->hocbong_id;
        $dangky_thoigiandk = now();
        $dataDangKyHocBong = [
            'user_id' => $user_id,
            'hocbong_id' => $hocbong_id,
            'user_name' => $user_name,
            'user_fullname' => $user_fullname,
            'user_nganh' => $user_nganh,
            'user_lop' => $user_lop,
            'dangky_thoigiandk' => $dangky_thoigiandk,
        ];

        if ($request->file('image') == NULL) {
            $request->validate(
                [
                    'image[]' => 'required|max:255',
                ],
                [
                    'image[].required' => 'Vui lòng chọn minh chứng',
                ]
            );
            Toastr::danger('Đăng ký thất bại', 'Thất bại');
            return redirect()->back();
        }

        //TODO: Thực hiện đăng ký học bổng
        $dangKyHocBong = DangKyHocBong::create($dataDangKyHocBong);

        //TODO: Tạo hồ sơ đăng ký

        $dangky_id = $dangKyHocBong->dangky_id;
        $path_document = 'public/Upload/HoSo/';
        $images = $request->file('image');
        $tieuchi = $request->tieuchi_id;

        foreach ($images as $key => $item) {
            //upload files
            if ($item) {
                $nameFile =  $item->getClientOriginalName();
                $name_document = current(explode('.', $nameFile));
                $fullpath = $name_document . rand(0, 99) . '.' . $item->getClientOriginalExtension();
                $item->move($path_document, $fullpath);
                //luu data ho so
                $dataHoSo[$key] = [
                    'dangky_id' => $dangky_id,
                    'tieuchi_id' => $tieuchi[$key],
                    'hoso_hinhanh' => $fullpath
                ];
            }
        }
        HoSoDangKy::insert($dataHoSo);

        $hocbong = HocBong::find($request->hocbong_id);
        $soluongdadangky = $hocbong->hocbong_soluongdadangky;
        $hocbong->update(['hocbong_soluongdadangky' => $soluongdadangky + 1]);
        // session()->put('message', 'Đăng ký thành công');
        Toastr::success('Đăng ký thành công', 'Thành công');
        return redirect()->back();
    }


    //TODO: --------------------------IV. CTSV------------------------------------
    //TODO: 1. Chuyển sang trang thiết lập quyền
    public function listRole()
    {
        $title = 'Thiết lập quyền';
        $userRole = User::where('quyen', '=', '3')->orderBy('id', 'desc')->paginate(5);
        return view('Admin.CTSV.User.listRole', compact('title', 'userRole'));
    }

    //TODO: 2. Khóa quyền người dùng
    public function blockedUser($id)
    {
        User::where('id', $id)->update([
            'tinhtrang' => 0
        ]);
        session()->put('message', 'Đã khóa tài khoản');
        return redirect()->route('show_thietlapquyen');
    }

    //TODO: 3. Mở quyền truy cập cho người dùng
    public function openUser($id)
    {
        User::where('id', $id)->update([
            'tinhtrang' => 1
        ]);
        session()->put('message', 'Đã mở khóa tài khoản');
        return redirect()->route('show_thietlapquyen');
    }

    //TODO: 4. Chuyển sang trang danh sách tài khoản đăng ký cần duyệt
    public function listAcceptAccount()
    {
        $title = "Duyệt tài khoản đăng kí";
        $listUser = User::where('tinhtrang', '0')->orderBy('id', 'asc')->get();
        return view('Admin.CTSV.User.listAcceptAccount', compact('title', 'listUser'));
    }

    //TODO: 5. Duyệt đăng kí tài khoản nhà tài trợ
    public function activeUser($id)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        User::where('id', $id)->update([
            'tinhtrang' => 1,
            'ngayDuyetTV' => now()
        ]);
        session()->put('message', 'Đã duyệt tài khoản đăng kí thành công');
        return redirect()->route('list_account');
    }

    //TODO: 6. Xóa tài khoản đăng kí nhà tài trợ (trường hợp đăng kí ảo)
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->put('message', 'Đã xóa tài khoản');
        return redirect()->route('list_account');
    }

    //TODO: 7. Chuyển sang trang duyệt bài đăng của nhà tài trợ
    public function listAcceptPost()
    {
        $title = "Duyệt bài đăng học bổng";
        $listHocBong = HocBong::orderBy('hocbong_id', 'desc')
            ->join('loaihocbong', 'loaihocbong.loaihocbong_id', '=', 'hocbong.loaihocbong_id')
            ->join('hocky', 'hocky.hocky_id', '=', 'hocbong.hocky_id')
            ->join('users', 'users.id', '=', 'hocbong.user_id')
            ->where('hocbong_tinhtrang', '0')
            ->get();
        return view('Admin.CTSV.User.listAcceptPost', compact('title', 'listHocBong'));
    }

    //TODO: 8. Duyệt bài đăng của nhà tài trợ
    public function activePost($hocbong_id)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        HocBong::where('hocbong_id', $hocbong_id)->update([
            'hocbong_tinhtrang' => 1,
            'hocbong_nguoiduyet' => Auth::user()->fullname,
            'hocbong_ngayduyet' => now()
        ]);
        session()->put('message', 'Đã duyệt bài đăng thành công');
        return redirect()->back();
    }

    //TODO: 9. Xem chi tiết bài đăng của nhà tài trợ
    public function detailAcceptPost($hocbong_id)
    {
        $title = 'Chi tiết học bổng';
        $loaihocbong = DB::table('loaihocbong')->orderBy('loaihocbong_id', 'asc')->get();
        $hocky = DB::table('hocky')->orderBy('hocky_id', 'asc')->get();
        $nhataitro = DB::table('users')->orderBy('id', 'asc')->get();
        $hinhthucduyet = HinhThucDuyet::orderBy('hinhthucduyet_id', 'asc')->get();

        $detail_hocbong = DB::table('hocbong')
            ->join('loaihocbong', 'loaihocbong.loaihocbong_id', '=', 'hocbong.loaihocbong_id')
            ->join('hocky', 'hocky.hocky_id', '=', 'hocbong.hocky_id')
            ->join('users', 'users.id', '=', 'hocbong.user_id')
            ->join('hinhthucduyet', 'hinhthucduyet.hinhthucduyet_id', '=', 'hocbong.hinhthucduyet_id')
            ->where('hocbong.hocbong_id', $hocbong_id)
            ->get();
        return view('Admin.CTSV.User.detailAcceptPost', compact(
            'title',
            'loaihocbong',
            'hocky',
            'detail_hocbong',
            'nhataitro',
            'hinhthucduyet'
        ));
    }

    //TODO: 10. Xóa bài đăng nếu nội dung bài đăng spam
    public function deletePost($hocbong_id)
    {
        $hocbong = HocBong::find($hocbong_id);
        $hocbong->delete();
        session()->put('message', 'Xóa bài đăng thành công');
        return redirect()->back();
    }

    //TODO: 11. Hiển thị danh sách sinh viên của trường
    public function listSinhVien(Request $request)
    {
        $title = 'Danh sách sinh viên';
        $lop = Lop::orderBy('lop_id', 'asc')->get();
        $nganh = Nganh::orderBy('nganh_id', 'asc')->get();
        $khoa = Khoa::orderBy('khoa_id', 'asc')->get();
       
        $lop_sv = $request->input('lop');
       
        $sinhvien = User::orderBy('id', 'desc')
            ->join('lop', 'lop.lop_id', '=', 'users.lop_id')
            ->join('nganh', 'lop.nganh_id', '=', 'nganh.nganh_id')
            ->join('khoa', 'nganh.khoa_id', '=', 'khoa.khoa_id')
            ->where('quyen', '=', 2)
            ->paginate(5);
        
        return view('Admin.CTSV.NguoiDung.SinhVien.index', compact(
            'title', 'sinhvien', 'lop' ,'lop_sv'
        ));
    }

    //TODO: 11.1 Lọc sinh viên theo lớp
    public function filterSinhVien(Request $request)
    {
        $title = 'Danh sách sinh viên';
        $lop = Lop::orderBy('lop_id', 'asc')->get();
        $nganh = Nganh::orderBy('nganh_id', 'asc')->get();
        $khoa = Khoa::orderBy('khoa_id', 'asc')->get();
       
        $lop_sv = $request->input('lop');

        $sinhvien = User::orderBy('id', 'desc')
            ->join('lop', 'lop.lop_id', '=', 'users.lop_id')
            ->join('nganh', 'lop.nganh_id', '=', 'nganh.nganh_id')
            ->join('khoa', 'nganh.khoa_id', '=', 'khoa.khoa_id')
            ->where('quyen', '=', 2)
            ->where('users.lop_id', '=', $lop_sv)
            ->get();
        return view('Admin.CTSV.NguoiDung.SinhVien.filter', compact(
            'title', 'sinhvien', 'lop', 'lop_sv'
        ));
    }

    //TODO: 12. Import danh sách sinh viên
    public function importSinhVien(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        Excel::import(new ImportDanhSachSV, $path);
        session()->put('message', 'Import file excel thành công');
        return redirect()->back();
    }

    //TODO: 13. Thêm chức vụ cho sinh viên
    public function editCanBoSV($id, Request $request)
    {
        $title = 'Thêm chức vụ sinh viên';
        $sinhvien = User::find($id);
        if ($sinhvien) {
            return view('Admin.CTSV.NguoiDung.SinhVien.addChucVu', compact('title', 'sinhvien'));
        }
    }

    //TODO: 14. Lưu chức vụ sinh viên
    public function updateCanBoSV($id, Request $request)
    {
        $data = array();
        $data['canbo'] = 1;
        $data['chucvu'] = $request->chucvu;
        User::where('id', $id)->update($data);
        session()->put('message', 'Cập nhật chức vụ thành công');
        return redirect()->route('show_sinhvien');
    }

    //TODO: 15. Hủy chức vụ
    public function deleteCanBoSV($id)
    {
        User::where('id', $id)->update([
            'canbo' => 0,
            'chucvu' => NULL
        ]);
        session()->put('message', 'Hủy chức vụ thành công');
        return redirect()->route('show_sinhvien');
    }

    //TODO: 16. Tìm kiếm sinh viên
    // public function searchSinhVien(Request $request)
    // {
    //     $title = 'Kết quả tìm kiếm';
    //     $search = $request->get('search');
    //     $sinhvien = User::orderBy('id', 'asc')
    //         ->join('lop', 'users.lop_id', '=', 'lop.lop_id')
    //         ->where('quyen', '=', 2)
    //         ->where('fullname', 'like', '%' . $search . '%')->paginate(20);
    //     return view('Admin.CTSV.NguoiDung.SinhVien.index', compact('title', 'sinhvien'));
    // }

    //TODO: 12. Hiển thị danh sách cán bộ của trường
    public function listCanBoKhoa(Request $request)
    {
        $title = 'Danh sách cán bộ khoa';
        $khoa = Khoa::orderBy('khoa_id', 'asc')->get();
        $khoa_cb = $request->input('khoa');
        $canbo = User::orderBy('id', 'asc')
            ->join('khoa', 'khoa.khoa_id', '=', 'users.khoa_id')
            ->where('quyen', '=', 1)
            ->where('canbo', '=', 1)
            ->paginate(5);
        return view('Admin.CTSV.NguoiDung.CanBoKhoa.index', compact(
            'title',
            'canbo',
            'khoa', 'khoa_cb'
        ));
    }

    public function filterCanBoKhoa(Request $request)
    {
        $title = 'Lọc cán bộ khoa';
        $khoa = Khoa::orderBy('khoa_id', 'asc')->get();
        $khoa_cb = $request->input('khoa');
        $canbo = User::orderBy('id', 'asc')
            ->join('khoa', 'khoa.khoa_id', '=', 'users.khoa_id')
            ->where('quyen', '=', 1)
            ->where('canbo', '=', 1)
            ->where('users.khoa_id', '=', $khoa_cb)
            ->get();
        return view('Admin.CTSV.NguoiDung.CanBoKhoa.filter', compact(
            'title',
            'canbo',
            'khoa', 'khoa_cb'
        ));
    }

    //TODO: 13. Thêm mới cán bộ khoa
    public function addCanBoKhoa()
    {
        $title = 'Thêm cán bộ khoa';
        $khoa = Khoa::orderBy('khoa_id', 'asc')->get();
        $canbo = User::orderBy('id', 'asc')
            ->join('khoa', 'khoa.khoa_id', '=', 'users.khoa_id')
            ->get();
        return view('Admin.CTSV.NguoiDung.CanBoKhoa.add', compact(
            'title',
            'canbo',
            'khoa'
        ));
    }

    //TODO: 14. Lưu thêm mới cán bộ
    public function insertCanBoKhoa(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required',
                'fullname' => 'required',
                'email' => 'required',
                'password' => 'required',
                'diachi' => 'required',
                'sdt' => 'required',
                'ngaysinh' => 'required',
                'chucvu' => 'required',
            ],
            [
                'name.required' => 'Vui lòng nhập mã cán bộ',
                'fullname.required' => 'Vui lòng nhập tên cán bộ',
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Nhập không đúng định dạng email',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'diachi.required' => 'Vui lòng nhập địa chỉ',
                'sdt.required' => 'Vui lòng nhập địa chỉ',
                'ngaysinh.required' => 'Vui lòng chọn ngày sinh',
                'chucvu.required' => 'Vui lòng nhập chức vụ'
            ]
        );
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $user = new User();
        $user->name = $request->name;
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->diachi = $request->diachi;
        $user->sdt = $request->sdt;
        $user->gioitinh = $request->gioitinh;
        $user->ngaysinh = $request->ngaysinh;
        $user->khoa_id = $request->khoa_id;
        $user->chucvu = $request->chucvu;
        $user->tinhtrang = 1;
        $user->quyen = 1;
        $user->canbo = 1;
        $user->ngayDuyetTV = now();
        if (User::where('name', '=', $request->name)->count() > 0) {
            session()->put('message', 'Mã cán bộ này đã tồn tại');
            return redirect()->back();
        }
        if (User::where('email', '=', $request->email)->count() > 0) {
            session()->put('message', 'Email cán bộ này đã tồn tại');
            return redirect()->back();
        }
        $user->save();
        session()->put('message', 'Thêm cán bộ khoa thành công');
        return redirect()->route('show_canbo');
    }
    //TODO: 14. Cập nhật chức vụ
    public function editCanBoKhoa($id)
    {
        $title = 'Cập nhật chức vụ sinh viên';
        $canbokhoa = User::find($id);
        if ($canbokhoa) {
            return view('Admin.CTSV.NguoiDung.CanBoKhoa.editChucVu', compact('title', 'canbokhoa'));
        }
    }

    //TODO: 15. Lưu cập nhật chức vụ
    public function updateCanBoKhoa($id, Request $request)
    {
        $data = $request->all();
        $user = User::find($id);
        $user->chucvu = $data['chucvu'];
        $user->update($data);
        session()->put('message', 'Cập nhật chức vụ thành công');
        return redirect()->route('show_canbo');
    }

    //TODO: 16. Hủy chức vụ cán bộ
    public function deleteCanBoKhoa(Request $request, $id)
    {
        User::where('id', $id)->update([
            'canbo' => 0,
            'chucvu' => NULL,
            'quyen' => 4
        ]);
        session()->put('message', 'Hủy chức vụ cán bộ thành công');
        return redirect()->route('show_canbo');
    }

    //TODO: 17. Tìm kiếm cán bộ
    public function searchCanBoKhoa(Request $request)
    {
        $title = 'Danh sách cán bộ khoa';
        $search = $request->get('search');
        $khoa = Khoa::orderBy('khoa_id', 'asc')->get();
        $canbo = User::orderBy('id', 'asc')
            ->join('khoa', 'khoa.khoa_id', '=', 'users.khoa_id')
            ->where('quyen', '=', 1)
            ->where('fullname', 'like', '%' . $search . '%')
            ->paginate(10);
        return view('Admin.CTSV.NguoiDung.CanBoKhoa.index', compact(
            'title',
            'canbo',
            'khoa',
            'search'
        ));
    }

    //TODO: -----------V. Cán bộ khoa---------------
    public function infoCBK(Request $request) {
        $title = "Thông tin cán bộ khoa";
        $id = Auth::user()->id;
        $khoa = Khoa::orderBy('khoa_id', 'asc')->get();
        $cbk = User::where('id', '=', $id)
        ->join('khoa', 'khoa.khoa_id', '=', 'users.khoa_id')
        ->first();
        return view('Admin.CanBoKhoa.ThongTin.updateCBK', compact('title', 'cbk', 'khoa'));
    }


     public function updateCBK(Request $request)
        {
            if (Gate::allows('cbk')) {
                $data = $request->all();
                $data['id'] = Auth::user()->id;
                $cbk = User::find($data['id']);
                $cbk ->sdt = $data['sdt'];
                $cbk ->gioitinh = $data['gioitinh'];
                $cbk ->ngaysinh = $data['ngaysinh'];
                $cbk ->diachi = $data['diachi'];
                $cbk ->save();
                session()->put('message','Cập nhật thông tin thành công');
                return redirect()->back();
            }
            return redirect()->back();
    
    }
    
}
