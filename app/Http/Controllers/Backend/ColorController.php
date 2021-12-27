<?php

namespace App\Http\Controllers\Backend;

use App\Color;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // dd($data);
        if ($request->ajax()) {
            $data = Color::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $action = '
                        <a class="btn btn-success"  href="'.route('colors.edit' , $row->id).'" id="edit-user" >'.\Lang::get('site.edit').' </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <a href="'.url('colors/destroy' , $row->id).'" class="btn btn-danger">'.\Lang::get('site.delete').'</a>
                        ';
//

                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.colors.index');
    }

    public function create(){

        return view('dashboard.colors.create');
    }

    public function store(Request $request)
    {
        // dd('store');


        $messeges = [

            'name_ar.required'=>"اسم اللون باللغه العربيه مطلوب",
            'name_en.required'=>"اسم اللون باللغه الانجليزيه مطلوب",
            // 'code.required'=>"رمز اللون مطلوب",

        ];

        $validator =  Validator::make($request->all(), [

            'name_ar' => ['required'],

            'name_en' => ['required'],

            // 'code' => ['required'],
        ], $messeges);

        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }


        $color = null;
        $color=Color::create($request->all());
        if ($color){

            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تمت إضافة اللون');
            }

        }

        return redirect()->route('colors.index');
    }


    public function updateColor(Request $request ,$id){

// dd('color')
        $messeges = [

            'name_ar.required'=>"اسم اللون باللغه العربيه مطلوب",
            'name_en.required'=>"اسم اللون باللغه الانجليزيه مطلوب",
            // 'code.required'=>"رمز اللون مطلوب",
        ];

        $validator =  Validator::make($request->all(), [

            'name_ar' => ['required'],

            'name_en' => ['required'],

            // 'code' => ['required' ],
        ], $messeges);



        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }

        $color = Color::find($id);

        if(!$color){
            Alert::error('خطأ', 'اللون غير موجود');
            return back();
        }

            $color = $color->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                // 'code' => $request['code'],
            ]);





        if($color){
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم تعديل بيانات اللون');
            }
        }

        return redirect()->route('colors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

//    public function show($id)
//    {
//        $where = array('id' => $id);
//        $user = User::where($where)->first();
//        return Response::json($user);
////return view('users.show',compact('user'));
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */

    public function edit($id)
    {
        $where = array('id' => $id);
        $color = Color::where($where)->first();
        if(!$color){
            Alert::error('خطأ', 'اللون غير موجود بالنظام');
            return back();
        }

        return view('dashboard.colors.edit' , compact('color'));

    }

    public function destroy($id)
    {
        $color = Color::where('id',$id)->first();

        if($color){
            $color->delete();
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', ' تم حذف اللون ');
            }

        }

//        return Response::json($user);
        return redirect()->route('colors.index');
    }
}
