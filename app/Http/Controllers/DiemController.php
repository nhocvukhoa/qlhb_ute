<?php

namespace App\Http\Controllers;

use App\Models\Diem;
use App\Models\Khoa;
use App\Models\Nganh;
use App\Models\Lop;
use App\Models\User;
use App\Imports\ImportDanhSachDiem;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DiemController extends Controller
{
    //TODO: -----------------CTSV-----------------
    public function listDiem(Request $request)
    {
        $title = "Danh sách điểm";
        $diem_hocky = Diem::select('diem_hocky')
            ->groupBy('diem_hocky')
            ->orderBy('diem_hocky', 'desc')
            ->get();
        $lop = Lop::orderBy('lop_id', 'asc')->get();
        $lop_ten = $request->input('lop');
        $Hocky = $request->diem_hocky;

        $diem = Diem::orderBy('diem_id', 'desc')->paginate(5);
        return view('Admin.CTSV.Diem.Diem.index', compact(
            'title',
            'diem',
            'diem_hocky',
            'Hocky',
            'lop',
            'lop_ten',
        ));
    }

    public function importDiem(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        Excel::import(new ImportDanhSachDiem, $path);
        session()->put('message', 'Import file excel thành công');
        return redirect()->back();
    }

    public function filterDiem(Request $request)
    {
        $title = "Lọc danh sách";
        $diem_hocky = Diem::select('diem_hocky')
            ->groupBy('diem_hocky')
            ->orderBy('diem_hocky', 'desc')
            ->get();
        $lop = Lop::orderBy('lop_id', 'asc')->get();
        $lop_ten = $request->input('lop');
        $Hocky = $request->diem_hocky;
       
        $diem = Diem::orderBy('diem_id', 'desc')
                ->where('diem_hocky', "=", $Hocky)
                ->where('diem_lop', '=', $lop_ten)
                ->paginate(10);
    
        return view('Admin.CTSV.Diem.Diem.filter', compact(
            'title', 'diem', 'diem_hocky', 'Hocky', 'lop', 'lop_ten'
        ));
    }

    //TODO: ---------------------Cán bộ khoa--------------------
    public function listDiemCBK(Request $request)
    {
        $title = 'Danh sách điểm';
        $khoa_id = Auth::user()->khoa_id;
        $khoa = Khoa::orderBy('khoa_id', 'asc')
            ->where('khoa_id', '=', $khoa_id)
            ->first();
        $khoa_ten = $khoa->khoa_ten;

        $nganh = Nganh::orderBy('nganh_id', 'asc')
            ->join('khoa', 'khoa.khoa_id', '=', 'nganh.khoa_id')
            ->where('nganh.khoa_id', '=', $khoa_id)
            ->get();
        $nganh_sv = $request->input('nganh');

        $diem_hocky = Diem::select('diem_hocky')
            ->groupBy('diem_hocky')
            ->orderBy('diem_hocky', 'desc')
            ->get();

        $Hocky = $request->diem_hocky;
        $Soluong = $request->get('soluong');
        $diem = Diem::orderBy('diem_id', 'asc')
            ->where('diem_khoa', '=', $khoa_ten)
            ->paginate(5);
        return view('Admin.CanBoKhoa.Diem.index', compact(
            'title',
            'diem',
            'nganh',
            'diem_hocky',
            'Hocky',
            'Soluong',
            'nganh_sv'
        ));
    }

    public function filterDiemCBK(Request $request)
    {
        $title = 'Lọc';
        $khoa_id = Auth::user()->khoa_id;
        $khoa = Khoa::orderBy('khoa_id', 'asc')->where('khoa_id', '=', $khoa_id)->first();
        $khoa_ten = $khoa->khoa_ten;
        $nganh = Nganh::orderBy('nganh_id', 'asc')
            ->join('khoa', 'khoa.khoa_id', '=', 'nganh.khoa_id')
            ->where('nganh.khoa_id', '=', $khoa_id)
            ->get();
        $nganh_sv = $request->input('nganh');


        $diem_hocky = Diem::select('diem_hocky')
            ->groupBy('diem_hocky')
            ->orderBy('diem_hocky', 'desc')
            ->get();
        $Hocky = $request->diem_hocky;
        $Soluong = $request->get('soluong');
        $diem = Diem::orderBy('diem_thang4', 'desc')
            ->where('diem_khoa', '=', $khoa_ten)
            ->where('diem_renluyen', '>=', 65)
            ->where('diem_thang4', '>=', 2.5)
            ->where('diem_nganh', '=', $nganh_sv)
            ->limit($Soluong)->get();
        return view('Admin.CanBoKhoa.Diem.filter', compact(
            'title',
            'diem',
            'nganh',
            'diem_hocky',
            'Hocky',
            'Soluong',
            'nganh_sv'
        ));
    }
}
