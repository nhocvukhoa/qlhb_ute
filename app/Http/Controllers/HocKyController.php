<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\HocKyRequest;
use App\Models\HocKy;
use App\Models\NamHoc;

class HocKyController extends Controller
{
    //TODO: 1. Chuyển sang trang danh sách tiêu chí
    public function list()
    {
        if (Gate::allows('ctsv')) {
            $title = 'Danh sách học kỳ';
            $namhoc = NamHoc::orderBy('namhoc_id', 'asc')->get();
            $hocky = HocKy::orderBy('hocky_id', 'asc')
            ->join('namhoc', 'namhoc.namhoc_id', '=', 'hocky.namhoc_id')
            ->paginate(5);
            return view('Admin.CTSV.HocKy.list', compact('title', 'hocky', 'namhoc'));
        }
        return redirect()->back();
    }


    //TODO: 2. Chuyển sang trang thêm học kỳ
    public function add()
    {
        if (Gate::allows('ctsv')) {
            $title = 'Thêm học kỳ';
            $namhoc = NamHoc::orderBy('namhoc_id', 'asc')->get();
            $hocky = HocKy::orderBy('hocky_id', 'asc')
            ->join('namhoc', 'namhoc.namhoc_id', '=', 'hocky.namhoc_id')
            ->get();
            return view('Admin.CTSV.HocKy.add', compact('title', 'namhoc', 'hocky'));
        }
        return redirect()->back();
    }

    //TODO: 3. Thực hiện thêm học kỳ
    public function insert(HocKyRequest $request)
    {
        $data = array();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $data['hocky_ten'] = $request->hocky_ten;
        $data['namhoc_id'] = $request->namhoc_id;
        $data['hocky_thoigianbatdau'] = $request->hocky_thoigianbatdau;
        $data['hocky_thoigianketthuc'] = $request->hocky_thoigianketthuc;
        if (HocKy::where('hocky_ten', '=', $data['hocky_ten'])->count() > 0) {
            session()->put('message', 'Tên học kỳ này đã tồn tại');
            return redirect()->back();
        }
        HocKy::insert($data);
        session()->put('message', 'Thêm học kỳ thành công');
        return redirect()->route('show_hocky');
    }

    //TODO: 4. Chuyển sang trang cập nhật học kỳ
    public function edit($hocky_id)
    {
        if (Gate::allows('ctsv')) {
            $title = 'Cập nhật học kỳ';
            $namhoc = NamHoc::orderBy('namhoc_id', 'asc')->get();
            $hocky = HocKy::where('hocky_id', $hocky_id)
            ->join('namhoc', 'namhoc.namhoc_id', '=', 'hocky.namhoc_id')
            ->first();
            if ($hocky) {
                return view('Admin.CTSV.HocKy.edit', compact('title', 'hocky', 'namhoc'));
            }
        }
        return redirect()->back();
    }

    //TODO: 5. Thực hiện cập nhật học kỳ
    public function update(Request $request, $hocky_id)
    {
        $data = $request->all();
        HocKy::find($hocky_id)->update($data);
        session()->put('message', 'Cập nhật học kỳ thành công');
        return redirect()->route('show_hocky');
    }

    //TODO: 6. Thực hiện xóa học kỳ
    public function delete($hocky_id) {
        if(Gate::allows('ctsv')) {
            $hocky = HocKy::find($hocky_id);
            $hocky->delete();
            session()->put('message', 'Xóa học kỳ thành công');
            return redirect()->route('show_hocky');
        }
        return redirect()->back();
    }

    //TODO: 7. Tìm kiếm lớp
    public function search(Request $request) {
        $title = 'Kết quả tìm kiếm';
        $search = $request->get('search');
        $hocky= HocKy::orderBy('hocky_id', 'asc')
        ->join('namhoc', 'namhoc.namhoc_id', '=', 'hocky.namhoc_id')
        ->where('hocky_ten', 'like', '%'.$search.'%')
        ->paginate(20);
        return view('Admin.CTSV.HocKy.list', compact('title','hocky'));
    }


}
