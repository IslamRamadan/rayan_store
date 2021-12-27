<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Redirect,Response;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('job_id' , 0)->latest()->get();
            return Datatables::of($data)
                ->addColumn('created_at', function ($artist) {
                    $date = date_create($artist->created_at);
                    return date_format( $date,'l jS \of F Y h:i:s A');
                })
                ->addColumn('country', function ($artist) {
                    return $artist->country->name_ar  .'  -  '.$artist->country->name_en;
                })
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $action = '
                        <a class="btn btn-success"  href="'.route('users.edit' , $row->id).'" id="edit-user" >'.\Lang::get('site.edit').' </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <a href="'.route('users.destroy' , $row->id).'" class="btn btn-danger">'.\Lang::get('site.delete').'</a>';
                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.users.index');
    }

    public function create(){
        return view('dashboard.users.create');
    }
    public function store(Request $request)
    {


        $messeges = [

            'name.required'=>"اسم العميل مطلوب",
            'email.required'=>"البريد الالكتروني مطلوب",
            'phone.required'=>"رقم الهاتف مطلوب",
            'country.required'=>"برجاء اختيار الدوله",
            'email.unique'=>" البريد الإلكتروني مربوط بحساب اخر",
            'email.email'=>" البريد الإلكتروني غير صحيح يرجي إضافة رمز @",
            'password.required'=>"كلمة المرور مطلوبه",
            'password.min'=>"كلمة المرور يجب الا تقل عن 8 أحرف",
            'phone.max'=>"يجب ألا يزيد رقم الهاتف عن 11 رقم",

        ];

        $validator =  Validator::make($request->all(), [

            'name' => ['required'],
            'phone' => ['required' , 'max:11'],
            'country' => ['required'],

            'email' =>  ['required', 'email', 'unique:users'],
            //"qut"=> "required|Numeric",
            "password"=> ['required', 'min:8'],


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
        ]);

        if ($user){

            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تمت إضافة عميل');
            }

        }

        return redirect()->route('users.index');

//        $uId = $request->user_id;
//        User::updateOrCreate(['id' => $uId],['name' => $request->name, 'email' => $request->email]);
//        if(empty($request->user_id))
//            $msg = 'User created successfully.';
//        else
//            $msg = 'User data is updated successfully';
//        return redirect()->route('users.index')->with('success',$msg);
    }


    public function updateUser(Request $request){

        $messeges = [

                'name.required'=>"اسم العميل مطلوب",
                'email.required'=>"البريد الالكتروني مطلوب",
                'phone.required'=>"رقم الهاتف مطلوب",
                'country.required'=>"برجاء اختيار الدوله",
//                'email.unique'=>" البريد الإلكتروني مربوط بحساب اخر",
                'email.email'=>" البريد الإلكتروني غير صحيح يرجي إضافة رمز @",
                'password.required'=>"كلمة المرور مطلوبه",
                'password.min'=>"كلمة المرور يجب الا تقل عن 8 أحرف",
            'phone.max'=>"يجب ألا يزيد رقم الهاتف عن 11 رقم",

            ];

            $validator =  Validator::make($request->all(), [

                'name' => ['required'],
                'phone' => ['required' , 'max:11'],
                'country' => ['required'],

                'email' =>  ['required', 'email' , 'unique:users,email,'.$request['id']],
                //"qut"=> "required|Numeric",
                "password"=> ['required', 'min:8'],


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
            ]);

            if($user){
                session()->flash('success', "success");
                if(session()->has("success")){
                    Alert::success('نجح', 'تم تعديل بيانات العميل');
                }
            }

            return redirect()->route('users.index');



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
            Alert::error('خطأ', 'العميل غير موجود بالنظام');
            return back();
        }

        return view('dashboard.users.edit' , compact('user'));

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
                Alert::success('نجح', 'تم حذف عميل');
            }

        }

//        return Response::json($user);
return redirect()->route('users.index');
    }
}
