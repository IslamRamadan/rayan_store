<?php

namespace App\Http\Controllers\front;

use App\BestSeller;
use App\City;
use App\Country;
use App\Height;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderItem;
use App\ProdHeight;
use App\ProdSize;
use App\Product;
use App\User;
use App\View;
use Auth;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Lang;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function getHeights(Request $request)
    {

        $size_id = $request['size_id'];
        $size = ProdSize::find($size_id);
        $heights = ProdHeight::where([
            'product_id' => $size->product_id,
            'size_id' => $size->size_id
        ])->get();

        $val = '';
        if (!$size->isAvailable()) {
            $val .= '<p style="text-align: center;font-weight: bold">
لا تتوفر مقاسات من هذا المنتج حاليا
</p>';
        } else {
            //CHECK IF COUNT MORE THAN 1 OR LESS THAN ONE

            if (Lang::locale() == 'en') {
                $val .= '<div id="s" class="color-blocks" style="font-weight: bold">
                <span class="b">height : </span>';
            } else {
                $val .= '<div id="s" class="color-blocks" style="font-weight: bold">
                <span class="a">الطول: </span>';
            }


            if ($heights->count() < 1) {


                $val .= '
            المنتج غير متاح حاليا
            ';
            } else {

                foreach ($heights as $height) {

                    if ($height->quantity >= 1) {
                        $val .= '  <div class="radio-inline color">'
                            . '<input type="radio" name="height" value="' . $height->id . '" id="height-' . $height->id . '">'
                            . '<label for="height-' . $height->id . '" >' . $height->height->name . '</label>'
                            . '</div>';
                    }
                }
            }


            $val .= ' </div>';
        }

        return response()->json($val);
    }

    public function addToCart(Request $request)
    {

        if (!is_array(Session::get('cart'))) {
            Session::forget('cart');
            //            return   Session::get('cart');
        }
        //
        //        $cart = Session::get('cart');
        //
        //        $cart[$product[0]->id] = array(
        //            "id" => $product[0]->id,
        //            "nama_product" => $product[0]->nama_product,
        //            "harga" => $product[0]->harga,
        //            "pict" => $product[0]->pict,
        //            "qty" => 1,
        //        );
        //
        //        Session::put('cart', $cart);
        //        Session::flash('success','barang berhasil ditambah ke keranjang!');
        //

        //        Session::forget('cart');
        $product = $request->except('_token');
        // dd($product);

        $cart = Session::get('cart');

        $cart_details = Session::get('cart_details');

        $current_product = Product::find($product['product_id']);

        // dd($current_product->basic_category->type);
        if($current_product->basic_category->type == 1){
            $current_height = ProdHeight::where('product_id',$product['product_id'])->where('height_id',0)->where('size_id',0)->first();
            // dd($current_height->quantity);
        }else{
        $current_height = ProdHeight::find($product['product_height_id']);
        }
        // dd($product,$current_product,$current_height);


        if ($product['quantity'] > $current_height->quantity) {

            Alert::error('الكميه الموجوده حاليا لهذا المقاس اقل من الكميه المطلوبه !');

            return back();
        }

        if (isset($cart[$product['product_id']][$product['product_height_id']])) :
            $cart[$product['product_id']][$product['product_height_id']]['quantity'] += $product['quantity'];
        else :
            $cart[$product['product_id']][$product['product_height_id']] = $product;
            $cart[$product['product_id']][$product['product_height_id']]['quantity'] = $product['quantity']; // Dynamically add initial qty
        endif;

        Session::put('cart', $cart);
        // dd(Session::get('cart') );
        $total_price = 0;
        $total_qty = 0;

        if (count($cart) > 0) {
            foreach ($cart as $key => $item) {
                if (count($item) > 0) {
                    foreach ($item as $i) {
                        $total_price += Product::find($key)->price * intval($i['quantity']);
                        $total_qty += intval($i['quantity']);
                        //                        $total_price = $i;
                    }
                }
            }
        }


        $cart_details['totalPrice'] = $total_price;
        $cart_details['totalQty'] = $total_qty;

        Session::put('cart_details', $cart_details);

        return response()->json(
            [
                'success' => true,
                'cart_items' => count(Session::get('cart')),
                'message' => 'Cart updated.',
                'cart_data' => Session::get('cart'),
                'cart_details' => Session::get('cart_details'),

            ]
        );

        //
        //
        //        $product_id =  $request->product_id;
        //        $quantity =  $request->quantity;
        //        $product_size_id =  $request->product_size_id;
        //        $product_height_id =  $request->product_height_id;
        //        $_SESSION['cart'][] = array(
        //            'id' => $product_id,
        //            'qty' => $quantity,
        //            'size' => $product_size_id,
        //            'height' => $product_height_id
        //        );
    }

    public function viewFromCart()
    {

        $cart = Session::get('cart');


        //        $products = Product::latest()->take(1)->get();

        $val = '';

        foreach ($cart as $key => $cart_item) {

            if ($key === array_key_first($cart)) {
                if ($cart_item && ($cart_item != '')) {
                    foreach ($cart_item as $k => $product_details) {
                        if ($k === array_key_first($cart_item)) {
                            if ($product_details && ($product_details != '')) {

                                $product = Product::find($product_details['product_id']);

                                $val .= '  <div>'
                                    . '<div id="cart-content" class=" row">'
                                    . '  <div class="col-3 pad-0">'
                                    . ' <img src=" ' . asset('/storage/' . $product->img) . '" width="50">'
                                    . ' </div>'
                                    . '<div class="col-8">'
                                    . ' <h6><a href="' . route('product', $product->id) . '" class="main-color">'
                                    . $product->title_en . ' - ' . $product->basic_category->name_en . ' - ' . $product->category->name_en .
                                    '</a></h6>'
                                    . '  <p> ' . ProdHeight::find($product_details['product_height_id'])->height->name . ' , '
                                    . ProdSize::find($product_details['product_size_id'])->size->name . '</p>';
                                //=======
                                $val .= '<h6>  ' . $product_details['quantity'] . ' * ';

                                if (Auth::check()) {
                                    $val .= Auth::user()->getPrice($product->price) . ' ';
                                    $val .= Auth::user()->country->currency->code;
                                } else {
                                    if (Cookie::get('name')) {
                                        $val .= number_format(($product->price / Country::find(Cookie::get('name'))->currency->rate), 2) . ' ';

                                        $val .= Country::find(Cookie::get('name'))->currency->code;
                                    } else {

                                        $val .= $product->price . ' KWD';
                                    }
                                    //

                                }



                                $val .=  '</h6> </div>'
                                    . ' <div class="col-1 pad-0">'
                                    . '<a class="  circle " style="padding:5px 10px" id="delete-circle" href="'
                                    . route('remove.from.shopping.cart', [$product_details['product_id'], $product_details['product_height_id']]) . '">
  <i class="fas fa-times ">

</i></a>'
                                    . ' </div>'
                                    . ' </div>'
                                    . ' <hr>';
                            }
                        }
                    }
                }
            }
        }

        $cart_details = Session::get('cart_details');

        $val .= ' <h5 class="text-center">' . \Lang::get('site.subtotal');

        $val .= ' ';

        //            $cart_details['totalPrice']
        if (Auth::check()) {
            $val .= Auth::user()->getPrice($product->price) . ' ';
            $val .= Auth::user()->country->currency->code;
        } else {
            if (Cookie::get('name')) {
                $val .= number_format(($cart_details['totalPrice'] / Country::find(Cookie::get('name'))->currency->rate), 2) . ' ';

                $val .= Country::find(Cookie::get('name'))->currency->code;
            } else {
                $val .= $cart_details['totalPrice'] . ' KWD';
            }
            //

        }


        $val .= ''
            . '</h5> <hr>'
            . '</div>';

        if ($cart) {
            return $val;
        } else {

            $return_val =
                '<div id="cart-content" class="row"><div class="col-12 pad-0">'
                . '<h4 style="text-align: center;font-weight: bold">
                            السله فارغه
                            </h4>'
                . ' </div>'
                . ' <hr>';

            return $return_val;
        }
    }


    public function reduceFromCart(Request $request)
    {
        //        Session::forget('cart');
        //        Session::forget('cart_details');
        //        return  response()->json([
        //            'success' => false,
        //            'msg' => 'Quantity Requested not Available of this item !'
        //        ]);
            // dd($request->all());
        $product_id = $request->product_id;
        $product_height_id = $request->product_height_id;
        $operation = $request->operation;

        //        Session::forget('cart_details');

        $cart = Session::get('cart');

        //        foreach ($cart as $cart_item){
        //            if($cart_item == $cart[$product_id]){
        //                foreach ($cart_item as $key => $value)
        //            }
        //        }
        $item = $cart[$product_id][$product_height_id];
        $quantity = $item['quantity'];
        $product = Product::find($product_id);

        $price = $product->price;
        // dd($cart,$item,$product->basic_category->type);
        $cart_details = Session::get('cart_details');

        $cart_details_quantity = $cart_details['totalQty'];
        $cart_details_price = $cart_details['totalPrice'];
        //        $total_price = $quantity * $price;
        //TODO :: GET OPERATION
        //TODO :: IF OPERATION 1 GET QUANTITY ADD TO QUANTITY

        if ($operation > 0) {
            //IF QUANTITY >= CURRENT PLUS ONE
            if($product->basic_category->type ==1 ){
                $prod_height = ProdHeight::where('product_id',$product_id)->where('height_id',0)->first();
            }
            else{
                $prod_height = ProdHeight::find($product_height_id);
            }
            // dd($prod_height->quantity);
            if ($prod_height->quantity < ($quantity + 1)) {
                return  response()->json([
                    'success' => false,
                    'msg' => 'Quantity Requested not Available of this item !'
                ]);
            }

            $cart[$product_id][$product_height_id]['quantity'] = $cart[$product_id][$product_height_id]['quantity']  + 1;
            $cart_details['totalQty'] = $cart_details['totalQty'] + 1;
            $cart_details['totalPrice'] = $cart_details['totalPrice'] + $price;
        } elseif ($operation < 0) {
            //TODO :: IF OPERATION -1 GET QUANTITY SUB FROM QUANTITY OR REMOVE

            if ($quantity > 1) {
                $cart[$product_id][$product_height_id]['quantity'] =  $cart[$product_id][$product_height_id]['quantity'] - 1;

                $cart_details['totalQty'] = $cart_details['totalQty'] - 1;
                $cart_details['totalPrice'] = $cart_details['totalPrice'] -  $price;
            } else {
                unset($cart[$product_id][$product_height_id]);

                $cart_details['totalQty'] = $cart_details['totalQty'] - $quantity;
                $cart_details['totalPrice'] = $cart_details['totalPrice'] - ($quantity * $price);
            }
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Error Occur !'
            ]);
        }


        Session::put('cart', $cart);

        Session::put('cart_details', $cart_details);

        return   response()->json([
            'success' => true,
            'msg' => 'تم بنجاح !'
        ]);

        ////        array_splice($cart , $item);
        //        unset($cart[$product_id][$product_height_id]);
        //
        //        if (count($cart[$product_id]) < 1) {
        //            unset($cart[$product_id]);
        //        }
        //
        //        Session::put('cart', $cart);
        //

        //
        //        $cart_details['totalQty'] = $cart_details_quantity - $quantity;
        //        $cart_details['totalPrice'] = $cart_details_price - $total_price;
        //
        //        Session::put('cart_details', $cart_details);
        //
        //        Alert::success('Removed Successfully !!', '');
        //        return redirect()->back();
    }


    public function removeFromShoppingCart($product_id, $product_height_id)
    {

        //        dd($request);


        //GET ITEM AND IF THE QUANTITY EQUALS OR MORE CALL REMOVE CART
        $cart = Session::get('cart');

        //        foreach ($cart as $cart_item){
        //            if($cart_item == $cart[$product_id]){
        //                foreach ($cart_item as $key => $value)
        //            }
        //        }
        $item = $cart[$product_id][$product_height_id];



        $quantity = $item['quantity'];

        $product = Product::find($product_id);

        $price = $product->price;

        $total_price = $quantity * $price;
        //        array_splice($cart , $item);
        unset($cart[$product_id][$product_height_id]);

        if (count($cart[$product_id]) < 1) {
            unset($cart[$product_id]);
        }

        Session::put('cart', $cart);

        $cart_details = Session::get('cart_details');

        $cart_details_quantity = $cart_details['totalQty'];
        $cart_details_price = $cart_details['totalPrice'];

        $cart_details['totalQty'] = $cart_details_quantity - $quantity;
        $cart_details['totalPrice'] = $cart_details_price - $total_price;

        Session::put('cart_details', $cart_details);


        // GET TOTAL PRICE


        toast('Removed Successfully !!');

        return redirect()->back();
    }

    public function getCities(Request $request)
    {


        //        if (Auth::check()) {
        //
        //            return response()->json([
        //                'success' => true,
        //                'cities' => Auth::user()->country_id
        //            ]);
        //
        //            $country = Country::find(Auth::user()->country_id);
        //
        //            if (!$country) {
        //                return response()->json([
        //                    'success' => false,
        //                    'msg' => 'Can not find Country  !!'
        //                ]);
        //            }
        //
        //            $val = '';
        //
        //            foreach ($country->cities as $city) {
        //                $val .= '<option value="' . $city->id . '">' . $city->name_en . ' - ' . $city->name_ar . '</option>';
        //            }
        //
        //            return response()->json([
        //                'success' => true,
        //                'cities' => $val
        //            ]);
        //
        //        } else {
        $country_id = $request->country;

        if (!$country_id) {
            return response()->json([
                'success' => false,
                'msg' => 'Please Choose Country  !!'
            ]);
        }
        $country = Country::find($country_id);
        if (!$country) {
            return response()->json([
                'success' => false,
                'msg' => 'Can not find Country  !!'
            ]);
        }

        $val = '';
        $delivery = '';

        if (app()->getLocale() == 'en') {
            foreach ($country->cities as $city) {
                $val .= '<option value="' . $city->id . '">' . $city->name_en .  '</option>';
                //                $delivery .= '<p> '.$city->delivery_period .'</p>';

            }
        } else {
            foreach ($country->cities as $city) {
                $val .= '<option value="' . $city->id . '">' .  $city->name_ar . '</option>';
                //                $delivery .= '<p> '.$city->delivery_period .'</p>';

            }
        }
        return response()->json([
            'success' => true,
            'cities' => $val,
            //                'delivery' => $delivery
        ]);
        //        }



    }

    public function getDelivery(Request $request)
    {
        //        dd($request->all());
        $city_id = $request->city;

        if (!$city_id) {
            return response()->json([
                'success' => false,
                'msg' => 'Please Choose City  !!'
            ]);
        }
        $city = City::find($city_id);
        if (!$city) {
            return response()->json([
                'success' => false,
                'msg' => 'Can not find City  !!'
            ]);
        }


        //---------------------TRANSLATE  -----------------//
        $delivery = '';

        if (app()->getLocale() == 'en') {


            $val = '';

            //<p style="text-align: center;color: white;font-weight: bolder;font-size: 18px">* You Should Know that </p>
            //';

            //        foreach ($city->cities as $city1) {
            //            $val .= '<option value="' . $city1->id . '">' . $city->delivery_period . ' - ' . $city->name_ar . '</option>';
            //            $delivery .= '<p style="color: white;text-align: center;"> The delivery period for '. '<strong> '.$city->name_en.' : '.$city->delivery_period.' Days </strong></p>';
            $delivery .= $city->delivery_period . ' Days';
            //            $delivery .= '<p style="text-align: center;color: white"> The delivery cost for '. '<strong>'.$city->name_en.' : ';


            if (Auth::check()) {
                //                $delivery .= Auth::user()->getPrice($city->delivery).' ';
                //                $delivery .= Auth::user()->country->currency->code;
                $val = Auth::user()->getPrice($city->delivery) . ' ';
                $val .= Auth::user()->country->currency->code;
            } else {
                if (Cookie::get('name')) {
                    //                    $delivery .= number_format(($city->delivery / Country::find(Cookie::get('name'))->currency->rate),2) . ' ';

                    //                    $delivery .= Country::find(Cookie::get('name'))->currency->code;

                    $val = number_format(($city->delivery / Country::find(Cookie::get('name'))->currency->rate), 2) . ' ';

                    $val .= Country::find(Cookie::get('name'))->currency->code;
                } else {

                    //                    $delivery .=$city->delivery. ' KWD';
                    $val = $city->delivery . ' KWD';
                }
                //

            }
            //            $delivery .='</strong></p></div>';


        } else {

            //        $val = '';
            //            $delivery = '<div style="width: 100%;background-color: #d420da;padding:10px;margin-bottom: 10px" >

            //<p style="text-align: center;color: white;font-weight: bolder;font-size: 18px">* يرجي العلم بأنه</p>
            //';

            //        foreach ($city->cities as $city1) {
            //            $val .= '<option value="' . $city1->id . '">' . $city->delivery_period . ' - ' . $city->name_ar . '</option>';
            //            $delivery .= '<p style="color: white;text-align: center;"> مدة التوصيل لمدينة '. '<br><strong>' .$city->name_ar.' : '.$city->delivery_period.' ايام </strong></p>';
            $delivery .= $city->delivery_period . ' ايام ';
            //            $delivery .= '<p style="text-align: center;color: white"> تكلفة التوصيل لمدينة '. '<br><strong>' .$city->name_ar.' : ';


            if (Auth::check()) {
                //                $delivery .= Auth::user()->getPrice($city->delivery).' ';
                //                $delivery .= Auth::user()->country->currency->code;
                $val = Auth::user()->getPrice($city->delivery) . ' ';
                $val .= Auth::user()->country->currency->code;
            } else {
                if (Cookie::get('name')) {
                    //                    $delivery .= number_format(($city->delivery / Country::find(Cookie::get('name'))->currency->rate),2) . ' ';

                    //                    $delivery .= Country::find(Cookie::get('name'))->currency->code;
                    $val = number_format(($city->delivery / Country::find(Cookie::get('name'))->currency->rate), 2) . ' ';

                    $val .= Country::find(Cookie::get('name'))->currency->code;
                } else {

                    //                    $delivery .=$city->delivery. ' KWD';
                    $val = $city->delivery . ' KWD';
                }
                //

            }
            //            $delivery .='</strong></p></div>';

        }

        $total_value = 0;
        $val2 = 0;
        $val3 = 0;
        $total_value_string = 0;
        if (Auth::check()) {
            $val2 = Auth::user()->getPrice($city->delivery);
            $val3 = (Auth::user()->getPrice($request->total_value));
            $total_value = $val2 + $val3;
            $total_value_string = ' ' . $total_value . ' ' . Auth::user()->country->currency->code;
            //            $total_value .= Auth::user()->country->currency->code;

        } else {
            if (Cookie::get('name')) {
                $val2 = ($city->delivery / Country::find(Cookie::get('name'))->currency->rate);
                $val3 = $request->total_value / Country::find(Cookie::get('name'))->currency->rate;
                $total_value = number_format($val2 + $val3, 2);
                $total_value_string = $total_value . ' ' . Country::find(Cookie::get('name'))->currency->code;
            } else {

                $total_value = $request->total_value + $city->delivery;
                $total_value_string = $total_value . " KWD ";
            }

            //            dd($total_value_string);
            //

        }

        //---------------------------------------------------------------//
        //        $delivery .= '<p> '.$city->delivery_period .'</p>';

        //        }
        return response()->json([
            'success' => true,
            'ship' => $val,
            'total_value' => $total_value_string,
            'delivery' => $delivery
        ]);
        //        }

    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function store(Request $request)
    {

        //ORDER STORE
        $messeges = [

            'name.required' => "اسم العميل مطلوب",
            'email.required' => "البريد الإلكتروني للعميل مطلوب",
            'email.email' => "يرجي كتابة البريد الالكتروني بشكل صحيح",
            'country_id.required' => "يرجي إختيار الدوله",
            'city_id.required' => "يرجي إختيار المدينه",
            'phone.required' => "يرجي إدخال رقم الهاتف",
            'phone.max' => "رقم الهاتف يجب ألا يزيد عن 11 رقم",
            'phone.min' => "رقم الهاتف يجب ألا يقل عن 3 أرقام",
            'address1.required' => "يرجي إدخال العنوان الاول",
            //            'postal_code.required' => "يرجي إدخال الرمز البريدي",

        ];

        $validator = Validator::make($request->all(), [

            'name' => ['required'],

            // 'email' => ['required', 'email'],

            'country_id' => ['required'],

            'city_id' => ['required'],

            'phone' => ['required', 'max:11', 'min:3'],

            'address1' => ['required'],

            //            'postal_code' => ['required'],

        ], $messeges);


        if ($validator->fails()) {
            Alert::error($validator->errors()->first(), '');
            return back();
        }
        if ($request->email == null) {
            $request->merge(['email' => 'no@gmail.com']);
        }


        //        dd($request);

        $cart_details = Session::get('cart_details');

        $city = City::find($request['city_id']);



        $variation = str_replace("+", "", $request['phone']);
        $variation2 = str_replace("-", "", $variation);

        $request->merge([
            'total_price' => $cart_details['totalPrice'] + $city->delivery - Session::get('coupon')['discount'],
            'total_quantity' => $cart_details['totalQty'],
            'phone' => $variation2
        ]);
        //MAKE ORDER TABLE

        //ADD TO TABLE




        $order = Order::create($request->except('_token'));

        //    dd($order);

        if (!$order) {
            Alert::error('Order Not Completed an error occur ', '');

            return back();
        }
        //        dd($order);

        //CHECK IF QUANTITIES FROM CART IS AVAILABLE AND THEN MAKE PAYMENT

        $cart = Session::get('cart');

        //REACH HEIGHT AND ABSTRACT THE QUANTITY

        foreach ($cart as $cart_item) {
            foreach ($cart_item as $item) {
                $cat_type=(Product::find($item['product_id']))->basic_category->type;
                if($cat_type == 1){
                    $height = ProdHeight::where("product_id",$item['product_id'])->where('height_id',0)->first();
                }else{

                    $height = ProdHeight::find($item['product_height_id']);
                }
                if ($height->quantity >= $item['quantity']) {
                    $height->quantity = $height->quantity - $item['quantity'];
                    $height->save();

                    $item['order_id']  = $order->id;

                    OrderItem::create($item);

                    $b = BestSeller::where([
                        'product_id' => $item['product_id']
                    ])->first();

                    if (!$b) {
                        $be = new BestSeller();
                        $be->product_id = $item['product_id'];
                        $be->rate = 1;
                        $be->save();
                    } else {
                        $b->rate = $b->rate + 1;
                        $b->save();
                    }

                    BestSeller::firstOrCreate([
                        'product_id' => $item['product_id']
                    ])->touch();
                } else {

                    $msg = ' المنتج ';
                    $msg .= Product::find($item['product_id'])->title_en;
                    $msg .=  ' لا يتوفر منه العدد المطلوب في المقاس ';
                    $msg .=  ProdHeight::find($item['product_height_id'])->height->name;
                    $msg .=  ' مع الحجم ';
                    $msg .=  ProdSize::find($item['product_size_id'])->size->name;
                    $msg .=  '    يرجي اختبار مقاسات اخري';

                    Alert::error($msg, '');
                    return back();
                }
            }
        }

        // Session::forget('cart');
        // Session::forget('cart_details');


        $data = $this->makePayment(\Illuminate\Support\Facades\Request::merge(['order_id' => $order->id]));

        //        dd($data);
        $json = json_decode($data->getContent(), true);

        $success =  $json['success'];

        if (!$success) {
            Alert::error($json['msg'], '');

            return back();
        }
        //mail here
        //        Mail::send('email.donePay',['name' => $request->name,'order_id'=>$order->id,'total_price'=>$request->total_price,'total_quantity'=>$request->total_quantity,'invoice_link'=>$order->invoice_link], function($message) use($request,$order){
        //            $message->to($request->email)
        //                ->from('sales@easyshop-qa.com', 'Example')
        //            ->subject('Pay done');
        //        });


        return redirect($json['link']);

        //Take to my my Fatoorah

        //when get back forget session

        //view orders for user and admin

        //        Session::forget('cart');
        //        Session::forget('cart_details');


        //PAYMENT


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function makePayment(Request $request): \Illuminate\Http\JsonResponse
    {

        if (!$request->order_id) {
            response()->json(
                [
                    'success' => false,
                    'msg' => 'Data Not Match Any Order !'
                ]
            );
        }

        $order = Order::find($request->order_id);

        if (!$order) {
            response()->json(
                [
                    'success' => false,
                    'msg' => 'Order is not exist !'
                ]
            );
        }



        //        $user_id = $order->user_id;
        //
        //        $user = User::find($user_id);
        //
        //
        //        if(!$user){
        //            return  response()->json(
        //                [
        //                    'success' =>false,
        //
        //                    'msg' => 'User is not exists',
        //
        //                ]
        //            );
        //        }


        //TODO :: GET USER PHONE

        $country_code = $order->country->code;
        $phone = ($order->phone);
        $name = ($order->name) ?: '';
        $email = ($order->email) ?: '';

        //        TODO :: VALIDATION FOR BOOKING  IF  MONEY ALREADY PAID


        /* ------------------------ Configurations ---------------------------------- */
        //Test


        // $apiURL = 'https://apitest.myfatoorah.com';
        // $apiKey = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';
        //Live
        $apiURL = 'https://api.myfatoorah.com';
        $apiKey = 'bOP13e6rFDKxF8Q1GSGwrj327hMz4Pp7FEipItzvOVvmayOCblo1FDh2UV5uHGvgQatGWtPJGl68PQQJ4a3X3Xfp8VvSISvECda7uFZrJoo-JRBWbuGa4VLuKCTSaa1unjBoW8ywv1BL-dBPo3gMdjHovkbyDj8q2YRu_sH_IEMpKMeTUPkdeJI0l0DfDNTjqfj8iojDTZkfvOizJ4nGq2MOhBNHNsMdDcSX5yxfLv8ZJwqv_DVrZbfUxoVXX6kgHKMQcu7HBhqiO60K6Riujviasephrsa8k7qnylOZbLbEaSIXRuc7C_nRvvmUwqbw9HHG00gWAePF5KHsuuIquufKqfBZbIdbMWrM6bAzZkKSxCMIvM0adIJjzMWkI5SJc82ujVo76VRMpNvL-hx9cobZSN5AU1GklZXDCiTsITAo-AD60R3Q9M98YDYZVdihDc5lfGarVnEIMfqoz5qWI7m8te7Lj-V8oyFCpxZlTVa3SET7htHL9FvA_iQ1rivns7JnKwezb7l6jPi6uihYJmdQBbfqCJ27gkOanKQ7mBGPFscfyFX0e0dL5Cp7vhi3akde0GCtz9IBUkmXHU6bGVroP08agaxH92Y8Oxs_uTaAj87dNW4INKfwLur6Oepcy9egvLG0IYovcPhvXzw1fPEeXqDvL1vzmWNSycuMNdSyfBvz'; //Live token value to be placed here: https://myfatoorah.readme.io/docs/live-token


        /* ------------------------ Call SendPayment Endpoint ----------------------- */
        //Fill customer address array
        /* $customerAddress = array(
          'Block'               => 'Blk #', //optional
          'Street'              => 'Str', //optional
          'HouseBuildingNo'     => 'Bldng #', //optional
          'Address'             => 'Addr', //optional
          'AddressInstructions' => 'More Address Instructions', //optional
          ); */

        //Fill invoice item array
        /* $invoiceItems[] = [
          'ItemName'  => 'Item Name', //ISBAN, or SKU
          'Quantity'  => '2', //Item's quantity
          'UnitPrice' => '25', //Price per item
          ]; */

        $order_item = OrderItem::where('order_id', $request->order_id)->get();
        $delivery_cost = City::find($order->city_id);
        // dd($delivery_cost);

        $invoiceItems = array();
        if (Session::get('coupon')) {
            $coupon = Session::get('coupon');
            // dd($coupon);
            foreach ($order_item as $item) {

                // dd(Product::find($item->product_id)->price*$coupon['percentage']/100);
                $product_price=Product::find($item->product_id)->price*$coupon['percentage']/100;
                array_push($invoiceItems, [
                    'ItemName'  => Product::find($item->product_id)->title_ar, //ISBAN, or SKU
                    'Quantity'  => $item->quantity, //Item's quantity
                    'UnitPrice' => number_format($product_price, 3, '.', ''), //Price per item
                ]);
            }

            // dd("Coupon is",$coupon->discount * -1);
            // array_push($invoiceItems, [
            //     'ItemName'  => "Coupon discount", //ISBAN, or SKU
            //     'Quantity'  => 1, //Item's quantity
            //     'UnitPrice' => number_format($coupon['discount'], 3, '.', ''), //Price per item
            // ]);
        }else{
            foreach ($order_item as $item) {
                array_push($invoiceItems, [
                    'ItemName'  => Product::find($item->product_id)->title_ar, //ISBAN, or SKU
                    'Quantity'  => $item->quantity, //Item's quantity
                    'UnitPrice' => number_format(Product::find($item->product_id)->price, 3, '.', ''), //Price per item
                ]);
            }
        }

        array_push($invoiceItems, [
            'ItemName'  => "Shippng cost", //ISBAN, or SKU
            'Quantity'  => 1, //Item's quantity
            'UnitPrice' => number_format($delivery_cost->delivery, 3, '.', ''), //Price per item
        ]);
        // dd(Session::get('coupon'));

        // dd(Session::get('cart_details'),$invoiceItems);






        //Fill POST fields array
        $postFields = [
            //Fill required data
            'NotificationOption' => 'Lnk', //'SMS', 'EML', or 'ALL'
            'InvoiceValue' => $order->total_price,
            'CustomerName' => $name,
            //Fill optional data
            'DisplayCurrencyIso' => 'KWD',
            'MobileCountryCode'  => $country_code,
            'CustomerMobile'     => $phone,
            'CustomerEmail'      => $email ?? "no@gmail.com",
            'CallBackUrl'        => 'http://127.0.0.1:8000/payment_callback',
            'ErrorUrl'           =>  'http://127.0.0.1:8000/payment_error', //or 'https://example.com/error.php'
            //'Language'           => 'en', //or 'ar'
            //            'CustomerReference'  => $order->id,
            //            'CustomerCivilId'    => $order->national_id,
            //'UserDefinedField'   => 'This could be string, number, or array',
            //'ExpiryDate'         => '', //The Invoice expires after 3 days by default. Use 'Y-m-d\TH:i:s' format in the 'Asia/Kuwait' time zone.
            //'SourceInfo'         => 'Pure PHP', //For example: (Laravel/Yii API Ver2.0 integration)
            //            'CustomerAddress'    => $order->address1,
            //            'InvoiceItems'       => $order->order_items,
            'InvoiceItems'       => $invoiceItems,

        ];

        //Call endpoint
        $data = $this->sendPayment($apiURL, $apiKey, $postFields);

        //You can save payment data in database as per your needs
        $invoiceId = $data->InvoiceId;
        $paymentLink = $data->InvoiceURL;

        $order->invoice_id = $invoiceId;
        $order->invoice_link = $paymentLink;
        $order->save();


        return response()->json(
            [
                'success' => true,
                'link' => $paymentLink,
                'data' => $data,
                'order' => $order
            ]
        );
    }


    public function sendPayment($apiURL, $apiKey, $postFields)
    {
        $json = $this->callAPI("$apiURL/v2/SendPayment", $apiKey, $postFields);
        return $json->Data;
    }


    public  function handleError($response)
    {

        $json = json_decode($response);
        if (isset($json->IsSuccess) && $json->IsSuccess == true) {
            return null;
        }

        //Check for the errors
        if (isset($json->ValidationErrors) || isset($json->FieldsErrors)) {
            $errorsObj = isset($json->ValidationErrors) ? $json->ValidationErrors : $json->FieldsErrors;
            $blogDatas = array_column($errorsObj, 'Error', 'Name');

            $error = implode(', ', array_map(function ($k, $v) {
                return "$k: $v";
            }, array_keys($blogDatas), array_values($blogDatas)));
        } else if (isset($json->Data->ErrorMessage)) {
            $error = $json->Data->ErrorMessage;
        }

        if (empty($error)) {
            $error = (isset($json->Message)) ? $json->Message : (!empty($response) ? $response : 'API key or API URL is not correct');
        }

        return $error;
    }

    public   function callAPI($endpointURL, $apiKey, $postFields = [], $requestType = 'POST')
    {

        $curl = curl_init($endpointURL);
        curl_setopt_array($curl, array(
            CURLOPT_CUSTOMREQUEST => $requestType,
            CURLOPT_POSTFIELDS => json_encode($postFields),
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $apiKey", 'Content-Type: application/json'),
            CURLOPT_RETURNTRANSFER => true,
        ));

        $response = curl_exec($curl);
        $curlErr = curl_error($curl);

        curl_close($curl);

        if ($curlErr) {
            //Curl is not working in your server
            die("Curl Error: $curlErr");
        }

        $error = $this->handleError($response);
        if ($error) {
            die("Error: $error");
        }

        return json_decode($response);
    }


    public function getPaymentStatus($payment_id): \Illuminate\Http\JsonResponse
    {


        /* ------------------------ Configurations ---------------------------------- */

        //Test
        // $apiURL = 'https://apitest.myfatoorah.com';
        // $apiKey = 'rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL';

        //Live
        $apiURL = 'https://api.myfatoorah.com';
        $apiKey = 'bOP13e6rFDKxF8Q1GSGwrj327hMz4Pp7FEipItzvOVvmayOCblo1FDh2UV5uHGvgQatGWtPJGl68PQQJ4a3X3Xfp8VvSISvECda7uFZrJoo-JRBWbuGa4VLuKCTSaa1unjBoW8ywv1BL-dBPo3gMdjHovkbyDj8q2YRu_sH_IEMpKMeTUPkdeJI0l0DfDNTjqfj8iojDTZkfvOizJ4nGq2MOhBNHNsMdDcSX5yxfLv8ZJwqv_DVrZbfUxoVXX6kgHKMQcu7HBhqiO60K6Riujviasephrsa8k7qnylOZbLbEaSIXRuc7C_nRvvmUwqbw9HHG00gWAePF5KHsuuIquufKqfBZbIdbMWrM6bAzZkKSxCMIvM0adIJjzMWkI5SJc82ujVo76VRMpNvL-hx9cobZSN5AU1GklZXDCiTsITAo-AD60R3Q9M98YDYZVdihDc5lfGarVnEIMfqoz5qWI7m8te7Lj-V8oyFCpxZlTVa3SET7htHL9FvA_iQ1rivns7JnKwezb7l6jPi6uihYJmdQBbfqCJ27gkOanKQ7mBGPFscfyFX0e0dL5Cp7vhi3akde0GCtz9IBUkmXHU6bGVroP08agaxH92Y8Oxs_uTaAj87dNW4INKfwLur6Oepcy9egvLG0IYovcPhvXzw1fPEeXqDvL1vzmWNSycuMNdSyfBvz'; //Live token value to be placed here: https://myfatoorah.readme.io/docs/live-token


        /* ------------------------ Call getPaymentStatus Endpoint ------------------ */
        //Inquiry using paymentId
        $keyId = $payment_id;
        $KeyType = 'paymentId';

        //Inquiry using invoiceId
        //        $keyId   = $invoice_id;
        //        $KeyType = 'invoiceId';

        //Fill POST fields array
        $postFields = [
            'Key' => $keyId,
            'KeyType' => $KeyType
        ];
        //Call endpoint
        $json = $this->callAPI("$apiURL/v2/getPaymentStatus", $apiKey, $postFields);

        //Display the payment result to your customer
        return response()->json($json->Data);
    }

    //////
    public function callBackUrl(Request $request)
    {
        //        dd($request->all());
        $payment_id = $request->paymentId;


        $invoice_data =  $this->getPaymentStatus($payment_id);
        //        return $invoice_data;
        $invoice_id = $invoice_data->original->InvoiceId;
        $invoice_status = $invoice_data->original->InvoiceStatus;

        //ORDER

        $order = Order::where('invoice_id', $invoice_id)->first();

        if (!$order) {
            //                    dd($request->all());

            Alert::error('Order is not Exist !');
            return redirect()->route('/');
        }
        session()->forget('coupon');

        $order->status = 1;
        $order->save();
        /*
             * order with order_id and price is price paid successfully and delivery is happening
             *
             *
             * */
        // Mail::send('email.donePay', ['name' => $order->name, 'order_id' => $request->paymentId, 'total_price' => $order->total_price, 'total_quantity' => $order->total_quantity, 'invoice_link' => $order->invoice_link], function ($message) use ($order) {
        //     $message->to($order->email)
        //         ->from('sales@easyshop-qa.com', 'Sara Merdas')
        //         ->subject('Pay done');
        // });

        //        Mail::send('email.donePay',['name' => $request->name,'order_id'=>$order->id,'total_price'=>$request->total_price,'total_quantity'=>$request->total_quantity], function($message) use($request,$order){
        //            $message->to($request->email)
        //                ->from('sales@easyshop-qa.com', 'Example')
        //                ->subject('Pay done');
        //        });
        //TODO ::MAIL IS HERE

        Session::forget('cart');
        Session::forget('cart_details');

        Alert::success('Payment Completed Successfully !', '');


        return redirect()->route('/')->with(['order' => $order]);
        //ORDER 1


        //ALERT


        //HOME

    }

    public function errorUrl(Request $request)
    {
        // dd($request->all());
        $payment_id = $request->paymentId;



        $invoice_data =  $this->getPaymentStatus($payment_id);
        //        return $invoice_data;
        $invoice_id = $invoice_data->original->InvoiceId;
        $invoice_status = $invoice_data->original->InvoiceStatus;

        $order = Order::where('invoice_id', $invoice_id)->first();
        // dd($order);
        session()->forget('coupon');


        Alert::error('Payment Not Completed !', '');

        return redirect()->route('/')->with(['order' => $order]);;
    }


    public function payNow($order_id)
    {

        $order = Order::find($order_id);

        if (!$order) {
            Alert::error('Order is not Exist', '');

            return back();
        }

        if ($order->invoice_link && ($order->invoice_link != null)) {
            if ($order->status != 0) {
                Alert::error('Payment Can not be completed, Maybe you already paid for this', '');

                return back();
            }
            return redirect($order->invoice_link);
        }

        $data = $this->makePayment(\Illuminate\Support\Facades\Request::merge(['order_id' => $order->id]));

        $json = json_decode($data->getContent(), true);

        $success =  $json['success'];

        if (!$success) {
            Alert::error($json['msg'], '');

            return back();
        }
        //mail here
        //        Mail::send('email.donePay',['name' => $request->name,'order_id'=>$order->id,'total_price'=>$request->total_price,'total_quantity'=>$request->total_quantity,'invoice_link'=>$order->invoice_link], function($message) use($request,$order){
        //            $message->to($request->email)
        //                ->from('sales@easyshop-qa.com', 'Example')
        //            ->subject('Pay done');
        //        });


        return redirect($json['link']);
    }
}
