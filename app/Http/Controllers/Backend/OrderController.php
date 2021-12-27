<?php

namespace App\Http\Controllers\Backend;

use App\Country;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::where('status','!=',0)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($artist) {
                    if($artist->status == 0){

                        return 'لم يتم الدفع بعد';
                    }
                    if($artist->status == 1){
                        return 'جاري الشحن';
                    }
                    if($artist->status == 2){
                        return 'تم الأستلام';
                    }
                })
                ->addColumn('action', function($row){
//                    <a class="btn btn-success"  href="'.route('countries.edit' , $row->id).'" id="edit-user" >Edit </a>
                    $action = '
                        <a class="btn btn-primary"
                         style="margin:5px"
                         href="'.route('order.items.view' , $row->id).'" id="edit-user" >'.\Lang::get('site.order_details').' </a>

                     ';

                    if($row->status == 1){
                    $action .='         <a class="btn btn-success"
                      style="margin:5px"
                    href="'.route('orders.received' , $row->id).'" id="edit-user" >'.\Lang::get('site.switch_received').' </a>';
                    }
                    if($row->status == 2){
                    $action .='         <a class="btn btn-dark"
                      style="margin:5px"
                     id="edit-user" >'.\Lang::get('site.received_done').' </a>';
                    }

                    $action .='
                        <meta name="csrf-token" content="{{ csrf_token() }}">';
//                        <a href="'.url('countries/destroy' , $row->id).'" class="btn btn-danger">Delete</a>

                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.orders.index');
    }
    public function not_paid(Request $request)
    {
        // dd('ok');
        // dd($data);
        if ($request->ajax()) {
            $data = Order::where('status',0)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($artist) {
                    if($artist->status == 0){

                        return 'غير مدفوع';
                    }
                    if($artist->status == 1){
                        return 'تم الدفع';
                    }
                    if($artist->status == 2){
                        return 'تم الأستلام';
                    }
                })
                ->addColumn('action', function($row){
//                    <a class="btn btn-success"  href="'.route('countries.edit' , $row->id).'" id="edit-user" >Edit </a>
                    $action = '
                        <a class="btn btn-primary"
                         style="margin:5px"
                         href="'.route('order.items.view' , $row->id).'" id="edit-user" >'.\Lang::get('site.order_details').'  </a>

                     ';

                    if($row->status == 1){
                    $action .='         <a class="btn btn-success"
                      style="margin:5px"
                    href="'.route('orders.received' , $row->id).'" id="edit-user" >Recevied </a>';
                    }

                    $action .='
                        <meta name="csrf-token" content="{{ csrf_token() }}">';
//                        <a href="'.url('countries/destroy' , $row->id).'" class="btn btn-danger">Delete</a>

                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.orders.not_paid');
    }

    public function receive($order_id){

        $order = Order::find($order_id);

        if(!$order){
            Alert::error('Order Not Found' , '');

            return back();
        }

        $order->status = 2;

        $order->save();

        //TODO :: MAIL IS HERE

        // Mail::send('email.doneDelivery',['name' => $order->name,'address' => $order->address1,'invoice_id' => $order->invoice_id], function($message) use($order){
        //     $message->to($order->email)
        //         ->from('sales@easyshop-qa.com', 'Abati sakbah')
        //         ->subject('Pay done');
        // });


        Alert::success('Order updated Successfully !' , '');

        return back();
    }


    public function items( Request $request,$order_id){

        $order = Order::find($order_id);

        if(!$order){
            Alert::error('خطأ','الطلب غير موجود بالنظام ');
            return back();
        }

        if ($request->ajax()) {
            $data = OrderItem::where('order_id' , $order_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('product', function ($artist) {
                    return $artist->product->title_en?:'' . ' - ' . $artist->product->title_ar?:'' ;
                })
                ->addColumn('category', function ($artist) {
                    $val = '';
                    $val .= '( '.$artist->product->basic_category->name_en?:"" . ' - ' .$artist->product->basic_category->name_ar?:"" .' ) /';
                    $val .= ' ( '.$artist->product->category->name_en?:"" . ' - ' .$artist->product->category->name_ar?:"" .' ) ';
                    return $val;

                })
                ->addColumn('image', function ($artist) {
                    $url = asset('/storage/' . $artist->product->img);
                    return $url;
                })
                ->addColumn('price', function ($artist) {
                    return $artist->product->price?:"";
                })
                ->addColumn('height', function ($artist) {
                    if ($artist->product->basic_category->type == 1) {
                        return "-";
                    }
                    else{
                        return $artist->height->height->name?:"";

                    }
                })
                ->addColumn('size', function ($artist) {
                    if ($artist->product->basic_category->type == 1) {
                        return "-";
                    }
                    else{

                        return $artist->size->size->name?:"";
                    }
                })
//                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.orders.view' , compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
