<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\CateringImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CateringGalaryController extends Controller
{
    public function index(Request $request,$id)
    {
        $posts = CateringImage::where("catering_id",$id)->get();
        return view("/dashboard/catering_galary/index",["posts"=>  $posts,"id"=>$id ]);
    }

    public function store(Request $request,$id)
    {
        if (!$request->hasfile('img')){
            Alert::success('error ', 'لم تقم بتحميل اي صورة');
            return back();
        }

        $imgs = $request->image ;
        if(count($imgs) >10 ){
            Alert::success('error ', 'الحد الاقصي للتحميل في المرة الواحدة 10 صور');
            return back();
        }

        $messeges = [
            'img.required'=>" الصورة مطلوبة",
            'img.mimes'=>" يجب ان تكون الصورة jpg او jpeg او png ",
            'img.max'=>" الحد الاقصي للصورة 4 ميجا ",
        ];

        $validator =  Validator::make($request->all(), [
            'img.*' => 'mimes:jpg,jpeg,png|max:4100',
            "img"=>"required"
        ], $messeges);

        if ($validator->fails()) {
            Alert::error('error', $validator->errors()->first());
            return back();
        }

        $error = 0 ;
        foreach($imgs as $img){
            $new_name_img = time().uniqid().".".$img->getClientOriginalExtension();
            $img1 = \Image::make($img)->resize(255 , 200);
            $img1->save(public_path('upload/advertising/'.$new_name_img),80);
            $post= CateringImage::create([
                "image"=>  "upload/advertising/".$new_name_img ,
                "catering_id"=>$id
            ]);

            if(!$post){
                $error++ ;
            }
        }

        if ($error == 0){
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('Success Title', 'Success Message');
            }
            return redirect()->route('catering_galaries.index',$id);
        }else{
            session()->flash('error', "بعض الصور او جميعها لم يتم تحميلها");
            if(session()->has("error")){
                Alert::success('error Title', 'error Message');
            }
            return back();
        }
    }

    public function destroy( $id)
    {
        $post= CateringImage::findOrFail($id);
        if(file_exists(public_path( $post->image))){
            unlink(public_path($post->image));
        }
        $post->delete();
        session()->flash('success', "success");
        if(session()->has("success")){
            Alert::success('Success Title', 'Success Message');
        }
        return redirect()->route('catering_galaries.index',$post->catering_id);
    }
}
