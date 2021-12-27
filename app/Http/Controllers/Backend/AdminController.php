<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('job_id' , 1)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $action = '
<a class="btn btn-success"  href="'.route('admins.edit' , $row->id).'" id="edit-user" >'.\Lang::get('site.edit').' </a>
<meta name="csrf-token" content="{{ csrf_token() }}">';

//<a href="'.url('/admins/destroy', $row->id).'" class="btn btn-danger">Delete</a>

                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.admins.index');
    }

    public function create(){
        return view('dashboard.admins.create');
    }
    public function store(Request $request)
    {


        $messeges = [

            'name.required'=>"اسم المدير مطلوب",
            'email.required'=>"البريد الالكتروني مطلوب",
            'email.unique'=>" البريد الإلكتروني مربوط بحساب اخر",
            'email.email'=>" البريد الإلكتروني غير صحيح يرجي إضافة رمز @",
            'password.required'=>"كلمة المرور مطلوبه",
            'phone.required'=>"رقم الهاتف مطلوب",
            'password.min'=>"كلمة المرور يجب الا تقل عن 8 أحرف",
            'phone.max'=>"يجب ألا يزيد رقم الهاتف عن 11 رقم",

        ];

        $validator =  Validator::make($request->all(), [

            'name' => ['required'],

            'email' =>  ['required', 'email', 'unique:users'],
            //"qut"=> "required|Numeric",
            "password"=> ['required', 'min:8'],
            "phone"=> ['required' , 'max:11'],


        ], $messeges);



        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }


        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'password_view' =>$request['password'],
            'phone' =>$request['phone'],
            'country_id' =>$request['country'],
            'job_id' =>$request['job_id'],
        ]);

        if ($user){

            $user->attachRole('admin');

            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تمت إضافة مدير');
            }

        }

        return redirect()->route('admins.index');

//        $uId = $request->user_id;
//        User::updateOrCreate(['id' => $uId],['name' => $request->name, 'email' => $request->email]);
//        if(empty($request->user_id))
//            $msg = 'User created successfully.';
//        else
//            $msg = 'User data is updated successfully';
//        return redirect()->route('users.index')->with('success',$msg);
    }


    public function updateAdmin(Request $request){


        $messeges = [

            'name.required'=>"اسم المدير مطلوب",
            'email.required'=>"البريد الالكتروني مطلوب",
            'email.unique'=>" البريد الإلكتروني مربوط بحساب اخر",
            'email.email'=>" البريد الإلكتروني غير صحيح يرجي إضافة رمز @",
            'password.required'=>"كلمة المرور مطلوبه",
            'phone.required'=>"رقم الهاتف مطلوب",
            'password.min'=>"كلمة المرور يجب الا تقل عن 8 أحرف",
            'phone.max'=>"يجب ألا يزيد رقم الهاتف عن 11 رقم",

        ];

        $validator =  Validator::make($request->all(), [

            'name' => ['required'],

            'email' =>  ['required', 'email',  'unique:users,email,'.$request['id']],
            //"qut"=> "required|Numeric",
            "password"=> ['required', 'min:8'],
            "phone"=> ['required' , 'max:11'],


        ], $messeges);



        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }

        $user= User::findOrFail($request['id']);

        $user= $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'password_view' =>$request['password'],
            'phone' =>$request['phone'],
            'country_id' =>$request['country'],
            'job_id' =>1,
        ]);

        if($user){

            if(! User::find($request['id'])->hasRole('admin')) $user->attachRole('admin');

            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم تعديل بيانات المدير');
            }
        }

        return redirect()->route('admins.index');



//        $uId = $request->user_id;
//        User::updateOrCreate(['id' => $uId],['name' => $request->name, 'email' => $request->email]);
//        if(empty($request->user_id))
//            $msg = 'User created successfully.';
//        else
//            $msg = 'User data is updated successfully';
//        return redirect()->route('users.index')->with('success',$msg);


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
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $where = array('id' => $id);
        $user = User::where($where)->first();
        if(!$user){
            Alert::error('خطأ', 'المدير غير موجود بالنظام');
            return back();
        }

        return view('dashboard.admins.edit' , compact('user'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy($id)
    {
        $user = User::where('id',$id)->first();

        if($user){
            $user->delete();
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم حذف مدير');
            }
        }

//        return Response::json($user);
        return redirect()->route('admins.index');
    }

    function show($id)
    {
        //
    }

    public function admin(){
        return view('dashboard.home');
    }


}
