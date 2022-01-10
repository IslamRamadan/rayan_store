@extends('layouts.front')
@section('title')
    @lang('site.home')

@endsection
@section('content')

    {{--{{dd($orders[0]->order_item[0]->id)}}--}}
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
                <div class="img-cover m-2"><img src="{{asset('upload/avatar.png')}}"
                                                alt="" class="w-100"></div>
                <h6 class="name">  {{Auth::user()->name}}</h6>
            </div>
            <div class="border col-sm-8 col-md-10 text-dir">
                <div class="row wellcome pad-top-25 p-4">
                    <div class="col-xs-12 col-sm-6 ">
                        <h4> @lang('site.hello') <span>
                                {{Auth::user()->name}}
                            </span></h4>
                        <p>
                            @lang('site.welcome')
                        </p>
                    </div>
                    <div class=" col-xs-12 col-sm-6 pull-right">
                        <div class="row text-dir">
                            <div class="col-xs-12 col-sm-12">
                                <p class="my-orders">@lang('site.my_order') :</p>
                                <p> @lang('site.you_have') {{Session::has('cart_details')?
Session::get('cart_details')['totalQty'] ." items":''}} @lang('site.cc')</p>
                            </div>
                            <div class="col-xs-12 col-sm-12 view-cart">
                                <br><br>
                                <a href="{{route('cart')}}" class="vh brdr btn">@lang('site.cart_details') <i
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


                <a href="{{route('myaccount')}}" class="icon-container">
                    <div class="">
                        <i class="fas fa-user"></i><br><span class="title-span">@lang('site.myaccount') </span></div>
                </a>
                <a href="{{route('wishlist.view')}}" class="icon-container">
                    <div class=""><i class=" far fa-heart"></i><br><span
                            class="title-span">@lang('site.wishlist')</span></div>
                </a>
                <a href="{{route('my.halls')}}" class="icon-container">
                    <div class=""><i class="fas fa-clock"></i><br><span
                            class="title-span">@lang('site.my_halls')</span></div>
                </a>
                <a href="{{ route('myorder') }}" class="icon-container">
                    <div class=""><i class="fas fa-clock"></i><br><span class="title-span">
                            @lang('site.myorder')</span></div>
                </a>
                <a href="{{route('my.caterings')}}" class="icon-container">
                    <div class="bg-b"><i class="fas fa-clock"></i><br><span
                            class="title-span">@lang('site.my_caterings')</span></div>
                </a>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                   class="icon-container">
                    <div><i class="fas fa-lock"></i><br><span class="title-span">log out</span></div>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>


            </div>
            <div class=" col-md-10 d-md-block d-none">
                @if(count($data) > 0)
                    <div class="table_block table-responsive ">
                        <table class="table table-bordered">
                            <thead class="btn-dark">

                            <tr>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.address')</th>
                                <th>@lang('site.catering_title')</th>
                                <th>@lang('site.total_price')</th>
                                <th>@lang('site.persons_no')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->phone}}</td>
                                    <td>{{$item->address}}</td>
                                    <td>{{$item->catering['title_'.app()->getLocale()]}}</td>
                                    <td>{{$item->total_price}}</td>
                                    <td>{{$item->persons_no}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <center><h5>@lang('site.no_caterings')</h5></center>
                @endif
            </div>
        </div>
    </div>

    <!--- end  --->

@endsection
