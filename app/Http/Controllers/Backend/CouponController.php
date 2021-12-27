<?php

namespace App\Http\Controllers\Backend;

use App\Coupon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Coupon::latest()->get();
            return DataTables::of($data)
            ->addColumn('percent', function ($artist) {
                $url =  $artist->percentage ."%";
                return $url;
            })
                ->addIndexColumn()

                ->addColumn('action', function($row){

                    $action = '

                                               <meta name="csrf-token" content="{{ csrf_token() }}">
                        <a href="'.url('coupons/destroy' , $row->id).'" class="btn btn-danger">'.\Lang::get('site.delete').'</a>
                        ';
//

                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.coupons.index');
    }
    public function create(){
        $coupon = Coupon::all();

        return view('dashboard.coupons.create' , compact('coupon'));
    }

    public function store(Request $request)
    {


        $messeges = [

            'code.required'=>"كود الخصم مطلوب",
            'percentage.required'=>"  النسبه المئويه مطلوبه",
            'percentage.number'=>"  النسبه المئويه يجب ان تكون رقم بدون علامه مئويه",

        ];

        $validator =  Validator::make($request->all(), [

            'code' => ['required'],

            'percentage' => ['required'],

        ], $messeges);

        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }


        $coupons = null;





            $coupons = coupon::create([
                'code' => $request['code'],

                'percentage' => $request['percentage']?:0,

            ]);




        if ($coupons){

            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', 'تمت إضافة كود الخصم');
            }

        }

        return redirect()->route('coupons.index');

    }
    public function destroy($id)
    {
        // dd('dd');
        $coupon = Coupon::where('id',$id)->first();

        if($coupon){

            $coupon->delete();
            session()->flash('success', "success");
            if(session()->has("success")){
                Alert::success('نجح', ' تم حذف كود الخصم');
            }

        }

//        return Response::json($user);
        return redirect()->route('coupons.index');
    }



}
