<?php

namespace App\Http\Controllers\Backend;

use App\City;
use App\Country;
use App\Currency;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Country::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($artist) {
                    $url = asset('/storage/' . $artist->image_url);
                    return $url;
                })
                ->addColumn('currency_name', function ($artist) {
                    return $artist->currency->name;
                })
                ->addColumn('currency_code', function ($artist) {
                    return $artist->currency->code;
                })
                ->addColumn('action', function($row){

                    $action = '
                        <a class="btn btn-primary"  href="'.route('cities.view' , $row->id).'" id="edit-user" >'.\Lang::get('site.cities').'  </a>
                        <a class="btn btn-success"  href="'.route('countries.edit' , $row->id).'" id="edit-user" >'.\Lang::get('site.edit').' </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <a href="'.url('countries/destroy' , $row->id).'" class="btn btn-danger">'.\Lang::get('site.delete').'</a>
                        ';
//

                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.countries.index');
    }

    public function create(){
        $currencies = Currency::all();

        return view('dashboard.countries.create' , compact('currencies'));
    }

    public function store(Request $request)
    {


        $messeges = [

            'name_ar.required'=>"اسم الدوله باللغه العربيه مطلوب",
            'name_en.required'=>"اسم الدوله باللغه الانجليزيه مطلوب",
            'code.required'=>"رمز الدوله مطلوب",
            'country_code.required'=>"إختصار الدوله مطلوب",
            'currency_id.required'=>"يرجي اختيار عملة الدوله",
            'currency_id.unique'=>"العمله المختاره مستخدمه من قبل دوله اخري",
            'image_url.required'=>"صورة علم الدوله مطلوبة",
            'image_url.mimes'=>" يجب ان تكون الصورة jpg او jpeg او png  ",
            'image_url.max'=>" الحد الاقصي للصورة 4 ميجا ",
        ];

        $validator =  Validator::make($request->all(), [

            'name_ar' => ['required'],

            'name_en' => ['required'],

            'code' => ['required'],

            'country_code' => ['required'],

            'currency_id' => ['required' , 'unique:countries,currency_id'],

            'image_url' =>  'required|mimes:jpg,jpeg,png|max:4100',



        ], $messeges);

        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }


        $country = null;


        if ($request->hasfile('image_url')) {
            // $images .= 'yes';

            $image = $request->file('image_url');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = 'uploads/countries/images/';

            if (!Storage::exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
            dd($path.$file_name);
//
//            if(file_exists(storage_path('app/public/'.$path.$file_name)))
//            {
//                unlink(storage_path('app/public/'.$path.$file_name));
//            }



            $country = Country::create([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'code' => (int)$request['code'],
                'country_code' => $request['country_code'],
                'currency_id' => $request['currency_id'],
                'image_url' => $image->storeAs($path, $file_name, 'public'),
            ]);

        } else {
            Alert::error('خطأ', 'برجاء اختيار صورة القسم');
            return back();
        }
//        if ($request->hasfile('image_url')) {
//            // $images .= 'yes';
//
//            $image = $request->file('image_url');
//            $original_name = strtolower(trim($image->getClientOriginalName()));
//            $file_name = time() . rand(100, 999) . $original_name;
//            $path = 'uploads/countries/images/';
//
//            if (!Storage::exists($path)) {
//                Storage::disk('public')->makeDirectory($path);
//            }
//
//
//        } else {
//            Alert::error('خطأ', 'برجاء اختيار صورة علم الدوله');
//            return back();
//        }

//
//        $country = Country::create([
//            'name_ar' => $request['name_ar'],
//            'name_en' => $request['name_en'],
//            'code' => $request['code'],
//            'country_code' => $request['country_code'],
//            'delivery' => $request['delivery'],
//            'currency_id' => $request['currency_id'],
//        ]);

        if ($country){

            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تمت إضافة دوله');
            }

        }

        return redirect()->route('countries.index');

//        $uId = $request->user_id;
//        User::updateOrCreate(['id' => $uId],['name' => $request->name, 'email' => $request->email]);
//        if(empty($request->user_id))
//            $msg = 'User created successfully.';
//        else
//            $msg = 'User data is updated successfully';
//        return redirect()->route('users.index')->with('success',$msg);
    }


    public function updateCountry(Request $request ,$id){


        $messeges = [

            'name_ar.required'=>"اسم الدوله باللغه العربيه مطلوب",
            'name_en.required'=>"اسم الدوله باللغه الانجليزيه مطلوب",
            'code.required'=>"رمز الدوله مطلوب",
            'country_code.required'=>"إختصار الدوله مطلوب",
            'currency_id.required'=>"يرجي اختيار عملة الدوله",
            'currency_id.unique'=>"العمله المختاره مستخدمه من قبل دوله اخري",

        ];

        $validator =  Validator::make($request->all(), [

            'name_ar' => ['required'],

            'name_en' => ['required'],

            'code' => ['required' ],

            'country_code' => ['required'],

            'currency_id' => ['required' , 'unique:countries,currency_id,' .$id],

        ], $messeges);



        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }

        $country = Country::find($id);

        if(!$country){
            Alert::error('خطأ', 'الدوله غير موجوده');
            return back();
        }

        if ($request->hasfile('image_url')) {
            // $images .= 'yes';

            $image = $request->file('image_url');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $path = 'uploads/countries/images/';

            if (!Storage::exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }

//            return (storage_path('app/public/'.$cat->image_url));

            if(file_exists(storage_path('app/public/'.$country->image_url)))
            {
                unlink(storage_path('app/public/'.$country->image_url));
            }


            $country = $country->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'code' => (int)$request['code'],
                'country_code' => $request['country_code'],
                'currency_id' => $request['currency_id'],
                'image_url' => $image->storeAs($path, $file_name, 'public'),
            ]);


        } else {

            $country = $country->update([
                'name_ar' => $request['name_ar'],
                'name_en' => $request['name_en'],
                'code' => (int)$request['code'],
                'country_code' => $request['country_code'],
                'currency_id' => $request['currency_id'],
//                'image_url' => $image->storeAs($path, $file_name, 'public'),
            ]);

        }



        if($country){
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تم تعديل بيانات الدوله');
            }
        }

        return redirect()->route('countries.index');



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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */

    public function edit($id)
    {
        $where = array('id' => $id);
        $country = Country::where($where)->first();
        if(!$country){
            Alert::error('خطأ', 'الدوله غير موجوده بالنظام');
            return back();
        }

        $currencies = Currency::all();
        return view('dashboard.countries.edit' , compact('country' ,'currencies'));

    }

    public function destroy($id)
    {
        $country = Country::where('id',$id)->first();

        if($country){
            if(file_exists(storage_path('app/public/'.$country->image_url)))
            {
                unlink(storage_path('app/public/'.$country->image_url));
            }


            if($country->cities){
                if($country->cities->count() > 0){
                    foreach($country->cities as $city){
                        $city->delete();
                    }
                }
            }

            $country->delete();
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', ' تم حذف الدوله والمدن');
            }

        }

//        return Response::json($user);
        return redirect()->route('countries.index');
    }


    public function cities(Request $request,$country_id){
        $country = Country::find($country_id);

        if(!$country){
            Alert::error('خطأ','الدوله غير موجوده بالنظام ');
            return back();
        }

        if ($request->ajax()) {
            $data = City::where('country_id' , $country_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('country', function ($artist) {
                    return $artist->country->name_ar;
                })
                ->addColumn('action', function($row){

                    //  <a href="'.url('cities/destroy' , $row->id).'" class="btn btn-danger">Delete</a>
                    $action = '
                        <a class="btn btn-success"  href="'.route('cities.edit' , $row->id).'" id="edit-user" >Edit </a>
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                      ';
                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.countries.view' , compact('country'));
    }
}
