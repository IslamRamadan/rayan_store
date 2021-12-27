<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\SizeGuide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class SizeGuideController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SizeGuide::latest()->get();
            return DataTables::of($data)
                ->addColumn('image', function ($artist) {
                    $url = asset('/storage/' . $artist->image_url);
                    return $url;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $action = '
<a class="btn btn-success "  href="' . route('size_guides.edit', $row->id) . '" id="edit-user" >'.\Lang::get('site.edit').' </a>
<meta name="csrf-token" content="{{ csrf_token() }}">
';
$action.=' <a href="' . url('size_guides/destroy', $row->id) . '" class="btn btn-danger test-form">'.\Lang::get('site.delete').'</a>';


                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.size_guides.index');
    }
    public function create()
    {
        return view('dashboard.size_guides.create');
    }

    public function store(Request $request)
    {


        $messeges = [

            'name_ar.required' => "اسم الدليل باللغه العربيه مطلوب",
            'name_en.required' => "اسم الدليل باللغه الانجليزيه مطلوب",
            'image_url.required' => "صورة دليل المقاسات مطلوبه",

            'image_url.mimes'=>" يجب ان تكون الصورة jpg او jpeg او png  ",
            'image_url.max'=>" الحد الاقصي للصورة 4 ميجا ",

        ];

        $validator = Validator::make($request->all(), [

            'name_ar' => ['required'],
            'name_en' => ['required'],
            'image_url' =>  'required|mimes:jpg,jpeg,png|max:4100',

        ], $messeges);


        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }

        $cat = null;

        if ($request->hasfile('image_url')) {
            // $images .= 'yes';

            $image = $request->file('image_url');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = 'uploads/size_guides/images/';

            if (!Storage::exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
//
//            if(file_exists(storage_path('app/public/'.$path.$file_name)))
//            {
//                unlink(storage_path('app/public/'.$path.$file_name));
//            }


            $cat = SizeGuide::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'image_url' => $image->storeAs($path, $file_name, 'public')
            ]);

        } else {
            Alert::error('خطأ', 'برجاء اختيار صورة الدليل');
            return back();
        }

        if ($cat) {

            session()->flash('success', "success");
            if (session()->has("success")) {
                Alert::success('نجح', 'تمت إضافة دليل المقاسات');
            }

        }

        return redirect()->route('size_guides.index');
    }

    public function updateSizeGuide(Request $request , $id)
    {


        $messeges = [

            'name_ar.required' => "اسم الدليل باللغه العربيه مطلوب",
            'name_en.required' => "اسم الدليل باللغه الانجليزيه مطلوب",
            'image_url.mimes'=>" يجب ان تكون الصورة jpg او jpeg او png  ",
            'image_url.max'=>" الحد الاقصي للصورة 4 ميجا ",
//            'image_url.required'=>"صورة القسم مطلوب",

        ];

        $validator = Validator::make($request->all(), [

            'name_ar' => ['required'],
            'name_en' => ['required'],
//            'image_url' => ['required'],
            'image_url' =>  'mimes:jpg,jpeg,png|max:4100',


        ], $messeges);


        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }

        $cat = SizeGuide::findOrFail($id);


        if ($request->hasfile('image_url')) {
            // $images .= 'yes';

            $image = $request->file('image_url');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = 'uploads/size_guides/images/';

            if (!Storage::exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }

//            return (storage_path('app/public/'.$cat->image_url));

            if(file_exists(storage_path('app/public/'.$cat->image_url)))
            {
                unlink(storage_path('app/public/'.$cat->image_url));
            }


            $cat = $cat->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'image_url' => $image->storeAs($path, $file_name, 'public')
            ]);

        } else {

            $cat = $cat->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
//                'image_url' => $image->storeAs($path, $file_name, 'public')
            ]);
        }

        if ($cat) {

            session()->flash('success', "success");
            if (session()->has("success")) {
                Alert::success('نجح', 'تم تعديل الدليل');
            }

        }

        return redirect()->route('size_guides.index');


//        $uId = $request->user_id;
//        User::updateOrCreate(['id' => $uId],['name' => $request->name, 'email' => $request->email]);
//        if(empty($request->user_id))
//            $msg = 'User created successfully.';
//        else
//            $msg = 'User data is updated successfully';
//        return redirect()->route('users.index')->with('success',$msg);


    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $cat = SizeGuide::where($where)->first();
        if(!$cat){
            Alert::error('خطأ', 'دليل المقاسات غير موجود بالنظام');
            return back();
        }

        return view('dashboard.size_guides.edit' , compact('cat'));

    }

    public function destroy($id)
    {

        $cat = SizeGuide::findOrFail($id);


        if($cat){

            if(file_exists(storage_path('app/public/'.$cat->image_url)))
            {
                unlink(storage_path('app/public/'.$cat->image_url));
            }


            $cat->delete();


            session()->flash('success', "success");
            if (session()->has("success")) {
                Alert::success('نجح', 'تم حذف دليل المقاسات');
            }
        }
        return redirect()->route('size_guides.index');

    }



}
