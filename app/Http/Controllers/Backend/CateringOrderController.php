<?php

namespace App\Http\Controllers\Backend;

use App\Catering;
use App\Country;
use App\Http\Controllers\Controller;
use App\CateringOrder;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CateringOrderController extends Controller
{


    public function index(Request $request)
    {

        $order = CateringOrder::where('status','!=',0)->latest()->get();
            $number=$order->count();
            $total_price=$order->sum('total_price');
            $today=$order->where('created_at','>=',  Carbon::today())->count();
            $today_price=$order->where('created_at','>=',  Carbon::today())->sum('total_price');

        if ($request->ajax()) {
            $data = CateringOrder::where('status','!=',0)->latest()->get();
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
                         href="'.route('catering_order.items.view' , $row->id).'" id="edit-user" >'.\Lang::get('site.order_details').' </a>

                     ';

                    if($row->status == 1){
                    $action .='         <a class="btn btn-success"
                      style="margin:5px"
                    href="'.route('catering_orders.received' , $row->id).'" id="edit-user" >'.\Lang::get('site.switch_received').' </a>';
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

        return view('dashboard.catering_orders.index',compact('today_price','today','total_price','number'));
    }
    public function today(Request $request)
    {

        $order = CateringOrder::where('status','!=',0)->latest()->get();
            $number=$order->count();
            $total_price=$order->sum('total_price');
            $today=$order->where('created_at','>=',  Carbon::today())->count();
            $today_price=$order->where('created_at','>=',  Carbon::today())->sum('total_price');
            // dd($today_price,$today,$total_price,$number);

        if ($request->ajax()) {
                // dd('ajax');
                $data = CateringOrder::where('status','!=',0)->where('created_at','>=',  Carbon::today())->latest()->get();


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('history', function ($artist) {
                    return $artist->created_at->format('Y-m-d');
                })
                ->addColumn('status', function ($artist) {
                    if($artist->status == 0){

                        return 'لم يتم الدفع بعد';
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
                         href="'.route('catering_order.items.view' , $row->id).'" id="edit-user" >Order Items </a>

                     ';

                    if($row->status == 1){
                        $action .='         <a class="btn btn-success"
                      style="margin:5px"
                    href="'.route('catering_orders.received' , $row->id).'" id="edit-user" >Recevied </a>';
                    }

                    $action .='
                        <meta name="csrf-token" content="{{ csrf_token() }}">';
//                        <a href="'.url('countries/destroy' , $row->id).'" class="btn btn-danger">Delete</a>

                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }
        // dd($today_price,$today,$total_price,$number);

        return view('dashboard.catering_orders.today',compact('today_price','today','total_price','number'));
    }
    public function not_paid(Request $request)
    {
        // dd('ok');
        // dd($data);
        if ($request->ajax()) {
            $data = CateringOrder::where('status',0)->latest()->get();
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
                         href="'.route('catering_order.items.view' , $row->id).'" id="edit-user" >'.\Lang::get('site.order_details').'  </a>

                     ';

                    if($row->status == 1){
                    $action .='         <a class="btn btn-success"
                      style="margin:5px"
                    href="'.route('catering_orders.received' , $row->id).'" id="edit-user" >Recevied </a>';
                    }

                    $action .='
                        <meta name="csrf-token" content="{{ csrf_token() }}">';
//                        <a href="'.url('countries/destroy' , $row->id).'" class="btn btn-danger">Delete</a>

                    return $action;

                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.catering_orders.not_paid');
    }

    public function receive($order_id){

        $order = CateringOrder::find($order_id);

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
        // dd('items');
        $order = CateringOrder::find($order_id);

        if(!$order){
            Alert::error('خطأ','الطلب غير موجود بالنظام ');
            return back();
        }

        if ($request->ajax()) {
            $data = Catering::where('id' , $order->catering_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('product', function ($artist) {
                    return $artist->title_en?:'' . ' - ' . $artist->title_ar?:'' ;
                })

                ->addColumn('image', function ($artist) {
                    $url = asset('/storage/' . $artist->image);
                    return $url;
                })
                ->addColumn('price', function ($artist) {
                    return $artist->price?:"";
                })


//                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.catering_orders.view' , compact('order'));
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
