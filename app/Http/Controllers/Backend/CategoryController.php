<?php

namespace App\Http\Controllers\Backend;

use App\BasicCategory;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data =  Category::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('basic_category_ar', function ($artist) {
                    return $artist->basicCategory->name_ar;
                })
                ->addColumn('basic_category_en', function ($artist) {
                    return $artist->basicCategory->name_en;
                })
                ->addColumn('action', function ($row) {
                    $action = '
                        <a class="btn btn-success"  href="'.route('categories.edit' , $row->id).'" >'.\Lang::get('site.edit').' </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">

                       <a  href="'.route('categories.destroy' , $row->id).'" class="btn btn-danger">'.\Lang::get('site.delete').'</a>';
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $basic_categories= BasicCategory::all();

        return view('dashboard.categories.create' , compact('basic_categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messeges = [

            'name_ar.required'=>"اسم القسم باللغه العربيه مطلوب",
            'name_en.required'=>"اسم القسم باللغه الانجليزيه مطلوب",
            'basic_category_id.required'=>"يرجي اختيار القسم الرئيسي",

        ];

        $validator =  Validator::make($request->all(), [

            'name_ar' => ['required'],

            'name_en' => ['required'],

            'basic_category_id' => ['required'],
        ], $messeges);



        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back()->withInput();;
        }


        $category = Category::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'basic_category_id' => $request['basic_category_id'],
        ]);

        if ($category){

            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تمت إضافة قسم بنجاح');
            }

        }

        return redirect()->route('categories.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::where('id',$id)->first();


        if($category){
            $category->delete();
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم حذف القسم');
            }

        }

//        return Response::json($user);
        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $category = Category::where($where)->first();
        if(!$category){
            Alert::error('خطأ', 'القسم غير موجوده بالنظام');
            return back();
        }

        $basic_categories = BasicCategory::all();
        return view('dashboard.categories.edit' , compact('category' ,'basic_categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCategory(Request $request ,$id){


        $messeges = [

            'name_ar.required'=>"اسم القسم باللغه العربيه مطلوب",
            'name_en.required'=>"اسم القسم باللغه الانجليزيه مطلوب",
            'basic_category_id.required'=>"يرجي اختيار القسم الرئيسي",

        ];

        $validator =  Validator::make($request->all(), [

            'name_ar' => ['required'],

            'name_en' => ['required'],

            'basic_category_id' => ['required'],
        ], $messeges);



        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }


        $category = Category::find($id);


        if(!$category){
            Alert::error('خطأ', 'القسم غير موجود');
            return back();
        }


        $country = $category->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'basic_category_id' => $request['basic_category_id'],


        ]);


        if($country){
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم تعديل بيانات القسم');
            }
        }

        return redirect()->route('categories.index');



//        $uId = $request->user_id;
//        User::updateOrCreate(['id' => $uId],['name' => $request->name, 'email' => $request->email]);
//        if(empty($request->user_id))
//            $msg = 'User created successfully.';
//        else
//            $msg = 'User data is updated successfully';
//        return redirect()->route('users.index')->with('success',$msg);


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::where('id',$id)->first();
        $products=Product::where('category_id',$id)->get();

        if($products){
            foreach($products as $prod){
                if(file_exists(storage_path('app/public/'.$prod->img)))
                {
                    unlink(storage_path('app/public/'.$prod->img));
                }
                    $prod->delete();
            }
        }

        if($category){
            $category->delete();
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم حذف القسم');
            }

        }

//        return Response::json($user);
        return redirect()->route('categories.index');
    }

}
