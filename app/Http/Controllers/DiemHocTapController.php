<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiemHocTap;
use App\Imports\ImportDanhSachDHT;
use App\Models\Khoa;
use Maatwebsite\Excel\Facades\Excel;

class DiemHocTapController extends Controller
{
    //TODO: --------------- I. Công tác sinh viên ------------------------------
    //TODO: 1. Hiển thị điểm học tập
    public function index(Request $request)
    {
        $title = "Điểm học tập";
        $diemhoctap_hocky = DiemHocTap::select('diemhoctap_hocky')
            ->groupBy('diemhoctap_hocky')
            ->orderBy('diemhoctap_hocky', 'desc')
            ->get();
        $diemhoctap_khoa = DiemHocTap::select('diemhoctap_khoa')
            ->groupBy('diemhoctap_khoa')
            ->orderBy('diemhoctap_khoa', 'desc')
            ->get();
        $diemhoctap_nganh = DiemHocTap::select('diemhoctap_nganh')
            ->groupBy('diemhoctap_nganh')
            ->orderBy('diemhoctap_nganh', 'desc')
            ->get();
        $diemhoctap_lop = DiemHocTap::select('diemhoctap_lop')
            ->groupBy('diemhoctap_lop')
            ->orderBy('diemhoctap_lop', 'desc')
            ->get();
        $Hocky = $request->diemhoctap_hocky;
        $Khoa = $request->diemhoctap_khoa;
        $Nganh = $request->diemhoctap_nganh;
        $Lop = $request->diemhoctap_lop;
        $diemhoctap = DiemHocTap::orderBy('diemhoctap_id', 'asc')->paginate(15);
        return view('Admin.CTSV.Diem.DiemHocTap.index', compact('title', 'diemhoctap',
        'diemhoctap_hocky', 'diemhoctap_khoa', 'diemhoctap_nganh', 'diemhoctap_lop',
        'Hocky', 'Khoa', 'Nganh', 'Lop'));
    }

    //TODO: 2. Import dữ liệu điểm
    public function importDHT(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        Excel::import(new ImportDanhSachDHT, $path);
        session()->put('message', 'Import file excel điểm học tập thành công');
        return redirect()->back();
    }

    //TODO: 3. Lọc dữ liệu
    public function filterDHT(Request $request)
    {
        $title = "Lọc";
        $diemhoctap_hocky = DiemHocTap::select('diemhoctap_hocky')
            ->groupBy('diemhoctap_hocky')
            ->orderBy('diemhoctap_hocky', 'desc')
            ->get();
        $diemhoctap_khoa = DiemHocTap::select('diemhoctap_khoa')
            ->groupBy('diemhoctap_khoa')
            ->orderBy('diemhoctap_khoa', 'desc')
            ->get();
        $diemhoctap_nganh = DiemHocTap::select('diemhoctap_nganh')
            ->groupBy('diemhoctap_nganh')
            ->orderBy('diemhoctap_nganh', 'desc')
            ->get();
        $diemhoctap_lop = DiemHocTap::select('diemhoctap_lop')
            ->groupBy('diemhoctap_lop')
            ->orderBy('diemhoctap_lop', 'desc')
            ->get();
        $Soluong = $request->soluong;
        $Hocky = $request->diemhoctap_hocky;
        $Khoa = $request->diemhoctap_khoa;
        $Nganh = $request->diemhoctap_nganh;
        $Lop = $request->diemhoctap_lop;
        $diemhoctap = DiemHocTap::orderBy('diemhoctap_id', 'asc')
            ->when($Hocky, function ($query) use ($Hocky) {
                $query->where('diemhoctap_hocky', 'like', '%' . $Hocky . '%');
            })->when($Khoa, function ($query) use ($Khoa) {
                $query->where('diemhoctap_khoa', 'like', '%' . $Khoa . '%');
            })->when($Nganh, function ($query) use ($Nganh) {
                $query->where('diemhoctap_nganh', 'like', '%' . $Nganh . '%');
            })->when($Lop, function ($query) use ($Lop) {
                $query->where('diemhoctap_lop', 'like', '%' . $Lop . '%');
            })
            ->paginate(10);

        return view('Admin.CTSV.Diem.DiemHocTap.index', compact('title', 'diemhoctap',
            'diemhoctap_hocky', 'diemhoctap_khoa',  'diemhoctap_lop',
            'Hocky', 'Khoa', 'Nganh', 'Lop'));
    }

    //TODO: --------------II. Cán bộ khoa ------------------------
    //TODO: 1. Hiển thị điểm học tập
    public function listDHT(Request $request)
    {
        $title = "Điểm học tập";
        $diemhoctap_hocky = DiemHocTap::select('diemhoctap_hocky')
            ->groupBy('diemhoctap_hocky')
            ->orderBy('diemhoctap_hocky', 'desc')
            ->get();
        $diemhoctap_khoa = DiemHocTap::select('diemhoctap_khoa')
            ->groupBy('diemhoctap_khoa')
            ->orderBy('diemhoctap_khoa', 'desc')
            ->get();
    
        $Soluong = $request->get('soluong');
        $Hocky = $request->diemhoctap_hocky;
        $Khoa = $request->diemhoctap_khoa;
        $diemhoctap = DiemHocTap::orderBy('diemhoctap_id', 'asc')->paginate(10);
        return view('Admin.CanBoKhoa.DiemHocTap.index', compact('title', 'diemhoctap',
        'diemhoctap_hocky', 'diemhoctap_khoa', 
        'Hocky', 'Khoa',  'Soluong'));
    }
    //TODO: 2. Lọc dữ liệu
    public function filterDHTCBK(Request $request) {
        $title = "Lọc";
        $diemhoctap_hocky = DiemHocTap::select('diemhoctap_hocky')
            ->groupBy('diemhoctap_hocky')
            ->orderBy('diemhoctap_hocky', 'desc')
            ->get();
        $diemhoctap_khoa = DiemHocTap::select('diemhoctap_khoa')
            ->groupBy('diemhoctap_khoa')
            ->orderBy('diemhoctap_khoa', 'desc')
            ->get();
        $Soluong = $request->get('soluong');
        $Hocky = $request->diemhoctap_hocky;
        $Khoa = $request->diemhoctap_khoa;
        $diemhoctap = DiemHocTap::orderBy('diemhoctap_thang4', 'desc')
            ->when($Hocky, function ($query) use ($Hocky) {
                $query->where('diemhoctap_hocky', 'like', '%' . $Hocky . '%');
            })->when($Khoa, function ($query) use ($Khoa) {
                $query->where('diemhoctap_khoa', 'like', '%' . $Khoa . '%');
            })->limit($Soluong)->get(); 

        return view('Admin.CanBoKhoa.DiemHocTap.filter', compact('title', 'diemhoctap',
            'diemhoctap_hocky', 'diemhoctap_khoa', 
            'Hocky', 'Khoa', 'Soluong'));
    }
}
