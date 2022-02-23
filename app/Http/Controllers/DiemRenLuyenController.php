<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DiemRenLuyen;
use App\Imports\ImportDanhSachDRL;
use App\Models\Khoa;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Exports\ExportDanhSachDRL;
use Brian2694\Toastr\Facades\Toastr;


class DiemRenLuyenController extends Controller
{
    //TODO: -----------------I. Công tác sinh viên --------------------
    //TODO: 1. Hiển thị danh sách điểm rèn luyện
    public function index(Request $request)
    {
        $title = "Điểm rèn luyện";
        $diemrenluyen_hocky = DiemRenLuyen::select('diemrenluyen_hocky')
            ->groupBy('diemrenluyen_hocky')
            ->orderBy('diemrenluyen_hocky', 'desc')
            ->get();
        $diemrenluyen_khoa = DiemRenLuyen::select('diemrenluyen_khoa')
            ->groupBy('diemrenluyen_khoa')
            ->orderBy('diemrenluyen_khoa', 'desc')
            ->get();
        $diemrenluyen_nganh = DiemRenLuyen::select('diemrenluyen_nganh')
            ->groupBy('diemrenluyen_nganh')
            ->orderBy('diemrenluyen_nganh', 'desc')
            ->get();
        $diemrenluyen_lop = DiemRenLuyen::select('diemrenluyen_lop')
            ->groupBy('diemrenluyen_lop')
            ->orderBy('diemrenluyen_lop', 'desc')
            ->get();
        $Hocky = $request->diemrenluyen_hocky;
        $Khoa = $request->diemrenluyen_khoa;
        $Nganh = $request->diemrenluyen_nganh;
        $Lop = $request->diemrenluyen_lop;
        $diemrenluyen = DiemRenLuyen::orderBy('diemrenluyen_id', 'asc')->paginate(15);
        return view('Admin.CTSV.Diem.DiemRenLuyen.index', compact(
            'title',
            'Hocky',
            'Khoa',
            'Nganh',
            'Lop',
            'diemrenluyen',
            'diemrenluyen_hocky',
            'diemrenluyen_khoa',
            'diemrenluyen_nganh',
            'diemrenluyen_lop'
        ));
    }

    //TODO: 2. Import file điểm rèn luyện
    public function importDRL(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        Excel::import(new ImportDanhSachDRL, $path);
        session()->put('message', 'Import file excel thành công');
        return redirect()->back();
    }

    //TODO: 3. Lọc dữ liệu
    public function filterDRL(Request $request)
    {
        $title = "Lọc";
        $diemrenluyen_hocky = DiemRenLuyen::select('diemrenluyen_hocky')
            ->groupBy('diemrenluyen_hocky')
            ->orderBy('diemrenluyen_hocky', 'desc')
            ->get();
        $diemrenluyen_khoa = DiemRenLuyen::select('diemrenluyen_khoa')
            ->groupBy('diemrenluyen_khoa')
            ->orderBy('diemrenluyen_khoa', 'desc')
            ->get();
        $diemrenluyen_nganh = DiemRenLuyen::select('diemrenluyen_nganh')
            ->groupBy('diemrenluyen_nganh')
            ->orderBy('diemrenluyen_nganh', 'desc')
            ->get();
        $diemrenluyen_lop = DiemRenLuyen::select('diemrenluyen_lop')
            ->groupBy('diemrenluyen_lop')
            ->orderBy('diemrenluyen_lop', 'desc')
            ->get();
        $Soluong = $request->soluong;
        $Hocky = $request->diemrenluyen_hocky;
        $Khoa = $request->diemrenluyen_khoa;
        $Nganh = $request->diemrenluyen_nganh;
        $Lop = $request->diemrenluyen_lop;
        $diemrenluyen = DiemRenLuyen::orderBy('diemrenluyen_id', 'asc')
            ->when($Hocky, function ($query) use ($Hocky) {
                $query->where('diemrenluyen_hocky', 'like', '%' . $Hocky . '%');
            })->when($Khoa, function ($query) use ($Khoa) {
                $query->where('diemrenluyen_khoa', 'like', '%' . $Khoa . '%');
            })->when($Nganh, function ($query) use ($Nganh) {
                $query->where('diemrenluyen_nganh', 'like', '%' . $Nganh . '%');
            })->when($Lop, function ($query) use ($Lop) {
                $query->where('diemrenluyen_lop', 'like', '%' . $Lop . '%');
            })
            ->paginate(10);

        return view('Admin.CTSV.Diem.DiemRenLuyen.index', compact(
            'title',
            'Hocky',
            'Khoa',
            'Nganh',
            'Lop',
            'diemrenluyen',
            'diemrenluyen_hocky',
            'diemrenluyen_khoa',
            'diemrenluyen_nganh',
            'diemrenluyen_lop'
        ));
    }

    //TODO: ------------------II. Cán bộ khoa------------------------
    //TODO: 1. Hiển thị danh sách điểm rèn luyện
    public function list(Request $request)
    {
        $title = "Điểm rèn luyện";
        $diemrenluyen_hocky = DiemRenLuyen::select('diemrenluyen_hocky')
            ->groupBy('diemrenluyen_hocky')
            ->orderBy('diemrenluyen_hocky', 'desc')
            ->get();
        $diemrenluyen_khoa = DiemRenLuyen::select('diemrenluyen_khoa')
            ->groupBy('diemrenluyen_khoa')
            ->orderBy('diemrenluyen_khoa', 'desc')
            ->get();
        $diemrenluyen_nganh = DiemRenLuyen::select('diemrenluyen_nganh')
            ->groupBy('diemrenluyen_nganh')
            ->orderBy('diemrenluyen_nganh', 'desc')
            ->get();
        $diemrenluyen_lop = DiemRenLuyen::select('diemrenluyen_lop')
            ->groupBy('diemrenluyen_lop')
            ->orderBy('diemrenluyen_lop', 'desc')
            ->get();
        $Soluong = $request->get('soluong');
        $Hocky = $request->diemrenluyen_hocky;
        $Khoa = $request->diemrenluyen_khoa;
        $Nganh = $request->diemrenluyen_nganh;
        $Lop = $request->diemrenluyen_lop;
        $diemrenluyen = DiemRenLuyen::orderBy('diemrenluyen_id', 'asc')->paginate(10);
        return view('Admin.CanBoKhoa.DiemRenLuyen.list', compact(
            'title',
            'Soluong',
            'Hocky',
            'Khoa',
            'Nganh',
            'Lop',
            'diemrenluyen',
            'diemrenluyen_hocky',
            'diemrenluyen_khoa',
            'diemrenluyen_nganh',
            'diemrenluyen_lop',
            'Soluong'
        ));
    }
    //TODO: 2. Lọc dữ liệu
    public function filterDRLCBK(Request $request)
    {
        $title = "Lọc điểm rèn luyện";
        $diemrenluyen_hocky = DiemRenLuyen::select('diemrenluyen_hocky')
            ->groupBy('diemrenluyen_hocky')
            ->orderBy('diemrenluyen_hocky', 'desc')
            ->get();
        $diemrenluyen_khoa = DiemRenLuyen::select('diemrenluyen_khoa')
            ->groupBy('diemrenluyen_khoa')
            ->orderBy('diemrenluyen_khoa', 'desc')
            ->get();
        $diemrenluyen_nganh = DiemRenLuyen::select('diemrenluyen_nganh')
            ->groupBy('diemrenluyen_nganh')
            ->orderBy('diemrenluyen_nganh', 'desc')
            ->get();
        $diemrenluyen_lop = DiemRenLuyen::select('diemrenluyen_lop')
            ->groupBy('diemrenluyen_lop')
            ->orderBy('diemrenluyen_lop', 'desc')
            ->get();
        
        $Soluong = $request->input('soluong');
        $Hocky = $request->diemrenluyen_hocky;
        $Khoa = $request->diemrenluyen_khoa;
        $Nganh = $request->diemrenluyen_nganh;
        $Lop = $request->diemrenluyen_lop;
     
        $xml_version = '<?xml version="1.0"?>';

        $diemrenluyen = DiemRenLuyen::orderBy('diemrenluyen_diem', 'desc')
            ->when($Hocky, function ($query) use ($Hocky) {
                $query->where('diemrenluyen_hocky', 'like', '%' . $Hocky . '%');
            })->when($Khoa, function ($query) use ($Khoa) {
                $query->where('diemrenluyen_khoa', 'like', '%' . $Khoa . '%');
            })->when($Nganh, function ($query) use ($Nganh) {
                $query->where('diemrenluyen_nganh', 'like', '%' . $Nganh . '%');
            })->when($Lop, function ($query) use ($Lop) {
                $query->where('diemrenluyen_lop', 'like', '%' . $Lop . '%');
            })->limit($Soluong)->get(); 

        return view('Admin.CanBoKhoa.DiemRenLuyen.filter', compact(
            'title',
            'Soluong',
            'Hocky',
            'Khoa',
            'Nganh',
            'Lop',
            'diemrenluyen',
            'diemrenluyen_hocky',
            'diemrenluyen_khoa',
            'diemrenluyen_nganh',
            'diemrenluyen_lop',
            'xml_version'
        ));
    }

    //TODO: 3. Xuất dữ liệu sau khi lọc
    public function exportDRL(Request $request)
    {

        $Hocky = $request->diemrenluyen_hocky;
        $Khoa = $request->diemrenluyen_khoa;
        $Nganh = $request->diemrenluyen_nganh;
        $Lop = $request->diemrenluyen_lop;
        $Soluong = $request->input('soluong');

        $diemrenluyen = DiemRenLuyen::orderBy('diemrenluyen_diem', 'desc')
            ->when($Hocky, function ($query) use ($Hocky) {
                $query->where('diemrenluyen_hocky', 'like', '%' . $Hocky . '%');
            })->when($Khoa, function ($query) use ($Khoa) {
                $query->where('diemrenluyen_khoa', 'like', '%' . $Khoa . '%');
            })->when($Nganh, function ($query) use ($Nganh) {
                $query->where('diemrenluyen_nganh', 'like', '%' . $Nganh . '%');
            })->when($Lop, function ($query) use ($Lop) {
                $query->where('diemrenluyen_lop', 'like', '%' . $Lop . '%');
            })->limit($Soluong)->get();
        

        return Excel::download(new ExportDanhSachDRL($diemrenluyen), 'DS_DiemRenLuyen.xlsx');
    }
}
