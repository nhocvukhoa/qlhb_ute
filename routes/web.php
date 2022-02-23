<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;
use \App\Http\Controllers\AdminController;
use \App\Http\Controllers\LoaiHocBongController;
use \App\Http\Controllers\HocBongController;
use \App\Http\Controllers\HocKyController;
use \App\Http\Controllers\NamHocController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\KhoaController;
use \App\Http\Controllers\NganhController;
use \App\Http\Controllers\LopController;
use \App\Http\Controllers\TieuChiController;
use \App\Http\Controllers\ContactController;
use \App\Http\Controllers\ThongBaoController;
use \App\Http\Controllers\ThongKeController;
use \App\Http\Controllers\DiemRenLuyenController;
use \App\Http\Controllers\DiemHocTapController;
use \App\Http\Controllers\DiemController;
use \App\Http\Controllers\SinhVienCanBoController;
use \App\Http\Controllers\SlideController;
use \App\Http\Controllers\TieuChiHocBongController;


use \App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//TODO: 1. Khách vãng lai
Route::get('/', [HomeController::class, 'index']);
Route::get('/trangchu', [HomeController::class, 'index'])->name('home');
Route::get('/timkiem-hocbong', [HomeController::class, 'searchHocBong'])->name('searchHocBong');
Route::get('/danhmuc-hocbong/{loaihocbong_id}', [LoaiHocBongController::class, 'showHocBongByType']);
Route::post('/lochocbong', [HomeController::class, 'filterHocBong'])->name('filterHocBong');
Route::get('/chitiet-hocbong/{hocbong_id}', [HomeController::class, 'detailHocBongHome'])->name('detail.home');
Route::get('/top-dangky', [HomeController::class, 'topDangKy'])->name('top.dangkyhocbong');
Route::get('/thongbao', [HomeController::class, 'listThongBao'])->name('list_thongbao');
Route::get('/chitiet-thongbao/{thongbao_id}', [HomeController::class, 'detailThongBao'])->name('detail_thongbao');

Route::get('/lienhe', [ContactController::class, 'contactUs'])->name('lienhe');
Route::post('/send', [ContactController::class, 'send']);

//TODO: 2. Admin
Route::get('/admin', [AdminController::class, 'index'])->name('show_form_login');
Route::post('/login', [AdminController::class, 'login'])->name('admin_login');
Route::get('/logout', [AdminController::class, 'logout'])->name('admin_logout');

Route::middleware('admin')->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');

    //TODO: 2.1. CTSV
    Route::prefix('ctsv')->group(function () {

        Route::prefix('loaihocbong')->group(function () {
            Route::get('/list', [LoaiHocBongController::class, 'list'])->name('show_loaihocbong');
            Route::get('/add', [LoaiHocBongController::class, 'add'])->name('add_loaihocbong');
            Route::post('/insert', [LoaiHocBongController::class, 'insert'])->name('insert_loaihocbong');
            Route::get('/edit/{loaihocbong_id}', [LoaiHocBongController::class, 'edit'])->name('edit_loaihocbong');
            Route::post('/update/{loaihocbong_id}', [LoaiHocBongController::class, 'update'])->name('update_loaihocbong');
            Route::get('/delete/{loaihocbong_id}', [LoaiHocBongController::class, 'delete'])->name('delete_loaihocbong');
            Route::get('/search', [LoaiHocBongController::class, 'search'])->name('search_loaihocbong');
        });

        Route::prefix('hocbong')->group(function () {
            Route::get('/list', [HocBongController::class, 'list'])->name('show_hocbong');
            Route::get('/add', [HocBongController::class, 'add'])->name('add_hocbong');
            Route::post('/insert', [HocBongController::class, 'insert'])->name('insert_hocbong');
            Route::get('/edit/{hocbong_id}', [HocBongController::class, 'edit'])->name('edit_hocbong');
            Route::post('/update/{hocbong_id}', [HocBongController::class, 'update'])->name('update_hocbong');
            Route::get('/detail/{hocbong_id}', [HocBongController::class, 'detail'])->name('detail_hocbong');
            Route::get('/delete/{hocbong_id}', [HocBongController::class, 'delete'])->name('delete_hocbong');
            Route::get('/search', [HocBongController::class, 'search'])->name('search_hocbong');
            Route::get('/apply/{hocbong_id}', [HocBongController::class, 'apply'])->name('apply_hocbong');
            Route::get('detail-apply/{dangky_id}', [HocBongController::class, 'detailApply'])->name('apply_detail_hocbong');
            Route::get('/accept-apply/{dangky_id}', [HocBongController::class, 'acceptApply'])->name('apply_accept');
            Route::get('/accept-apply-filterNote/{dangky_id}', [HocBongController::class, 'acceptApplyFilterNote'])->name('apply_accept_filterNote');
            Route::post('/export-selected-list/{hocbong_id}', [HocBongController::class, 'exportSelectedList'])->name('export_selected_list');

            Route::post('/addNote/{dangky_id}', [HocBongController::class, 'addNoteAdmin'])->name('add.note_admin');
            Route::get('/filterNote/{hocbong_id}', [HocBongController::class, 'filterNoteAdmin'])->name('filter.note_admin');
            Route::get('/apply-return/{hocbong_id}', [HocBongController::class, 'applyReturn'])->name('return.apply_hocbong');
        });

        Route::prefix('namhoc')->group(function() {
            Route::get('/list', [NamHocController::class, 'list'])->name('show_namhoc');
            Route::get('/add', [NamHocController::class, 'add'])->name('add_namhoc');
            Route::post('/insert', [NamHocController::class, 'insert'])->name('insert_namhoc');
            Route::get('/edit/{namhoc_id}', [NamHocController::class, 'edit'])->name('edit_namhoc');
            Route::post('/update/{namhoc_id}', [NamHocController::class, 'update'])->name('update_namhoc');
            Route::get('/delete/{namhoc_id}', [NamHocController::class, 'delete'])->name('delete_namhoc');
            Route::get('/search', [NamHocController::class, 'search'])->name('search_namhoc');
        });

        Route::prefix('hocky')->group(function() {
            Route::get('/list', [HocKyController::class, 'list'])->name('show_hocky');
            Route::get('/add', [HocKyController::class, 'add'])->name('add_hocky');
            Route::post('/insert', [HocKyController::class, 'insert'])->name('insert_hocky');
            Route::get('/edit/{hocky_id}', [HocKyController::class, 'edit'])->name('edit_hocky');
            Route::post('/update/{hocky_id}', [HocKyController::class, 'update'])->name('update_hocky');
            Route::get('/delete/{hocky_id}', [HocKyController::class, 'delete'])->name('delete_hocky');
            Route::get('/search', [HocKyController::class, 'search'])->name('search_hocky');
        });

        Route::prefix('khoa')->group(function () {
            Route::get('/list', [KhoaController::class, 'list'])->name('show_khoa');
            Route::get('/add', [KhoaController::class, 'add'])->name('add_khoa');
            Route::post('/insert', [KhoaController::class, 'insert'])->name('insert_khoa');
            Route::get('/edit/{khoa_id}', [KhoaController::class, 'edit'])->name('edit_khoa');
            Route::post('/update/{khoa_id}', [KhoaController::class, 'update'])->name('update_khoa');
            Route::get('/delete/{khoa_id}', [KhoaController::class, 'delete'])->name('delete_khoa');
            Route::get('/search', [KhoaController::class, 'search'])->name('search_khoa');
        });

        Route::prefix('nganh')->group(function () {
            Route::get('/list', [NganhController::class, 'list'])->name('show_nganh');
            Route::get('/add', [NganhController::class, 'add'])->name('add_nganh');
            Route::post('/insert', [NganhController::class, 'insert'])->name('insert_nganh');
            Route::get('/edit/{nganh_id}', [NganhController::class, 'edit'])->name('edit_nganh');
            Route::post('/update/{nganh_id}', [NganhController::class, 'update'])->name('update_nganh');
            Route::get('/delete/{nganh_id}', [NganhController::class, 'delete'])->name('delete_nganh');
            Route::get('/search', [NganhController::class, 'search'])->name('search_nganh');
        });

        Route::prefix('lop')->group(function () {
            Route::get('/list', [LopController::class, 'list'])->name('show_lop');
            Route::get('/add', [LopController::class, 'add'])->name('add_lop');
            Route::post('/insert', [LopController::class, 'insert'])->name('insert_lop');
            Route::get('/edit/{lop_id}', [LopController::class, 'edit'])->name('edit_lop');
            Route::post('/update/{lop_id}', [LopController::class, 'update'])->name('update_lop');
            Route::get('/delete/{lop_id}', [LopController::class, 'delete'])->name('delete_lop');
            Route::get('/search', [LopController::class, 'search'])->name('search_lop');
        });

        Route::prefix('tieuchi')->group(function () {
            Route::get('/list', [TieuChiController::class, 'list'])->name('show_tieuchi');
            Route::get('/add', [TieuChiController::class, 'add'])->name('add_tieuchi');
            Route::post('/insert', [TieuChiController::class, 'insert'])->name('insert_tieuchi');
            Route::get('/edit/{tieuchi_id}', [TieuChiController::class, 'edit'])->name('edit_tieuchi');
            Route::post('/update/{tieuchi_id}', [TieuChiController::class, 'update'])->name('update_tieuchi');
            Route::get('/delete/{tieuchi_id}', [TieuChiController::class, 'delete'])->name('delete_tieuchi');
        });

        Route::prefix('tieuchi_hocbong')->group(function () {
            Route::get('/list', [TieuChiHocBongController::class, 'list'])->name('show_tieuchihocbong');
            Route::get('/add', [TieuChiHocBongController::class, 'add'])->name('add_tieuchihocbong');
            Route::post('/insert', [TieuChiHocBongController::class, 'insert'])->name('insert_tieuchihocbong');
            Route::get('/edit/{id}', [TieuChiHocBongController::class, 'edit'])->name('edit_tieuchihocbong');
            Route::post('/update/{id}', [TieuChiHocBongController::class, 'update'])->name('update_tieuchihocbong');
            Route::get('/delete/{id}', [TieuChiHocBongController::class, 'delete'])->name('delete_tieuchihocbong');
        });

        Route::prefix('thongbao')->group(function () {
            Route::get('/list', [ThongBaoController::class, 'list'])->name('show_thongbao');
            Route::get('/add', [ThongBaoController::class, 'add'])->name('add_thongbao');
            Route::post('/insert', [ThongBaoController::class, 'insert'])->name('insert_thongbao');
            Route::get('/edit/{thongbao_id}', [ThongBaoController::class, 'edit'])->name('edit_thongbao');
            Route::post('/update/{thongbao_id}', [ThongBaoController::class, 'update'])->name('update_thongbao');
            Route::get('/delete/{thongbao_id}', [ThongBaoController::class, 'delete'])->name('delete_thongbao');
        });

        Route::prefix('slide')->group(function () {
            Route::get('/list', [SlideController::class, 'list'])->name('show_slide');
            Route::get('/add', [SlideController::class, 'add'])->name('add_slide');
            Route::post('/insert', [SlideController::class, 'insert'])->name('insert_slide');
            Route::get('/edit/{slide_id}', [SlideController::class, 'edit'])->name('edit_slide');
            Route::post('/update/{slide_id}', [SlideController::class, 'update'])->name('update_slide');
            Route::get('/delete/{slide_id}', [SlideController::class, 'delete'])->name('delete_slide');
        });

        Route::prefix('nguoidung')->group(function () {
            Route::prefix('sinhvien')->group(function () {
                Route::get('/list', [UserController::class, 'listSinhVien'])->name('show_sinhvien');
                Route::post('/importSinhVien', [UserController::class, 'importSinhVien'])->name('import_sinhvien');
                Route::get('/edit_canbo/{id}', [UserController::class, 'editCanBoSV'])->name('edit_canbo_sinhvien');
                Route::post('/update_canbo/{id}', [UserController::class, 'updateCanBoSV'])->name('update_canbo_sinhvien');
                Route::get('/delete_canbo/{id}', [UserController::class, 'deleteCanBoSV'])->name('delete_canbo_sinhvien');
                Route::get('/search', [UserController::class, 'searchSinhVien'])->name('search_sinhvien');
                Route::get('/filter', [UserController::class, 'filterSinhVien'])->name('filter_sinhvien');
            });

            Route::prefix('canbo')->group(function () {
                Route::get('/list', [UserController::class, 'listCanBoKhoa'])->name('show_canbo');
                Route::get('/add', [UserController::class, 'addCanBoKhoa'])->name('add_canbo');
                Route::post('/insert', [UserController::class, 'insertCanBoKhoa'])->name('insert_canbo');
                Route::get('/edit/{id}', [UserController::class, 'editCanBoKhoa'])->name('edit_canbo');
                Route::post('/update/{id}', [UserController::class, 'updateCanBoKhoa'])->name('update_canbo');
                Route::get('/delete/{id}', [UserController::class, 'deleteCanBoKhoa'])->name('delete_canbo');
                Route::get('/search', [UserController::class, 'searchCanBoKhoa'])->name('search_canbokhoa');
                Route::get('/filter', [UserController::class, 'filterCanBoKhoa'])->name('filter_canbo');
            });
        });

        Route::prefix('duyettaikhoan')->group(function () {
            Route::get('/list-accept-account', [UserController::class, 'listAcceptAccount'])->name('list_account');
            Route::get('/active-user/{id}', [UserController::class, 'activeUser'])->name('active_user');;
            Route::get('/delete-user/{id}', [UserController::class, 'deleteUser'])->name('delete_user');
        });

        Route::prefix('duyetbaidang')->group(function () {
            Route::get('/list', [UserController::class, 'listAcceptPost'])->name('list_post');
            Route::get('/detail/{hocbong_id}', [UserController::class, 'detailAcceptPost'])->name('detail_post');
            Route::get('/active/{hocbong_id}', [UserController::class, 'activePost'])->name('active_post');
            Route::get('/delete/{hocbong_id}', [UserController::class, 'deletePost'])->name('delete_post');
        });

        Route::prefix('thietlapquyen')->group(function() {
            Route::get('/list-role', [UserController::class, 'listRole'])->name('show_thietlapquyen');
            Route::get('/search', [UserController::class, 'searchUser'])->name('search_user');
            Route::get('/blocked-user/{id}', [UserController::class, 'blockedUser'])->name('blocked_user');
            Route::get('/open-user/{id}', [UserController::class, 'openUser'])->name('open_user');
        });

        Route::prefix('import')->group(function () {
            Route::get('/diemrenluyen', [DiemRenLuyenController::class, 'index'])->name('show_diemrl');
            Route::post('/import', [DiemRenLuyenController::class, 'importDRL'])->name('import_diemrl');
            Route::get('/loc', [DiemRenLuyenController::class, 'filterDRL'])->name('filter_diemrl');

            Route::get('/diemhoctap', [DiemHocTapController::class, 'index'])->name('show_diemht');
            Route::post('/importDHT', [DiemHocTapController::class, 'importDHT'])->name('import_diemht');
            Route::get('/locDHT', [DiemHocTapController::class, 'filterDHT'])->name('filter_diemht');

            Route::get('/diem', [DiemController::class, 'listDiem'])->name('show_diem');
            Route::post('/import_diem', [DiemController::class, 'importDiem'])->name('import_diem');
            Route::get('/loc_diem', [DiemController::class, 'filterDiem'])->name('filter_diem');

            Route::get('/list', [SinhVienCanBoController::class, 'listSinhVienCB'])->name('show_sinhviencanbo');
            Route::post('/importSVCB', [SinhVienCanBoController::class, 'importSinhVienCanBo'])->name('import_sinhviencanbo');
            Route::get('/loc_sinhviencanbo', [SinhVienCanBoController::class, 'filterSinhVienCanBo'])->name('filter_sinhviencanbo');

        });

        Route::prefix('thongke')->group(function () {
            Route::get('/index', [ThongKeController::class, 'index'])->name('thongke_index');
            Route::get('/loc-top', [ThongKeController::class, 'filterTop'])->name('filter_top');
            Route::get('/max-register', [ThongKeController::class, 'maxRegister'])->name('thongke_max_register');
            Route::get('/total-bySemester', [ThongKeController::class, 'totalBySemester'])->name('thongke_total_bysemester');
            Route::get('/total-studentApply', [ThongKeController::class, 'totalStudentApply'])->name('thongke_total_student_apply');
            Route::get('/diemrenluyen', [ThongKeController::class, 'pointTraining'])->name('thongke_diemrenluyen');
            Route::get('/loc-diemrenluyen', [ThongKeController::class, 'filterPointTraining'])->name('thongke_filter_drl');
            Route::get('/diemhoctap', [ThongKeController::class, 'pointStudy'])->name('thongke_diemhoctap');
        });
    });

     //TODO: 2.2. Cán bộ khoa
    Route::prefix('cbk')->group(function () {
        Route::prefix('diemrenluyen')->group(function () {
            Route::get('/list', [DiemRenLuyenController::class, 'list'])->name('show_diemrl_cbk');
            Route::get('/loc', [DiemRenLuyenController::class, 'filterDRLCBK'])->name('filter_diemrl_cbk');
            Route::get('/export', [DiemRenLuyenController::class, 'exportDRL'])->name('export_diemrl_cbk');
        });

        Route::prefix('diemhoctap')->group(function () {
            Route::get('/list', [DiemHocTapController::class, 'listDHT'])->name('show_diemht_cbk');
            Route::get('/loc_diemhoctap', [DiemHocTapController::class, 'filterDHTCBK'])->name('filter_diemht_cbk');
        });

        Route::prefix('diem')->group(function() {
            Route::get('/list', [DiemController::class, 'listDiemCBK'])->name('show_Diem');
            Route::get('/filter', [DiemController::class, 'filterDiemCBK'])->name('filter_Diem');
        });

        Route::get('/thongtincanbo', [UserController::class, 'infoCBK'])->name('info_cbk');
        Route::post('/update_thongtincanbo', [UserController::class, 'updateCBK'])->name('update_cbk');
    });
});


//TODO: 3. Người dùng hệ thống
Route::get('/user/login', [UserController::class, 'showLoginHome'])->name('show_form_login_home');
Route::post('/user/login-client', [UserController::class, 'loginClient'])->name('client_login');
Route::get('/user/register', [UserController::class, 'showRegisterHome'])->name('show_register_home');
Route::post('/user/register-client', [UserController::class, 'registerClient'])->name('register_login');
Route::get('/logout-client', [UserController::class, 'logoutClient'])->name('client_logout');

Route::middleware('checkloginclient')->group(function () {

    //TODO: 3.1 Sinh viên
    Route::prefix('sinhvien')->group(function() {
        Route::get('/thongtincanhan', [UserController::class, 'studentInformation'])->name('thongtin');
        Route::post('/update-student', [UserController::class, 'updateStudent'])->name('capnhatthongtin_sv');
        Route::get('/danhsachdangky', [UserController::class, 'listRegister'])->name('danhsachdangky');
    });

    //TODO: 3.2 Nhà tài trợ
    Route::prefix('nhataitro')->group(function() {
        Route::get('/thongtincanhan', [UserController::class, 'sponsorInformation'])->name('thongtin_ntt');
        Route::post('/update-sponsor', [UserController::class, 'updateSponsor'])->name('capnhatthongtin_ntt');

        Route::get('/danghocbong', [UserController::class, 'post'])->name('danghocbong_ntt');
        Route::post('/save', [UserController::class, 'save'])->name('luubaidang_ntt');

        Route::get('/lichsu', [UserController::class, 'showHistory'])->name('lichsu_ntt');
        
        Route::get('/edit/{hocbong_id}', [UserController::class, 'editPost'])->name('edit_baidang_ntt');
        Route::post('/update/{hocbong_id}', [UserController::class, 'updatePost'])->name('update_baidang_ntt');

        Route::get('/apply/{hocbong_id}', [UserController::class, 'listApply'])->name('apply_hocbong_ntt');
        Route::get('/apply-return/{hocbong_id}', [UserController::class, 'applyReturnDS'])->name('return.apply_dshocbong');
        Route::get('/detail-apply/{dangky_id}', [UserController::class, 'detailApply'])->name('apply_detail_hocbong_ntt');
        Route::get('/accept-apply/{dangky_id}', [UserController::class, 'acceptApply'])->name('apply_accept_hocbong_ntt');
        Route::get('/accept-apply-filter/{dangky_id}', [UserController::class, 'acceptApplyFilter'])->name('apply_accept_hocbong_ntt_filter');
        Route::post('/accept-apply-checkbox', [UserController::class, 'acceptApplyCheckbox'])->name('apply_accept_hocbong_ntt_checkbox');
        Route::post('/export-selected/{hocbong_id}', [UserController::class, 'exportSelected'])->name('apply_export');

        Route::post('/add/{dangky_id}', [UserController::class, 'addNote'])->name('add.note');
        Route::get('/filter/{hocbong_id}', [UserController::class, 'filterNote'])->name('filter.note');
        // Route::get('/accept/{dangky_id}', [UserController::class, 'acceptApply'])->name('apply.accept');


    });
    
   
    //Route::get('/show-detail-post-history/{$hocbong_id}', [UserController::class, 'showDetailPostHistory']);

    Route::post('/dangky-hocbong', [UserController::class, 'dangkyHocBong'])->name('admin.register');;
});
