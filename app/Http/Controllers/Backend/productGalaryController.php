<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\ProdImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class productGalaryController extends Controller
{
    public function index(Request $request,$id)
    {
        $posts = ProdImg::where("product_id",$id)->get();
        // flash('Welcome Aboard!');



        return view("/dashboard/product_galary/index",["posts"=>  $posts,"id"=>$id ]);
    }

    public function store(Request $request,$id)
    {
//        dd($request->all());

        if (!$request->hasfile('img')){

            Alert::success('error ', 'لم تقم بتحميل اي صورة');
            return back();
        }

        $imgs = $request->img ;

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




            //add new name for img
            $new_name_img = time().uniqid().".".$img->getClientOriginalExtension();

            //move img to folder
            $img1 = \Image::make($img)->resize(640,690);
            $img1->save(public_path('upload/advertising/'.$new_name_img),80);
            // $img->move(public_path("upload/advertising"), $new_name_img);

            $post= ProdImg::create([
                "img"=>  "upload/advertising/".$new_name_img ,
                "product_id"=>$id

            ]);
//            dd($post);

            if(!$post){
                $error++ ;
            }




        }

        if ($error == 0){

            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('Success Title', 'Success Message');
            }

            return redirect()->route('product_galaries.index',$id);

        }else{

            session()->flash('error', "بعض الصور او جميعها لم يتم تحميلها");
            if(session()->has("error")){
                Alert::success('error Title', 'error Message');
            }

        }



    }



    public function destroy( $id)
    {

        $post= ProdImg::findOrFail($id);
        if(file_exists(public_path( $post->img))){
            unlink(public_path($post->img));
        }
        $post->delete();
        // session()->flash('success', __('site.deleted_successfully'));
        session()->flash('success', "success");
        if(session()->has("success")){
            Alert::success('Success Title', 'Success Message');
        }
        return redirect()->route('product_galaries.index',$post->product_id);

    }


}
