@extends('layouts.front')
@section('title')
    @lang('site.home')

@endsection
@section('content')
    <!-----start  --->
    <!-----  ----->
    <div class="container " > <br><br>
        <h3 class="text-dir">@lang('site.shopping_cart')
        </h3>
        <div class="row pad text-center flx-dir">
            <br><br>
            @if(Session::has('cart'))
                @if(count(Session::get('cart')) < 1)

                 <br>
                        <p style="text-align: center;width: 100%;font-family: 'Arial';font-size: 18px;font-weight: bold">
                            السله فارغه
                        </p>
                @else

            <div class="col-lg-8 col-md-12 d-md-block ">

                <div class="table_block table-responsive dir-rtl" >
                    <table class="table ">
                        <thead class=" border-bottom">
                        <tr>
                            <th >@lang('site.product_image')</th>
                            <th >@lang('site.product_name')</th>
                            <th >@lang('site.size')</th>
                            <th >@lang('site.height')</th>
                            <th >@lang('site.price')</th>
                            <th >@lang('site.quantity')</th>
                            <th ></th>
                            <th >@lang('site.total_price')</th>

                        </tr>
                        </thead>
                        <tbody >
                        @if(count(Session::get('cart')) <1)
                            <tr>
                                <td colspan="8">
                                    <p style="text-align: center;font-family: 'Arial';font-size: 18px;font-weight: bold">
                                        السله فارغه
                                    </p>
                                </td>
                            </tr>

                        @else

                        @foreach(Session::get('cart') as $cart_parent)
                            @foreach($cart_parent as $key => $cart_child)
                            <tr class="border-bottom">
                            <td >
                                <a href="#">
                                    <img alt="T-shirts"
                                         src="{{asset('storage/'. \App\Product::find($cart_child['product_id'])['img'])}}"
                                         width="100px;">
                                </a>
                            </td>
                            <td >
                                <p class="">
                                    <br>
                                    <a href="#" class="main-color">{{  \App\Product::find($cart_child['product_id'])['title_en'] }} </a>
                                </p>


                            </td>
                                <td >
                                    <?php $id = (\App\Product::find($cart_child['product_id'])['basic_category_id']);
                                           $category=\App\BasicCategory::find($id)->type;
                                    ?>
                                    {{-- {{dd($category)}} --}}
                                    @if ($category !=1)
                                    <p class="">
                                        <br>
                                        <a href="#" class="main-color">{{  \App\ProdSize::find($cart_child['product_size_id'])->size->name ? : 0 }} </a>
                                    </p>
                                    @else
                                    <p>
                                        <br>
                                        -</p>
                                    @endif


                                </td>
                                <td >
                                    @if ($category !=1)

                                    <p class="">
                                        <br>
                                        <a href="#" class="main-color">{{  \App\ProdHeight::find($cart_child['product_height_id'])->height->name ? :0}} </a>
                                    </p>
                                    @else
                                    <p>
                                        <br>

                                        -</p>


                                    @endif



                                </td>
                            <td >
                                <br>
                                <span class="font-weight-bold">

                                    @auth()
                                        {{Auth::user()->getPrice(\App\Product::find($cart_child['product_id'])['price'] )}} {{ Auth::user()->country->currency->code}}

                                    @endauth
                                    @guest()
                                        @if(Cookie::get('name') )
                                            {{number_format(\App\Product::find($cart_child['product_id'])['price'] / App\Country::find(Cookie::get('name'))->currency->rate,2)}}
                                            {{App\Country::find(Cookie::get('name'))->currency->code}}
                                            {{-- @lang('site.kwd') --}}

                                        @else
                                            {{  \App\Product::find($cart_child['product_id'])['price'] }}
                                            @lang('site.kwd')
                                        @endif
                                    @endguest

                                    </span>
                            </td>
                                <td >
                                    <br>
                                    <span>
{{--                                        @foreach($cart_child as $k => $item)--}}
{{--                                            @if(\App\ProdHeight::find($k)->product_id == $key)--}}
                                        {{ $cart_child['quantity'] }}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
                                        &nbsp; @lang('site.items')</span>
                                </td>
                                <td class=" text-center">
                                <br>
                                    <form class=" product-count "
                                          method="post"
                                    style="display: flex;flex-direction: column;align-items: center"
                                    >
                                        @csrf
                                 <div class="form-group"
                                      style="display: flex;align-items: center;justify-content: center"
                                 >
                                     <a rel="nofollow" class="btn btn-default btn-minus" href="#" onclick="changeProduct(-1 ,{{$cart_child['product_id']}},{{$cart_child['product_height_id']}})" >&ndash;</a>
                                     <input type="number" style="width: 40px; border: 0;border-radius: 10px ; text-align:center"  class="count"
                                            value="{{$cart_child['quantity']}}" name="quantity">
                                     <a rel="nofollow" class="btn btn-default btn-plus" href="#" onclick="changeProduct(1 ,{{$cart_child['product_id']}},{{$cart_child['product_height_id']}})" >+</a>
                                 </div>
{{--                                    <button class="col-12 text-center"--}}
{{--                                            type="submit"--}}
{{--                                            style="background-color: transparent;border: 0;">--}}
{{--                                        <a   class=""><i class="fas fa-archive active"  ></i></a>--}}
{{--                                    </button>--}}
                                </form>

                            </td>
                            <td class="subtotal text-center" data-title="SUBTOTAL">
                                <br>
                                <p class="font-weight-bold">
                                    @auth()
                                        {{Auth::user()->getPrice($cart_child['quantity']*  \App\Product::find($cart_child['product_id'])['price'])}} {{ Auth::user()->country->currency->code}}

                                    @endauth
                                    @guest()
                                        @if(Cookie::get('name') )
                                            {{number_format($cart_child['quantity']*  (\App\Product::find($cart_child['product_id'])['price']/ App\Country::find(Cookie::get('name'))->currency->rate),2)}}
                                            {{App\Country::find(Cookie::get('name'))->currency->code}}
                                            {{-- @lang('site.kwd') --}}

                                        @else
                                            {{$cart_child['quantity']*  \App\Product::find($cart_child['product_id'])['price'] }}
                                            @lang('site.kwd')
                                        @endif
                                    @endguest

                                </p>
                            </td>
                        </tr>

                            @endforeach
                        @endforeach
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>

                @endif
            {{-- <div class="col-sm-12 d-md-none d-block" >
                @foreach(Session::get('cart') as $cart_parent)
                    @foreach($cart_parent as $key => $cart_child)
                <div class="row border  text-center"><br>
                    <a href="{{route('product' , $cart_child['product_id'])}}" class="col-12 "><br>
                        <img alt=" T-shirts" src="{{asset('storage/'. \App\Product::find($cart_child['product_id'])['img'])}}" width="100px;">
                    </a>
                    <br>

                    <a href="{{route('product' , $cart_child['product_id'])}}" class="main-color col-12">{{ \App\Product::find($cart_child['product_id'])['title_en'] }}</a>

                    <br>


                    <form class=" product-count col-12"
                          method="post"
                          style="display: flex;flex-direction: column;align-items: center"
                    >
                        @csrf
                        <div class="form-group"
                             style="display: flex;align-items: center;justify-content: center"
                        >
                            <a rel="nofollow" class="btn btn-default " href="#" onclick="changeProduct(-1 ,{{$cart_child['product_id']}},{{$cart_child['product_height_id']}})">&ndash;</a>
                            <input type="number" style="text-align:center ;width: 40px; border: 0;border-radius: 10px"
                                   class="count"
                                   value="{{$cart_child['quantity']}}" name="quantity">
                            <a rel="nofollow" class="btn btn-default " href="#"  onclick="changeProduct(1 ,{{$cart_child['product_id']}},{{$cart_child['product_height_id']}})">+</a>
                        </div>

                    </form>

                    <p class="col-12 font-weight-bold">total:
                        @auth()
                            {{Auth::user()->getPrice(\App\Product::find($cart_child['product_id'])['price'] )}} {{ Auth::user()->country->currency->code}}

                        @endauth

                    @guest()
                            @if(Cookie::get('name') )
                                {{number_format(\App\Product::find($cart_child['product_id'])['price'] / App\Country::find(Cookie::get('name'))->currency->rate,2) }}
                                {{App\Country::find(Cookie::get('name'))->currency->code}}

                            @else
                                {{ \App\Product::find($cart_child['product_id'])['price'] }}  @lang('site.kwd')

                            @endif
                        @endguest

                    </p>


                </div>
                    @endforeach
                @endforeach
            </div> --}}
            @else
                <div class="col-lg-8 col-md-12 d-md-block d-none">
                    <p>@lang('site.no_data')</p>
                </div>

                <div class="col-sm-12 d-md-none d-block">
                    <p>@lang('site.no_data')</p>

                </div>

                @endif



            <div class="col-lg-4   col-xs-12 border-right text-right">
                <div class="row">
                    <div class="container col-xs-12  ">

                        <h3 class="  border-bottom text-dir">  @lang('site.cart_details')</h3>
                        <p class="border-bottom" >@lang('site.total_price')<span class="float-left  font-weight-bold">
                                @auth()
                                    @if(Session::has('cart_details'))
                                    {{Auth::user()->getPrice(Session::get('cart_details')['totalPrice'] )}} {{ Auth::user()->country->currency->code}}
                                        @else
                                        0
                                    @endif
                                @endauth
                                @guest()


                                    @if(Cookie::get('name') )
                                        {{Session::has('cart_details')?number_format(Session::get('cart_details')['totalPrice'] / App\Country::find(Cookie::get('name'))->currency->rate,2):0}}
                                        {{App\Country::find(Cookie::get('name'))->currency->code}}
                                        {{-- @lang('site.kwd') --}}

                                    @else
                                        {{ Session::has('cart_details')?Session::get('cart_details')['totalPrice']:0 }} @lang('site.kwd')

                                    @endif
                                @endguest
                            </span></p>
                        <p class="border-bottom">@lang('site.shipping')<span class="float-left font-weight-bold">@lang('site.depend_city')</span></p>
                        <p class="border-bottom">@lang('site.total_price') <span class="float-left font-weight-bold">
                                @auth()
                                    @if(Session::has('cart_details'))
                                        {{Auth::user()->getPrice(Session::get('cart_details')['totalPrice'])}} {{ Auth::user()->country->currency->code}}
                                    @else
                                        0
                                    @endif
                                @endauth
                                @guest()
                                    @if(Cookie::get('name') )
                                        {{Session::has('cart_details')?number_format(Session::get('cart_details')['totalPrice']/ App\Country::find(Cookie::get('name'))->currency->rate,2):0}}
                                        {{App\Country::find(Cookie::get('name'))->currency->code}}
                                        {{-- @lang('site.kwd') --}}
                                    @else
                                        {{ Session::has('cart_details')?Session::get('cart_details')['totalPrice']:0 }} @lang('site.kwd')

                                    @endif
                                @endguest
                            </span></p>
                        <p class="active text-dir"> @lang('site.payment_receive')</p>
                        <a  href="{{route('checkout')}}" class="btn w-100 bg-main c-w ">@lang('site.checkout')</a>  <br><br>
                        <a  href="{{route('/')}}" class="btn w-100 bg-b c-w brdr">@lang('site.shopping')</a> <br><br>

                    </div>
                </div>


            </div>


        </div>
    </div>


    <!-----  ----->
    <!--- end  --->

@endsection

@section('script')

    <script>
        function changeProduct(operation ,productId,productHeightId){

            //TODO :: TOAST RUNNING
            // Swal.fire({
            //     title: '..... جاري التحميل ',
            //     html:
            //         '<progress id="file" value="32" max="100"> 32% </progress>',
            //     showConfirmButton:false,
            // })

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('reduce.from.cart') }}",
                method: 'post',
                data:{
                    operation:operation,
                    product_id:productId,
                    product_height_id: productHeightId,
                    _token:"{{csrf_token()}}",
                },
                success: function (result) {

                    console.log(result.success);
                    if(!result.success){
                        Swal.fire({
                            icon: 'error',
                            title: result.msg,
                                confirmButtonText:'Ok',
                            confirmButtonColor:'red',
                        })
                    }

                    window.location.reload();

                    //TODO :: CHECK RESULT
                },
                error: function (error) {
                    Swal.fire({
                        title: 'لم تكتمل العمليه ',
                        icon: '?',
                        confirmButtonColor: '#d76797',
                        position:'bottom-start',
                        showCloseButton: true,
                    })
                }
            });
        }
        $(document).ready(function () {
            // $('#subtract').on('click' , function () {
            //     alert('subtract')
            // })
            //
            // // name="quantity"
            // $('#add').on('click' , function () {
            //     alert('add')
            // })


        })
    </script>

@endsection
