<?php

namespace App\Http\Controllers\Backend;

use App\Height;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class HeightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data =  Height::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action = '
                        <a class="btn btn-success"  href="'.route('heights.edit' , $row->id).'" >'.\Lang::get('site.edit').' </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <a  href="'.route('heights.destroy' , $row->id).'" class="btn btn-danger">'.\Lang::get('site.delete').'</a>';
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.heights.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.heights.create');

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

            'name.required'=>"الطول مطلوب",


        ];

        $validator =  Validator::make($request->all(), [

            'name' => 'required',


        ], $messeges);



        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }


        $size = Height::create([
            'name' => $request['name'],

        ]);

        if ($size){

            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تمت إضافة الطول');
            }

            return redirect()->route('heights.index');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $size = Height::where('id',$id)->first();

        if($size){
            $size->delete();
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم حذف الطول');
            }
            return redirect()->route('heights.index');


        }
    }

    public function updateHeight(Request $request){

        $messeges = [

            'name.required'=>" الطول مطلوب",


        ];

        $validator =  Validator::make($request->all(), [

            'name' => 'required',


        ], $messeges);



        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }

        $currency= Height::findOrFail($request['id']);

        $currency= $currency->update([
            'name' => $request['name'],


        ]);

        if($currency){
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم تعديل بيانات الطول');
            }
        }

        return redirect()->route('heights.index');



//        $uId = $request->user_id;
//        User::updateOrCreate(['id' => $uId],['name' => $request->name, 'email' => $request->email]);
//        if(empty($request->user_id))
//            $msg = 'User created successfully.';
//        else
//            $msg = 'User data is updated successfully';
//        return redirect()->route('users.index')->with('success',$msg);


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
        $size = Height::where($where)->first();
        if(!$size){
            Alert::error('خطأ', 'الطول غير موجود بالنظام');
            return back();
        }

        return view('dashboard.heights.edit' , compact('size'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $size = Height::where('id',$id)->first();

        if($size){
            $size->delete();
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم حذف الطول');
            }
            return redirect()->route('heights.index');


        }
    }
}
