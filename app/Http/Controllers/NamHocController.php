<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\NamHocRequest;
use App\Models\NamHoc;

class NamHocController extends Controller
{
     //TODO: 1. Chuyển sang trang danh sách tiêu chí
     public function list()
     {
         if (Gate::allows('ctsv')) {
             $title = 'Danh sách năm học';
             $namhoc = NamHoc::orderBy('namhoc_id', 'asc')->paginate(5);
             return view('Admin.CTSV.NamHoc.list', compact('title', 'namhoc'));
         }
         return redirect()->back();
     }

    //TODO: 2. Chuyển sang trang thêm năm học
    public function add()
    {
        if (Gate::allows('ctsv')) {
            $title = 'Thêm năm học';
            return view('Admin.CTSV.NamHoc.add', compact('title'));
        }
        return redirect()->back();
    }

     //TODO: 3. Thực hiện thêm năm học
     public function insert(NamHocRequest $request)
     {
         $data = array();
         date_default_timezone_set('Asia/Ho_Chi_Minh');
         $data['namhoc_ten'] = $request->namhoc_ten;
         $data['namhoc_thoigianbatdau'] = $request->namhoc_thoigianbatdau;
         $data['namhoc_thoigianketthuc'] = $request->namhoc_thoigianketthuc;
         if (NamHoc::where('namhoc_ten', '=', $data['namhoc_ten'])->count() > 0) {
             session()->put('message', 'Tên năm học này đã tồn tại');
             return redirect()->back();
         }
         NamHoc::insert($data);
         session()->put('message', 'Thêm năm học thành công');
         return redirect()->route('show_namhoc');
     }

     //TODO: 4. Chuyển sang trang cập nhật năm học
    public function edit($namhoc_id)
    {
        if (Gate::allows('ctsv')) {
            $title = 'Cập nhật năm học';
            $namhoc = NamHoc::find($namhoc_id);
            if ($namhoc) {
                return view('Admin.CTSV.NamHoc.edit', compact('title', 'namhoc'));
            }
        }
        return redirect()->back();
    }

    //TODO: 5. Thực hiện cập nhật năm học
    public function update(Request $request, $namhoc_id)
    {
        $data = $request->all();
        NamHoc::find($namhoc_id)->update($data);
        session()->put('message', 'Cập nhật năm học thành công');
        return redirect()->route('show_namhoc');
    }

    //TODO: 6. Thực hiện xóa học kỳ
    public function delete($namhoc_id) {
        if(Gate::allows('ctsv')) {
            $namhoc = NamHoc::find($namhoc_id);
            $namhoc->delete();
            session()->put('message', 'Xóa năm học thành công');
            return redirect()->route('show_namhoc');
        }
        return redirect()->back();
    }

    //TODO: 7. Tìm kiếm năm học
    public function search(Request $request) {
        $title = 'Kết quả tìm kiếm';
        $search = $request->get('search');
        $namhoc= NamHoc::orderBy('namhoc_id', 'asc')
        ->where('namhoc_ten', 'like', '%'.$search.'%')
        ->paginate(20);
        return view('Admin.CTSV.NamHoc.list', compact('title','namhoc'));
    }
 

}
