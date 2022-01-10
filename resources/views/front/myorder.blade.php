@extends('layouts.front')
@section('title')
    @lang('site.home')

@endsection
@section('content')

    {{-- {{dd($orders[0]->order_item[0]->id)}} --}}
    <!-----start  --->
    <!-- end header -->
    <div class="container-fluid pad-0 m-3">
        <h1 class="title text-center">@lang('site.my_order') </h1>
    </div>
    <!-----  ----->
    <div class="container-fluid">
        <br><br>
        <div class="row dir-rtl">
            <div class=" text-center border col-md-2 col-sm-4">
                <div class="img-cover m-2"><img src="{{ asset('upload/avatar.png') }}" alt="" class="w-100"></div>
                <h6 class="name"> {{ Auth::user()->name }}</h6>
            </div>
            <div class="border col-sm-8 col-md-10 text-dir">
                <div class="row wellcome pad-top-25 p-4">
                    <div class="col-xs-12 col-sm-6 ">
                        <h4> @lang('site.hello') <span>
                                {{ Auth::user()->name }}
                            </span></h4>
                        <p>
                            @lang('site.welcome')
                        </p>
                    </div>
                    <div class=" col-xs-12 col-sm-6 pull-right">
                        <div class="row text-dir">
                            <div class="col-xs-12 col-sm-12">
                                <p class="my-orders">@lang('site.my_order') :</p>
                                <p> @lang('site.you_have')
                                    {{                                     Session::has('cart_details') ? Session::get('cart_details')['totalQty'] . ' items' : '' }}
                                    @lang('site.cc')</p>
                            </div>
                            <div class="col-xs-12 col-sm-12 view-cart">
                                <br><br>
                                <a href="{{ route('cart') }}" class="vh brdr btn">@lang('site.cart_details') <i
                                        class="fas fa-shopping-bag" style="font-size: 20px"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <br><br>
        </div>
    </div>

    <!-----  ----->

    <br><br>
    <div class="container-fluid pad-top-25">
        <div class="row  dir-rtl col-dir" style="display: flex">
            <div class="col-xs-3 col-3 col-md-2 left-menu row-dir" style="float:right">


                <a href="{{ route('myaccount') }}" class="icon-container">
                    <div class="">
                        <i class="fas fa-user"></i><br><span class="title-span">@lang('site.myaccount') </span>
                    </div>
                </a>
                <a href="{{ route('wishlist.view') }}" class="icon-container">
                    <div class=""><i class=" far fa-heart"></i><br><span
                            class="title-span">@lang('site.wishlist')</span></div>
                </a>
                <a href="{{ route('myorder') }}" class="icon-container">
                    <div class="bg-b"><i class="fas fa-clock"></i><br><span
                            class="title-span">@lang('site.myorder')</span></div>
                </a>
                <a href="{{ route('my.halls') }}" class="icon-container">
                    <div class=""><i class="fas fa-clock"></i><br><span
                            class="title-span">@lang('site.my_halls')</span></div>
                </a>
                <a href="{{ route('my.caterings') }}" class="icon-container">
                    <div class=""><i class="fas fa-clock"></i><br><span
                            class="title-span">@lang('site.my_caterings')</span></div>
                </a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();"
                    class="icon-container">
                    <div><i class="fas fa-lock"></i><br><span class="title-span">log out</span></div>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>


            </div>
            <div class=" col-md-10 d-md-block d-none">
                <div class="table_block table-responsive ">
                    <table class="table table-bordered">
                        <thead class="btn-dark">

                            <tr>
                                <th>@lang('site.order_number')</th>
                                <th>@lang('site.date_of_order')</th>
                                <th>@lang('site.order_status')</th>
                                <th>@lang('site.price')</th>
                                <th>Quantity</th>

                            </tr>
                        </thead>

                        {{-- @if ($orders->count() > 0) --}}
                        <tbody>

                            @if (\App\Order::where('user_id', Auth::id())->count() > 0)
                                @foreach (\App\Order::where('user_id', Auth::id())->get() as $order)

                                    <tr>
                                        <td>
                                            <a>{{ $order->id }}</a>
                                        </td>
                                        <td>
                                            {{ $order->created_at->toFormattedDateString() }}
                                        </td>
                                        <td>
                                            {{ $order->total_price }}
                                            @lang('site.kwd')

                                        </td>
                                        <td>
                                            {{ $order->total_quantity }}
                                        </td>
                                        <td>

                                            @if ($order->status == 0)

                                                <a class="btn btn-info" href="{{ route('pay.now', $order->id) }}">
                                                    إدفع الأن
                                                </a>

                                            @elseif($order->status == 1)

                                                <a class="text text-primary">
                                                    جاري الشحن
                                                </a>

                                            @elseif($order->status == 2)
                                                <a class="text text-success">
                                                    تم الإستلام
                                                </a>
                                            @endif

                                        </td>


                                    </tr>

                                @endforeach
                            @endif
                        </tbody>
                        {{-- @else --}}
                        {{-- <tr> --}}
                        {{-- <td colspan="4"> --}}
                        {{-- <h3 style="text-align: center"> --}}

                        {{-- @lang('site.no_data')                                   </h3> --}}
                        {{-- </td> --}}

                        {{-- </tr> --}}

                        {{-- @endif --}}

                    </table>
                </div>
            </div>
            <div class="col-sm-8 col-8 d-md-none d-block " style="align-self: center; ">
                @if ($orders->count() > 0)
                    @foreach ($orders as $order)
                        <div class="row border  text-center"><br>
                            {{-- <a href="{{route('product' , $order->id)}}" class="col-12 "><br> --}}
                            {{-- <img alt=" T-shirts" src="{{asset( '/storage/'.$order->img)}}" width="100px;"> --}}
                            {{-- </a> --}}
                            {{-- <br> --}}

                            {{-- <a href="" class="active col-12">{{$order->title_ar}}</a> --}}


                            <p class="col-12">
                                <br>
                                Order number: {{ $order->id }}
                            </p>
                            <p class="col-12">The date of Order : {{ $order->created_at->toFormattedDateString() }}
                            </p>

                            <p class="col-12">price: {{ Auth::user()->getPrice($order->total_price) }}
                                @lang('site.kwd')
                            </p>
                            <p class="col-12"> Order status:

                                @if ($order->status == 0)

                                    <a class="btn btn-info" href="{{ route('pay.now', $order->id) }}">
                                        إدفع الأن
                                    </a>

                                @elseif($order->status == 1)

                                    <a class="text text-primary">
                                        جاري الشحن
                                    </a>

                                @elseif($order->status == 2)
                                    <a class="text text-success">
                                        تم الإستلام
                                    </a>
                                @endif

                            </p>
                            <p class="col-12 text-left">
                                <a class="active"><i class="fas fa-archive"></i></a>
                            </p>
                            {{-- <p class="col-12 text-left"> --}}
                            {{-- <a href="#" class="removeFromWishList text-danger d-flex justify-content-center" data-product-id="{{$order->id}}" > --}}
                            {{-- <i class="fas fa-trash" ></i> --}}
                            {{-- </a>                    </p> --}}

                        </div>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">
                            <h3 style="text-align: center">

                                @lang('site.no_data') </h3>
                        </td>

                    </tr>
                @endif
            </div>
        </div>
    </div>

    <!--- end  --->

@endsection
