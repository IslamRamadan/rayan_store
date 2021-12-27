<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Slider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;


class sliderController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data =  Slider::latest()->get();
            return Datatables::of($data)
                ->addColumn('image', function ($artist) {
                    $url = asset( '/storage/'. $artist->img);
                    return $url;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action = '
                        <a class="btn btn-success"  href="'.route('sliders.edit' , $row->id).'" >'.\Lang::get('site.edit').' </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <a  href="'.route('sliders.destroy' , $row->id).'" class="btn btn-danger">'.\Lang::get('site.delete').'</a>

                        ';
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.sliders.index');
    }

    public function create()
    {
        return view('dashboard/sliders/create');
    }

    public function store(Request $request)
    {
//        dd($request->all());

        $messeges = [


            'photo.required'=>"صورة البانر مطلوبة",
            'photo.mimes'=>" يجب ان تكون الصورة jpg او jpeg او png  ",
            'photo.max'=>" الحد الاقصي للصورة 4 ميجا ",
            "name_en.required"=>"اسم البانر بالانجليزيه مطلوب",
            "name_ar.required"=>"اسم البانر بالعربيه مطلوب",
            "description_en.required"=>"وصف البانر بالانجليزيه مطلوب",
            "description_ar.required"=>"وصف البانر بالعربيه مطلوب",


        ];


        $validator =  Validator::make($request->all(), [

            'photo'=>'required|mimes:jpg,jpeg,png|max:4100',
            "name_en"=>  " required",
            "name_ar"=>  " required",
            "description_ar"=>  " required",
            "description_en"=>  " required",

        ], $messeges);



        if ($validator->fails()) {
            Alert::error('error', $validator->errors()->first());
            return back();
        }

//        $img =  $request->photo ;
//        //add new name for img
//        $new_name_img = time().uniqid().".".$img->getClientOriginalExtension();
//
//        //move img to folder
//        $move = $img->move(public_path("upload/sliders"), $new_name_img);
//
//
//        $new = "upload/sliders/".$new_name_img ;
//        $request->merge(['img' => $new]);

        $category = null;
        if ($request->hasfile('photo')) {
            // $images .= 'yes';

            $image = $request->file('photo');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = 'uploads/sliders/images/';

            if (!Storage::exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
            $img = \Image::make($image);
            $img->save(public_path('storage/'.$path.$file_name),30);
//
//            if(file_exists(storage_path('app/public/'.$path.$file_name)))
//            {
//                unlink(storage_path('app/public/'.$path.$file_name));
//            }


            $category= Slider::create(
                [
                    'description_ar' => $request['description_ar'],
                    'description_en' => $request['description_en'],
                    'name_ar' => $request['name_ar'],
                    'name_en' => $request['name_en'],
                    'img' => $path.$file_name
                ]
            );

        } else {
            Alert::error('خطأ', 'برجاء اختيار صورة ');
            return back();
        }


        if ($category) {

            session()->flash('success', "success");
            if (session()->has("success")) {
                Alert::success('نجح', 'تمت إضافة بانر ');
            }

        }

        return redirect()->route('sliders.index');


    }

    public function edit($id)
    {
        $category=Slider::findOrFail($id);
        return view('/dashboard/sliders/edit',["category"=>$category]);
    }

    public function updateSlider(Request $request, $id)
    {
//        dd("ok");


        $messeges = [


            'photo.required'=>"صورة البانر مطلوبة",
            'photo.mimes'=>" يجب ان تكون الصورة jpg او jpeg او png  ",
            'photo.max'=>" الحد الاقصي للصورة 4 ميجا ",
            "name_en.required"=>"اسم البانر بالانجليزيه مطلوب",
            "name_ar.required"=>"اسم البانر بالعربيه مطلوب",
            "description_en.required"=>"وصف البانر بالانجليزيه مطلوب",
            "description_ar.required"=>"وصف البانر بالعربيه مطلوب",


        ];


        $validator =  Validator::make($request->all(), [

            'photo'=>'mimes:jpg,jpeg,png|max:4100',
            "name_en"=>  " required",
            "name_ar"=>  " required",
            "description_ar"=>  " required",
            "description_en"=>  " required",

        ], $messeges);

        if ($validator->fails()) {
            Alert::error('error', $validator->errors()->first());
            return back();
        }

        $cat = Slider::findOrFail($id);


        if ($request->hasfile('photo')) {
            // $images .= 'yes';

            $image = $request->file('photo');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = 'uploads/sliders/images/';

            if (!Storage::exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }

//            return (storage_path('app/public/'.$cat->image_url));

            if(file_exists(storage_path('app/public/'.$cat->img)))
            {
                unlink(storage_path('app/public/'.$cat->img));
            }
            $img = \Image::make($image);
            $img->save(public_path('storage/'.$path.$file_name),30);


            $cat = $cat->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_ar'],
                'img' => $path.$file_name
            ]);

        } else {


            $cat = $cat->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'description_ar' => $request['description_ar'],
                'description_en' => $request['description_ar'],
//                'img' => $image->storeAs($path, $file_name, 'public')
            ]);
        }


        if ($cat) {

            session()->flash('success', "success");
            if (session()->has("success")) {
                Alert::success('نجح', 'تم تعديل البانر');
            }

        }
            return redirect()->route('sliders.index');

    }


    public function destroy( $id)
    {

        $category= Slider::findOrFail($id);


        if($category){

            if(file_exists(storage_path('app/public/'.$category->img)))
            {
                unlink(storage_path('app/public/'.$category->img));
            }

            $category->delete();
            session()->flash('success', "success");
            if (session()->has("success")) {
                Alert::success('نجح', 'تم حذف البانر');
            }
        }


        return redirect()->route('sliders.index');

    }
    public function show( $id)
    {


        $category= Slider::findOrFail($id);


        if($category){

            if(file_exists(storage_path('app/public/'.$category->img)))
            {
                unlink(storage_path('app/public/'.$category->img));
            }

            $category->delete();
            session()->flash('success', "success");
            if (session()->has("success")) {
                Alert::success('نجح', 'تم حذف البانر');
            }
        }


        return redirect()->route('sliders.index');

    }

}
