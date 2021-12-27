<?php

namespace App\Http\Controllers\front;

use App\BasicCategory;
use App\Cart;
use App\Post;
use App\Category;
use App\ContactUs;
use App\Country;
use App\Http\Controllers\Controller;
use App\Pages;
use App\ProdImg;
use App\Product;
use App\Slider;
use App\User;
use App\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

//use Session;


class homeController extends Controller
{
    public function home()
    {
        //        dd(Cookie::get('name'));
        //TODO :: IF COOKIE IS NULL SET COOKIE NAME
        if (!Cookie::get('name')) {
            $country = Country::first();
            Cookie::queue('name', $country->id, 43829);
        } else {

            //            Cookie::queue(Cookie::forget('name'));
            //dd('ok');
            $c = Country::find(Cookie::get('name'));
            if (!$c) {
                $country_new = Country::first();
                Cookie::queue('name', $country_new->id, 43829);
            }
        }




        //        return  $request->paymentId;
        $sliders = Slider::all();
        $new_arrive = Product::orderBy('created_at', 'desc')->where('new', 1)->where('appearance', 1)
            ->offset(0)->limit(8)->get();
        $offers = Product::orderBy('created_at', 'desc')->where('has_offer', 1)->where('appearance', 1)
            ->offset(0)->limit(8)->get();
        $best_sell = Product::orderBy('created_at', 'desc')->where('best_selling', 1)->where('appearance', 1)
            ->offset(0)->limit(5)->get();
        $posts = Post::orderBy('created_at', 'desc')->where('appearance', 1)
            ->offset(0)->limit(3)->get();

        // dd($new_arrive);
        return view('front.index', compact('sliders', 'new_arrive', 'posts','offers','best_sell'));
    }

    public function account()
    {
        return view('front.account');
    }

    public function cart()
    {
        return view('front.cart');
    }
    public function post($id)
    {
        $post = Post::findOrfail($id);
        // dd($post);
        return view('front.post', compact('post'));
    }

    public function contactUs()
    {
        $best_sell = Product::orderBy('created_at', 'desc')->where('best_selling', 1)->where('appearance', 1)
        ->offset(0)->limit(5)->get();
        return view('front.contact_us',compact('best_sell'));
    }

    public function contactUsStore(Request $request)
    {

        $messeges = [

            'email.required' => "البريد الالكتروني مطلوب",
            'phone.required' => "رقم الهاتف مطلوب",
            'body.required' => "برجاء إدخال محتوي البريد",

        ];

        $validator = Validator::make($request->all(), [

            'email' => ['required'],
            'phone' => ['required'],
            'body' => ['required'],

        ], $messeges);


        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }


        $msg = ContactUs::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'subject' => $request['subject'],
            'body' => $request['body'],
        ]);

        if ($msg) {

            session()->flash('success', "success");
            if (session()->has("success")) {
                Alert::success('نجح', 'تم الأرسال');
            }
        }

        return redirect()->back();
    }

    public function category($type, $id)
    {
        //        $prod_img=ProdImg::where('product_id',$id)->first()->img;
        //        dd($prod_img);
        $sliders = Slider::all();

        if ($type == 1) {
            $last_views = Product::where('best_selling', 1)->where('basic_category_id', $id)->where('appearance', 1)->orderBy('updated_at',  'DESC')->take(3)->get();

            $category = BasicCategory::findOrFail($id);
        } else {
            $last_views = Product::where('best_selling', 1)->where('category_id', $id)->where('appearance', 1)->orderBy('updated_at',  'DESC')->take(3)->get();

            $category = Category::findOrFail($id);
        }

        if (!$category) {
            Alert::error('خطأ', 'هذا القسم غير متوفر حاليا');
            return back();
        }
        return view('front.category', compact('category', 'type', 'last_views','sliders'));
    }

    public function new_arrive()
    {


        $new_arrivals = Product::where('new', 1)->where('appearance', 1)->orderBy('updated_at',  'DESC')->get();
        // dd($new_arrivals);


        if (!$new_arrivals) {
            Alert::error('خطأ', ' غير متوفر حاليا');
            return back();
        }
        return view('front.new', compact('new_arrivals'));
    }
    public function offers()
    {


        $new_arrivals = Product::where('has_offer', 1)->where('appearance', 1)->orderBy('updated_at',  'DESC')->get();
        // dd($new_arrivals);


        if (!$new_arrivals) {
            Alert::error('خطأ', ' غير متوفر حاليا');
            return back();
        }
        return view('front.offer', compact('new_arrivals'));
    }

    public function checkout()
    {
        return view('front.checkout');
    }

    public function myaccount()
    {
        return view('front.myaccount');
    }

    //    public function myorder()
    //    {
    //        return view('front.myorder');
    //    }

    public function payment()
    {
        return view('front.payment');
    }

    public function policy()
    {
        $page = Pages::findOrFail(1);
        return view('front.policy', compact('page'));
    }

    public function product($id)
    {

        $product = Product::findOrFail($id);
        if (!$product) {
            abort(404);
        }

        View::firstOrCreate([
            'product_id' => $id
        ])->touch();

        return view('front.product', compact('product'));
    }

    public function wishlist()
    {
        return view('front.wishlist');
    }


    public function updateUser(Request $request, $id)
    {

        $messeges = [

            'name.required' => "اسم العميل مطلوب",
            //            'email.required' => "البريد الالكتروني مطلوب",
            'phone.required' => "رقم الهاتف مطلوب",
            'country.required' => "برجاء اختيار الدوله",
            //                'email.unique'=>" البريد الإلكتروني مربوط بحساب اخر",
            //            'email.email' => " البريد الإلكتروني غير صحيح يرجي إضافة رمز @",
            'password.required' => "كلمة المرور مطلوبه",
            'password.min' => "كلمة المرور يجب الا تقل عن 8 أحرف",

        ];

        $validator = Validator::make($request->all(), [

            'name' => ['required'],
            'phone' => ['required', 'unique:users,phone,' . $request['id']],
            'country' => ['required'],

            //            'email' => ['required', 'email', 'unique:users,email,' . $request['id']],
            //"qut"=> "required|Numeric",
            "password" => ['required', 'min:8'],


        ], $messeges);


        if ($validator->fails()) {
            Alert::error('خطأ', $validator->errors()->first());
            return back();
        }

        $user = User::findOrFail($request['id']);

        $user = $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'password_view' => $request['password'],
            'phone' => $request['phone'],
            'country_id' => $request['country'],
        ]);

        if ($user) {
            session()->flash('success', "success");
            if (session()->has("success")) {
                Alert::success('نجح', 'تم تحديث البيانات');
            }
        }

        return back();


        //        $uId = $request->user_id;
        //        User::updateOrCreate(['id' => $uId],['name' => $request->name, 'email' => $request->email]);
        //        if(empty($request->user_id))
        //            $msg = 'User created successfully.';
        //        else
        //            $msg = 'User data is updated successfully';
        //        return redirect()->route('users.index')->with('success',$msg);


    }



    //    public function home(){
    //        return view('front.index');
    //    }
    //    public function home(){
    //        return view('front.index');
    //    }
    //    public function home(){
    //        return view('front.index');
    //    }

    public function getAddToCart(Request $request, $id)
    {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);
        $request->session()->put('cart', $cart);
        //        dd($request->session()->get('cart'));
        //        return redirect()->route('/');
        return back();
    }

    public function getCart()
    {
        //        if (!Session::has('cart')) {
        //            return view('shop.shopping-cart');
        //        }
        //        $oldCart = Session::get('cart');
        //        $cart = new Cart($oldCart);
        return view('front.cart');
    }

    public function store(Request $request)
    {
        //        dd($request->all());
        dd($request->search);
        //        TODO :: MAKE SEARCH CAT = 1 OR SUB = 2  & NAME & ID (FOR SUB OR CAT)

        $id = intVal($request->id);
        $cat_or_sub = intVal($request->cat_or_sub);
        $search = $request->search;
        $items = null;
        if ($cat_or_sub) {
            // dd('test');
            if ($cat_or_sub == 1) {

                $items = Product::where(function ($q) use ($request) {
                    if ($request->search) {
                        $q->where('title_en', 'LIKE', '%' . $request->search . '%')->where('appearance', 1)->orWhere('title_ar', 'LIKE', '%' . $request->search . '%');
                    }

                    if ($request->id) {
                        //  $q->where('category_id', $request->id);
                    }
                })->orderBy("id", "desc")->paginate();
            }

            if ($cat_or_sub == 2) {
            // dd('test2');

                $items = Product::where(function ($q) use ($request) {
                    if ($request->search) {
                        $q->where('title_en', 'LIKE', '%' . $request->search . '%')->where('appearance', 1)->orWhere('title_ar', 'LIKE', '%' . $request->search . '%');
                    }
                    if ($request->id) {
                        //    $q->where('category_id', $request->id);
                    }
                })->orderBy("id", "desc")->paginate();
            }
        } else {
            dd('test3');

            $items = Product::where(function ($q) use ($request) {
                if ($request->search) {
                    $q->where('title_ar', 'LIKE', '%' . $request->search . '%')->where('appearance', 1)->orWhere('title_en', 'LIKE', '%' . $request->search . '%');
                }
                if ($request->id) {
                    // $q->where('category_id', $request->id);
                }
            })->orderBy("id", "desc")->paginate();
        }
        // dd($items);


        //        $value = '<div class="container border-main" style="width: 100%">
        //                    <div class="row row5" style="width: 100%">';
        //
        //        $value .= '<div class="col-12" style="display:flex;flex-wrap:wrap">';
        //        if($items->count() > 0){
        //            foreach ($items as $one) {
        //
        //                $value.= ' <div class="card col-12 col-md-4 col-lg-3 " style="margin: 10px ">'
        //                    . '  <h6 class="bg-main abs">ref:' . $one->id . '</h6>'
        //                    . '<a href="' . route("product", $one->id) . '">'
        //                    . ' <img height="200" src="' . asset($one->img) . '" class="card-img-top  " alt="..."> </a>'
        //                    . ' <div class="card-body">'
        //                    . '     <a href="' . route("product", $one->id) . '" class="card-text ">' . $one->title_en . '</a> '
        //                    . '<p class="card-title" href=""><b>KWD' . $one->price . '</b></p>'
        //
        //                    . '</div>'
        //                    . '<div class="row mr-0">'
        //                    . '<a href="' . "#". '" class="btn btn-dark border col-9">add to
        //                                cart</a>'
        //                    . '<div class="btn btn-light border col-3 heart text-center">'
        //                    . '<i   class="fas fa-heart heart-none"></i><i class="far fa-heart  heart-block"></i></div>
        //'
        //                    . '</div>' . '</div>'
        //                ;
        //
        //
        //            }
        //
        //        } else {
        //            $value.= '<p style="text-align: center ;width: 100%;margin: 30px" >
        //لا يوجد نتائج مطابقه
        //</p>';
        //        }
        //
        //        $value .=  '</div>'
        //            . '</div>'
        //            . '</div>';


        $value1 = ' <div class="container pad-0 ">

                            <br>
                            <h2 class="text-center  d-flex justify-content-between">
                                 <b></b>';
        $value1 .=                    '<span >'.\Lang::get('site.result').'</span>';
        $value1 .='<b></b>
                            </h2>
                             <br><br>

                                     <div class="row text-dir">

                                         <div class="col-12 pad-0">
					 <ul class="tablinks  row MyServices mr-0 pad-0 text-center" style="list-style-type: none">';
        if ($items->count() > 0) {
            foreach ($items as $one) {

                $value1 .= '<li class="in active  col-md-4 col-6 col-lg-3">'
                    . '<div class=" product relative">'
                    // . '<a href="#"  class="heart2 heart addToWishList text-dark" data-product-id="' . $one->id . '">'
                    // . '<i class="far fa-heart "></i>'
                    // . '</a>'
                    . '<a href="' . route('product', $one->id) . '" >'
                    . '<img src="' . asset('/storage/' . $one->img) . '"'
                    . 'onerror="this.onerror=null;this.src=' . asset('front/img/5.jpg') . '"'
                    . 'width="100%" class="image" style="margin:auto;" >'


                    . '</a>';
                    if(app()->getLocale() == 'en') {

                    $value1 .=  '<p class="mr-0 text-dir"><a href="' . route('product', $one->id) . '">' . $one->title_en . '</a> </p>'


                    . '<h6 class="mr-0 text-dir"><a href="' . route('product', $one->id) . '">' . $one->basic_category->name_en
                    . '-' .
                    $one->category->name_en . '</a></h6>'
                    . '<h5 class="mr-0 text-dir">' . \Lang::get('site.kwd').$one->price  ;
                    }
                    else{
                        $value1 .=  '<p class="mr-0 text-dir"><a href="' . route('product', $one->id) . '">' . $one->title_ar . '</a> </p>'


                        . '<h6 class="mr-0 text-dir"><a href="' . route('product', $one->id) . '">' . $one->basic_category->name_ar
                        . '-' .
                        $one->category->name_en . '</a></h6>'
                        . '<h5 class="mr-0 text-dir">' . \Lang::get('site.kwd').$one->price  ;
                    }
                    $value1 .= '</h5> </div>  </li>';
            }
        } else {
            $value1 .= '<p style="text-align: center ;width: 100%;margin: 30px" >
لا يوجد نتائج مطابقه
</p>';
        }


        $value1 .= '</ul>
            </div>
        </div>
        <br><br>
    </div>';


        return response()->json($value1);
    }

    public function checkCat(Request $request){
        // dd($request->all());
        $cat_id = $request->cat_id;
        $cat_type=BasicCategory::find($cat_id)->type;
        // dd($cat_type);
        return response()->json([
            'cat_type' => $cat_type
        ]);


    }

}
