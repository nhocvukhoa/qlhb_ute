<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ThongBaoRequest;
use App\Models\ThongBao;
use App\Models\User;

class ThongBaoController extends Controller
{
    //TODO: 1. Chuyển sang trang quản lý thông báo
    public function list() {
        if(Gate::allows('ctsv')) {
            $title = 'Quản lý thông báo';
            $thongbao = ThongBao::orderBy('thongbao_id', 'desc')
            ->join('users', 'users.id', '=', 'thongbao.user_id')
            ->paginate(5);
            return view('Admin.CTSV.ThongBao.list', compact('title', 'thongbao'));
        }
        return redirect()->back();
    }

    //TODO: 2. Chuyển sang trang thêm thông báo
    public function add() {
        if(Gate::allows('ctsv')) {
            $title = 'Thêm thông báo';
            return view('Admin.CTSV.ThongBao.add', compact('title'));
        }
        return redirect()->back();
    }

    //TODO: 3. Thực hiện thêm thông báo
    public function insert(ThongBaoRequest $request) {
        $data = array();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $data['thongbao_ten'] = $request->thongbao_ten;
        $data['thongbao_mota'] = $request->thongbao_mota;
        $data['thongbao_noidung'] = $request->thongbao_noidung;
        $data['thongbao_file'] = $request->document;
        $data['thongbao_thoigiandang'] = now();
        $data['user_id'] = $request->user_id;

        $path_document = 'public/Upload/HoSo/';
        $get_document = $request->file('document');
        if($get_document) {
            $get_name_document =  $get_document->getClientOriginalName();
            $name_document = current(explode('.', $get_name_document));
            $new_document = $name_document.rand(0,99).'.'.$get_document->getClientOriginalExtension();
            $get_document->move($path_document, $new_document);
            $data['thongbao_file'] = $new_document;
            if(ThongBao::where('thongbao_ten', '=', $data['thongbao_ten'])->count() >0){
                session()->put('message','Tên thông báo này đã tồn tại');
                return redirect()->back();
            }
            ThongBao::insert($data);
            session()->put('message','Thêm thông báo thành công');
            return redirect()->route('show_thongbao');
        }
        $data['thongbao_file'] = '';
        
        if(ThongBao::where('thongbao_ten', '=', $data['thongbao_ten'])->count() >0){
            session()->put('message','Tên thông báo này đã tồn tại');
            return redirect()->back();
        }
        ThongBao::insert($data);
        session()->put('message','Thêm thông báo thành công');
        return redirect()->route('show_thongbao');
    }

    //TODO: 4. Chuyển sang trang cập nhật thông báo
    public function edit($thongbao_id) {
        if(Gate::allows('ctsv')) {
            $title = 'Cập nhật thông báo';
            $thongbao = ThongBao::find($thongbao_id);
            if($thongbao) {
                return view('Admin.CTSV.ThongBao.edit',compact('title','thongbao'));
            }
        }
        return redirect()->back();
    }

    //TODO: 5. Thực hiện cập nhật thông báo
    public function update(Request $request, $thongbao_id) {
        $data = array();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $data['thongbao_ten'] = $request->thongbao_ten;
        $data['thongbao_mota'] = $request->thongbao_mota;
        $data['thongbao_noidung'] = $request->thongbao_noidung;
        $data['thongbao_file'] = $request->document;
        $data['thongbao_thoigiancapnhat'] = now();
       
        $path_document = 'public/Upload/HoSo/';
        $get_document = $request->file('document');
        if($get_document) {
            $get_name_document =  $get_document->getClientOriginalName();
            $name_document = current(explode('.', $get_name_document));
            $new_document = $name_document.rand(0,99).'.'.$get_document->getClientOriginalExtension();
            $get_document->move($path_document, $new_document);
            $data['thongbao_file'] = $new_document;
            ThongBao::where('thongbao_id', $thongbao_id)->update($data);
            session()->put('message','Cập nhật thông báo thành công');
            return redirect()->route('show_thongbao');
        }
        ThongBao::where('thongbao_id', $thongbao_id)->update($data);
        session()->put('message','Cập nhật thông báo thành công');
        return redirect()->route('show_thongbao');
    }

    //TODO: 6. Thực hiện xóa thông báo
    public function delete($thongbao_id) {
        if(Gate::allows('ctsv')) {
            $thongbao = ThongBao::find($thongbao_id);
            $thongbao->delete();
            session()->put('message', 'Xóa thông báo thành công');
            return redirect()->route('show_thongbao');
        }
        return redirect()->back();
    }

}
