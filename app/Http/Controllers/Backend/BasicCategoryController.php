<?php

namespace App\Http\Controllers\Backend;

use App\BasicCategory;
use App\Category;
use App\Product;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BasicCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BasicCategory::latest()->get();
            return Datatables::of($data)
                ->addColumn('image', function ($artist) {
                    $url = asset('/storage/' . $artist->image_url);
                    return $url;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $action = '
<a class="btn btn-success "  href="' . route('basic_categories.edit', $row->id) . '" id="edit-user" >'.\Lang::get('site.edit').' </a>
<meta name="csrf-token" content="{{ csrf_token() }}">
';
$action.=' <a href="' . url('basic_categories/destroy', $row->id) . '" class="btn btn-danger test-form">'.\Lang::get('site.delete').'</a>';


                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.basic_categories.index');
    }

    public function create()
    {
        return view('dashboard.basic_categories.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());


        $messeges = [

            'name_ar.required' => "اسم القسم باللغه العربيه مطلوب",
            'name_en.required' => "اسم القسم باللغه الانجليزيه مطلوب",
            'image_url.required' => "صورة القسم مطلوب",

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
            return back()->withInput();;
        }

        $cat = null;

        if ($request->hasfile('image_url')) {
            // $images .= 'yes';

            $image = $request->file('image_url');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = 'uploads/basic_categories/images/';


            if (!Storage::exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
            // dd(storage_path($path.$file_name));
            // dd(public_path('storage/'.$path.$file_name));
            // dd($path.$file_name);
            $img = \Image::make($image)->resize(255,200);
            $img->save(public_path('storage/'.$path.$file_name),60);
            // dd(public_path('storage/'.$path.$file_name));

            // $image->storeAs($path, $file_name, 'public');

//
//            if(file_exists(storage_path('app/public/'.$path.$file_name)))
//            {
//                unlink(storage_path('app/public/'.$path.$file_name));
//            }


            $cat = BasicCategory::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'type' => $request['type']?:0,
                'image_url' => $path.$file_name
            ]);

        } else {
            Alert::error('خطأ', 'برجاء اختيار صورة القسم');
            return back()->withInput();;
        }

        if ($cat) {

            session()->flash('success', "success");
            if (session()->has("success")) {
                Alert::success('نجح', 'تمت إضافة قسم رئيسي');
            }

        }

        return redirect()->route('basic_categories.index');

//        $uId = $request->user_id;
//        User::updateOrCreate(['id' => $uId],['name' => $request->name, 'email' => $request->email]);
//        if(empty($request->user_id))
//            $msg = 'User created successfully.';
//        else
//            $msg = 'User data is updated successfully';
//        return redirect()->route('users.index')->with('success',$msg);
    }


    public function updateBasicCategory(Request $request , $id)
    {


        $messeges = [

            'name_ar.required' => "اسم القسم باللغه العربيه مطلوب",
            'name_en.required' => "اسم القسم باللغه الانجليزيه مطلوب",
//            'image_url.required'=>"صورة القسم مطلوب",

        ];

        $validator = Validator::make($request->all(), [

            'name_ar' => ['required'],
            'name_en' => ['required'],
//            'image_url' => ['required'],

        ], $messeges);


        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }

        $cat = BasicCategory::findOrFail($id);


        if ($request->hasfile('image_url')) {
            // $images .= 'yes';

            $image = $request->file('image_url');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = 'uploads/basic_categories/images/';

            if (!Storage::exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }

//            return (storage_path('app/public/'.$cat->image_url));

            if(file_exists(storage_path('app/public/'.$cat->image_url)))
            {
                unlink(storage_path('app/public/'.$cat->image_url));
            }
            $img = \Image::make($image)->resize(255,200);
            $img->save(public_path('storage/'.$path.$file_name),60);


            $cat = $cat->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'type' => $request['type']?:0,
                'image_url' => $path.$file_name
            ]);

        } else {

            $cat = $cat->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'type' => $request['type']?:0,

//                'image_url' => $image->storeAs($path, $file_name, 'public')
            ]);
        }

        if ($cat) {

            session()->flash('success', "success");
            if (session()->has("success")) {
                Alert::success('نجح', 'تم تعديل القسم');
            }

        }

        return redirect()->route('basic_categories.index');


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
        $cat = BasicCategory::where($where)->first();
        if(!$cat){
            Alert::error('خطأ', 'القسم غير موجود بالنظام');
            return back();
        }

        return view('dashboard.basic_categories.edit' , compact('cat'));

    }


    public function show( Request $request,$id){
        return 'show';
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {

        $cat = BasicCategory::findOrFail($id);
        $sub_cat=Category::where('basic_category_id',$id)->get();
        $products=Product::where('basic_category_id',$id)->get();
        // dd($products);
        if($sub_cat){
            foreach($sub_cat as $sub){
                    $sub->delete();
            }
        }
        if($products){
            foreach($products as $prod){
                if(file_exists(storage_path('app/public/'.$prod->img)))
                {
                    unlink(storage_path('app/public/'.$prod->img));
                }
                    $prod->delete();
            }
        }


        if($cat){

            if(file_exists(storage_path('app/public/'.$cat->image_url)))
            {
                unlink(storage_path('app/public/'.$cat->image_url));
            }


            $cat->delete();


            session()->flash('success', "success");
            if (session()->has("success")) {
                Alert::success('نجح', 'تم حذف القسم');
            }
        }
        return redirect()->route('basic_categories.index');

    }
}
