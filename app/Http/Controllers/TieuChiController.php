<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\TieuChi;
use App\Models\HocKy;
use App\Models\HocBong;
use Illuminate\Support\Facades\Gate;

class TieuChiController extends Controller
{
    //TODO: 1. Chuyển sang trang danh sách tiêu chí
    public function list() {
        if(Gate::allows('ctsv')) {
            $title = 'Danh sách tiêu chí';
            $tieuchi = TieuChi::orderBy('tieuchi_id','asc')->paginate(5);
            return view('Admin.CTSV.TieuChi.list',compact('title','tieuchi'));
        }
        return redirect()->back();
    }

    //TODO: 2. Chuyển sang trang thêm tiêu chí
    public function add() {
        if(Gate::allows('ctsv')) {
            $title = 'Thêm tiêu chí';
            return view('Admin.CTSV.TieuChi.add',compact('title'));
        }
        return redirect()->back();
    }

    //TODO: 3. Thực hiện thêm tiêu chí
    public function insert(Request $request) {
        $request->validate(
            [
                'tieuchi_ten' => 'required|max:255', 
            ],
            [
                'tieuchi_ten.required' => 'Vui lòng nhập tên tiêu chí',
            ]);
    
        $data = $request->all();
        $tieuchi= new TieuChi();
        $tieuchi->tieuchi_ten = $data['tieuchi_ten'];
        $tieuchi->save();
        session()->put('message', 'Thêm tiêu chí thành công');
        return redirect()->route('show_tieuchi');
    }

    //TODO: 4. Chuyển sang trang cập nhật tiêu chí
    public function edit($tieuchi_id) {
        if(Gate::allows('ctsv')) {
            $title = 'Cập nhật tiêu chí';
            $tieuchi = TieuChi::find($tieuchi_id);
            if($tieuchi) {
                return view('Admin.CTSV.TieuChi.edit',compact('title','tieuchi'));
            }
        }
        return redirect()->back();
    } 

    //TODO: 5. Thực hiện cập nhật tiêu chí
    public function update(Request $request, $tieuchi_id) {
        $data = $request->all();
        TieuChi::find($tieuchi_id)->update($data);
        session()->put('message','Cập nhật tiêu chí thành công');
        return redirect()->route('show_tieuchi');
    }

    //TODO: 6. Xóa tiêu chí
    public function delete($tieuchi_id) {
        if(Gate::allows('ctsv')) {
            $tieuchi = TieuChi::find($tieuchi_id);
            $tieuchi->delete();
            session()->put('message', 'Xóa tiêu chí thành công');
            return redirect()->route('show_tieuchi');
        }
        return redirect()->back();
    }
}
