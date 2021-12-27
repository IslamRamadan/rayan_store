<?php

namespace App\Http\Controllers\Backend;

use App\Currency;
use App\Http\Controllers\Controller;
//use App\User;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
//use Illuminate\Support\Facades\Validator;
//use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data =  Currency::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action = '
                        <a class="btn btn-success"  href="'.route('currencies.edit' , $row->id).'" >'.\Lang::get('site.edit').' </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                         <a  href="'.route('currencies.destroy' , $row->id).'" class="btn btn-danger">'.\Lang::get('site.delete').'</a>
                                          ';

//
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.currencies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.currencies.create');

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

            'name.required'=>"اسم العمله مطلوب",
            'rate.required'=>"النسبه مطلوبه",
            'code.required'=>"كود العمله مطلوب",
            'code.unique' => "يرجي تغيير كود العمله لانه مستخدم بالفعل لعمله اخري"

        ];

        $validator =  Validator::make($request->all(), [

            'name' => 'required',
            'rate' => 'required',
            'code' => ['required' , 'unique:currencies,code'],

        ], $messeges);



        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }


        $currency = Currency::create([
            'name' => $request['name'],
            'rate' => $request['rate'],
            'code' => $request['code'],
        ]);

        if ($currency){

            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تمت إضافة العمله');
            }

            return redirect()->route('currencies.index');

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
        $currency = Currency::where('id',$id)->first();

        if($currency){
            $currency->delete();
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم حذف العمله');
            }

        }

//        return Response::json($user);
        return redirect()->route('currencies.index');

    }

    public function updateCurrency(Request $request){

        $messeges = [

            'name.required'=>"اسم العمله مطلوب",
            'rate.required'=>"النسبه مطلوبه",
            'code.required'=>"كود العمله مطلوب",
            'code.unique' => "يرجي تغيير كود العمله لانه مستخدم بالفعل لعمله اخري"

        ];

        $validator =  Validator::make($request->all(), [

            'name' => 'required',
            'rate' => 'required',
            'code' => ['required' ,'unique:currencies,code,' .$request['id']],

        ], $messeges);



        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }

        $currency= Currency::findOrFail($request['id']);

        $currency= $currency->update([
            'name' => $request['name'],
            'rate' => $request['rate'],
            'code' => $request['code'],

        ]);

        if($currency){
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم تعديل بيانات العمله');
            }
        }

        return redirect()->route('currencies.index');



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
        $currency = Currency::where($where)->first();
        if(!$currency){
            Alert::error('خطأ', 'العمله غير موجوده بالنظام');
            return back();
        }

        return view('dashboard.currencies.edit' , compact('currency'));

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
        $currency = Currency::where('id',$id)->first();

        if($currency){
            $currency->delete();
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم حذف العمله');
            }

        }

//        return Response::json($user);
        return redirect()->route('currencies.index');
    }

}
