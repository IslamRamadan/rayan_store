<?php

namespace App\Http\Controllers\front;

use App\Coupon;
use App\Http\Controllers\Controller;
use App\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
use Lang;


class CouponController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // dd(auth()->user()->id);
        if (!Auth::user()) {   // Check is user logged in
            return back()->withErrors(\Lang::get('site.log_first'));
        }
        $coupon=Coupon::where('code',$request->coupon)->first();
        $cart_details = Session::get('cart_details');
        $user_coupon = UserCoupon::where('user_id',auth()->user()->id)->where('coupon_id',$coupon->id)->first();
        // dd($user_coupon);
        if($user_coupon){
            return back()->withErrors(\Lang::get('site.used_coupon'));
        }
        // dd($cart_details['totalPrice']);
        if (!$coupon) {
            return back()->withErrors('Invalid coupon code. Please try again.');
        }


        $session=session()->put('coupon',[
            'name'=> $coupon->code,
            'percentage'=>$coupon->percentage,
            'discount'=>$coupon->discount($cart_details['totalPrice'])
        ]);
         UserCoupon::create([
            'user_id' => auth()->user()->id,
            'coupon_id' => $coupon->id,
        ]);
        // dd($session['discount']);


        // dd(Session::get('coupon'));
        // dd($request->coupon,$coupon);
        return back()->with('success_message', 'Coupon has been applied!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        session()->forget('coupon');
        return back()->with('success_message', 'Coupon has been removed.');    }
}
