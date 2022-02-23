<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\KhoaRequest;
use App\Models\Khoa;

class KhoaController extends Controller
{
    //TODO: 1. Chuyển sang trang danh sách khoa
    public function list() {
        if(Gate::allows('ctsv')) {
            $title = 'Danh sách Khoa';
            $khoa = Khoa::orderBy('khoa_id','asc')->paginate(5);
            return view('Admin.CTSV.Khoa.list',compact('title','khoa'));
        }
        return redirect()->back();
    }

    //TODO: 2. Chuyển sang trang thêm Khoa
    public function add() {
        if(Gate::allows('ctsv')) {
            $title = 'Thêm khoa';
            return view('Admin.CTSV.Khoa.add',compact('title'));
        }
        return redirect()->back();
    }

    //TODO: 3. Thêm khoa
    public function insert(KhoaRequest $request) {
        $data = $request->all();
        $khoa= new Khoa();
        $khoa->khoa_ten = $data['khoa_ten'];
        if (Khoa::where('khoa_ten', '=', $data['khoa_ten'])->count() > 0) {
            session()->put('message', 'Tên khoa này đã tồn tại');
            return redirect()->back();
        }
        $khoa->save();
        session()->put('message', 'Thêm khoa thành công');
        return redirect()->route('show_khoa');
    }

    //TODO: 4. Chuyển sang trang cập nhật Khoa
    public function edit($khoa_id) {
        if(Gate::allows('ctsv')) {
            $title = 'Cập nhật khoa';
            $khoa = Khoa::find($khoa_id);
            if($khoa) {
                return view('Admin.CTSV.Khoa.edit',compact('title','khoa'));
            }
        }
        return redirect()->back();
    } 

    //TODO: 5. Cập nhật Khoa
    public function update(Request $request, $khoa_id) {
        $data = $request->all();
        Khoa::find($khoa_id)->update($data);
        session()->put('message','Cập nhật khoa thành công');
        return redirect()->route('show_khoa');
    }

    //TODO: 6. Xóa khoa
    public function delete($khoa_id) {
        $khoa = Khoa::find($khoa_id);
        if($khoa) $khoa->delete();
        session()->put('message', 'Xóa khoa thành công');
        return redirect()->route('show_khoa');
    }

     //TODO: 7. Tìm kiếm khoa
     public function search(Request $request) {
        $title = 'Kết quả tìm kiếm';
        $search = $request->get('search');
        $khoa = Khoa::orderBy('khoa_id', 'asc')
        ->where('khoa_ten', 'like', '%'.$search.'%')->paginate(20);
        return view('Admin.CTSV.Khoa.list', compact('title','khoa'));
    }
}
