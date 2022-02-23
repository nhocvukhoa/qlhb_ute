<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ImportDanhSachSVCB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\SinhVienCanBo;
use App\Models\Lop;
use App\Models\User;

class SinhVienCanBoController extends Controller
{
    public function listSinhVienCB(Request $request)
    {
        $title = "Danh sách sinh viên cán bộ";
        $sinhvien_hocky = SinhVienCanBo::select('hocky')
            ->groupBy('hocky')
            ->orderBy('hocky', 'desc')
            ->get();
        $Hocky = $request->sinhvien_hocky;
        $lop = Lop::orderBy('lop_id')->get();
        $lop_sv = $request->input('lop');

        $users = User::orderBy('id', 'asc')->get();
        $sinhvien = SinhVienCanBo::orderBy('id', 'desc')
            ->paginate(5);
        return view('Admin.CTSV.Diem.SinhVienCanBo.index', compact(
            'title',
            'sinhvien',
            'sinhvien_hocky',
            'users',
            'lop',
            'lop_sv',
            'Hocky'
        ));
    }

    public function filterSinhVienCanBo(Request $request)
    {
        $title = "Danh sách sinh viên cán bộ";
        $sinhvien_hocky = SinhVienCanBo::select('hocky')
            ->groupBy('hocky')
            ->orderBy('hocky', 'desc')
            ->get();
        $Hocky = $request->sinhvien_hocky;
        $lop = Lop::orderBy('lop_id')->get();
        $lop_sv = $request->input('lop');

        $users = User::orderBy('id', 'asc')->get();
        $sinhvien = SinhVienCanBo::orderBy('id', 'desc')
            ->where('lop', '=', $lop_sv)
            ->where('hocky', '=', $Hocky)
            ->get();
        return view('Admin.CTSV.Diem.SinhVienCanBo.filter', compact(
            'title',
            'sinhvien',
            'sinhvien_hocky',
            'users',
            'lop',
            'lop_sv',
            'Hocky'
        ));
    }

    public function importSinhVienCanBo(Request $request)
    {
        $path = $request->file('file')->getRealPath();
        Excel::import(new ImportDanhSachSVCB, $path);
        session()->put('message', 'Import file excel thành công');
        return redirect()->back();
    }
}
