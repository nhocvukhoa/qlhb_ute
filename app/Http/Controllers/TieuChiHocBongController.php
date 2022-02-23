<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\TieuChi;
use App\Models\HocBong;
use App\Models\TieuChiHocBong;

class TieuChiHocBongController extends Controller
{
    public function list() {
        if(Gate::allows('ctsv')) {
            $title = 'Danh sách tiêu chí học bổng';
            $hocbong = HocBong::orderBy('hocbong_id', 'desc')->get();
            $tieuchi = TieuChi::orderBy('tieuchi_id', 'desc')->get();
            $tieuchihocbong = TieuChiHocBong::orderBy('id','desc')
                              ->join('hocbong', 'hocbong.hocbong_id', '=', 'tieuchihocbong.hocbong_id')
                              ->join('tieuchi', 'tieuchi.tieuchi_id', '=', 'tieuchihocbong.tieuchi_id')
                              ->paginate(5);
            return view('Admin.CTSV.TieuChiHocBong.list',compact('title','tieuchihocbong', 'hocbong', 'tieuchi'));
        }
        return redirect()->back();
    }

    public function add() {
        if(Gate::allows('ctsv')) {
            $title = 'Thêm tiêu chí học bổng';
            $hocbong = HocBong::orderBy('hocbong_id', 'desc')->get();
            $tieuchi = TieuChi::orderBy('tieuchi_id', 'desc')->get();
            $tieuchihocbong = TieuChiHocBong::orderBy('id','desc')
                              ->join('hocbong', 'hocbong.hocbong_id', '=', 'tieuchihocbong.hocbong_id')
                              ->join('tieuchi', 'tieuchi.tieuchi_id', '=', 'tieuchihocbong.tieuchi_id')
                              ->get();
            return view('Admin.CTSV.TieuChiHocBong.add', compact('title','tieuchihocbong', 'hocbong', 'tieuchi'));
        }
        return redirect()->back();
    }

    public function insert(Request $request) {
        $data = $request->all();
        $tieuchihocbong = new TieuChiHocBong();
        $tieuchihocbong->tieuchi_id = $data['tieuchi_id'];
        $tieuchihocbong->hocbong_id = $data['hocbong_id'];
        $tieuchihocbong->save();
        session()->put('message', 'Thêm tiêu chí học bổng thành công');
        return redirect()->route('show_tieuchihocbong');
    }

    public function edit($id) {
        $title = "Cập nhật tiêu chí học bổng";
        $hocbong = HocBong::orderBy('hocbong_id', 'desc')->get();
        $tieuchi = TieuChi::orderBy('tieuchi_id', 'desc')->get();
        $tieuchihocbong = TieuChiHocBong::where('id', $id)
        ->join('hocbong', 'hocbong.hocbong_id', '=', 'tieuchihocbong.hocbong_id')
        ->join('tieuchi', 'tieuchi.tieuchi_id', '=', 'tieuchihocbong.tieuchi_id')
        ->first();
        return view('Admin.CTSV.TieuChiHocBong.edit', compact('title','tieuchihocbong', 'hocbong', 'tieuchi'));
    }

    public function update(Request $request, $id) {
        $data = $request->all();
        $tieuchihocbong = TieuChiHocBong::find($id);
		$tieuchihocbong->tieuchi_id = $data['tieuchi_id'];
		$tieuchihocbong->hocbong_id = $data['hocbong_id'];
		$tieuchihocbong->update($data);
        session()->put('message','Cập nhật tiêu chí học bổng thành công');
        return redirect()->route('show_tieuchihocbong');
    }

    public function delete($id) {
        if(Gate::allows('ctsv')) {
            $tieuchihocbong = TieuChiHocBong::find($id);
            $tieuchihocbong->delete();
            session()->put('message', 'Xóa tiêu chí học bổng thành công');
            return redirect()->route('show_tieuchihocbong');
        }
        return redirect()->back();
    }
}
