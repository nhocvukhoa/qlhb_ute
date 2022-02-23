<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\SlideRequest;
use Illuminate\Support\Facades\DB;

class SlideController extends Controller
{
     //TODO: 1. Chuyển sang trang danh sách slide
     public function list() {
        if(Gate::allows('ctsv')) {
            $title = 'Danh sách slide';
            $slide= Slide::orderBy('slide_id','asc')->get();
            return view('Admin.CTSV.Slide.list',compact('title','slide'));
        }
        return redirect()->back();
    }

    
    //TODO: 2. Chuyển sang trang thêm slide
    public function add() {
        if(Gate::allows('ctsv')) {
            $title = 'Thêm slide';
            return view('Admin.CTSV.Slide.add',compact('title'));
        }
        return redirect()->back();
    }

    //TODO: 3. Thêm slide
    public function insert(SlideRequest $request)
    {
        $data = array();
        $data['slide_ten'] = $request->slide_ten;
        $data['slide_hinhanh'] = $request->slide_hinhanh;
       

        $get_image = $request->file('slide_hinhanh');
        if ($get_image) {
            $get_name_image =  $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move(base_path() . '/public/Upload/Slide', $new_image);
            $data['slide_hinhanh'] = $new_image;
            if (Slide::where('slide_ten', '=', $data['slide_ten'])->count() > 0) {
                session()->put('error', 'Tên slide này đã tồn tại');
                return redirect()->back();
            }
            DB::table('slide')->insert($data);
            session()->put('message', 'Thêm slide thành công');
            return redirect()->route('show_slide');
        }
        $data['slide_hinhanh'] = '';
        // if (Slide::where('slide_ten', '=', $data['slide_ten'])->count() > 0) {
        //     session()->put('error', 'Tên slide này đã tồn tại');
        //     return redirect()->back();
        // }
        DB::table('slide')->insert($data);
        session()->put('message', 'Thêm slide thành công');
        return redirect()->route('show_slide');
    }

    //TODO: 4. Chuyển sang trang Cập nhật slide
    public function edit($slide_id) {
        if(Gate::allows('ctsv')) {
            $title = 'Cập nhật slide';
            $slide = Slide::find($slide_id);
            return view('Admin.CTSV.Slide.edit',compact('title','slide'));
        }
        return redirect()->back();
    }

    //TODO: 5. Cập nhật slide
    public function update($slide_id, Request $request) {
        $data = array();
        $data['slide_ten'] = $request->slide_ten;
      
      
        $get_image = $request->file('slide_hinhanh');
        if($get_image) {
            $get_name_image =  $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move(base_path().'/public/Upload/Slide',$new_image);
            $data['slide_hinhanh'] = $new_image;
            Slide::where('slide_id', $slide_id)->update($data);
            session()->put('message','Cập nhật slide thành công');
            return redirect()->route('show_slide');
        }
        Slide::where('slide_id', $slide_id)->update($data);
        session()->put('message','Cập nhật slide thành công');
        return redirect()->route('show_slide');
    }

    //TODO: 6. Xóa slide
    public function delete($slide_id) {
        if(Gate::allows('ctsv')) {
            $slide = Slide::find($slide_id);
            $slide->delete();
            session()->put('message', 'Xóa slide thành công');
            return redirect()->route('show_slide');
        }
        return redirect()->back();
    }
}
