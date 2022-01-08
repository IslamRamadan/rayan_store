<?php

namespace App\Http\Controllers\front;

use App\Catering;
use App\CateringOrder;
use App\Hall;
use App\HallOrder;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class orderController extends Controller
{
    public function index()
    {
//        $orders = OrderItem::distinct('product_id','')->pluck('product_id')->all();

//        $orders = Order::all();
//        dd($orders->order_item);

//        $comment = Order::all();
//
//        dd($comment->order_item) ;

//        foreach ($orders->order_item as $order){
//            dd($order->id);
//
//        }

//        $orders= Order::with('order_item')->where('id', 'like', '%1%')->first();
//
//        $postComment = array();
//
//        foreach($orders->order_item as $post){
//            $postComment = $post->order_item;
//        }
//        dd($postComment);
//
//        $comments = [];
//
//            $user = Order::where('country_id', 1)->with(['order_item.order' => function($query) use (&$comments) {
//            $comments = $query->get();
//        }])->first();
//foreach ($comments as $u){
//    echo("11") ;
//
//}
        $user_id = auth()->user()->id;
        $orders = Order::where('user_id', $user_id)->get();
//                dd($user);

//        $orders=[];
//        foreach ($user as $us){
//            array_push($orders,$us);
//
//        }


//        dd($orders);

        return view('front.myorder', compact('orders'));
    }

    public function hallOrder(Request $request, $id)
    {
        $validator = validator($request->all(), [
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->errors()->first(), '');
            return back();
        }

        $inputs = $request->all();
        $inputs['hall_id'] = $id;
        $inputs['user_id'] = auth()->id();
        $inputs['day_price'] = Hall::findOrFail($id)->price;
        $inputs['days'] = (strtotime($request->end_date) - strtotime($request->start_date)) / (60 * 60 * 24) + 1;
        HallOrder::create($inputs);
        Alert::success('نجح', ' تم الحجز بنجاح.');
        return back();
    }

    public function cateringOrder(Request $request, $id)
    {
        dd($request->all());
        $catering = Catering::findOrFail($id);
        $validator = validator($request->all(), [
            'name' => 'required|max:250',
            'email' => 'nullable|email|max:250',
            'phone' => 'required|max:250',
            'street' => 'required|max:250',
            'block' => 'required|max:250',
            'floor' => 'required|max:250',
            // 'address' => 'required|max:250',
            'persons_no' => 'required|int|min:' . $catering->persons_no,
            'note' => 'nullable|max:2250',
            'request_female' => 'nullable|in:0,1',
            'ad_hours' => 'required|int|min:0',
            'ad_service' => 'required|int|min:0',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->errors()->first(), '');
            return back();
        }

        $inputs = $request->all();
        $inputs['catering_id'] = $id;
        $inputs['user_id'] = auth()->id();
        $inputs['price'] = $catering->price + (($request->persons_no - $catering->persons_no) * $catering->ad_person_price);
        $inputs['ad_hours_price'] = $catering->ad_hour_price * $request->ad_hours;
        $inputs['ad_service_price'] = $catering->ad_service_price * $request->ad_service;
        $inputs['total_price'] = $inputs['price'] + $inputs['ad_hours_price'] + $inputs['ad_service_price'];
        dd($inputs);
        CateringOrder::create($inputs);
        Alert::success('نجح', ' تم الحجز بنجاح.');
        return back();
    }
}
