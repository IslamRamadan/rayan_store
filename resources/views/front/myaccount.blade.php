@extends('layouts.front')
@section('title')
    @lang('site.home')

@endsection
@section('content')
    <!-----start  --->
    <!-- end header -->
    <div class="container-fluid pad-0 m-3">
        <h1 class="title text-center">@lang('site.my_account') </h1>
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


        {{--<div class="row">--}}
        {{--<div class="cus text-center border col-md-3 col-sm-3" style="width: 25%">--}}
        {{--<div class="img-cover "><br><br><img src="https://www.shantongulf.com/uploads/clients/avatar2.png" alt="" class="w-50"></div>--}}
        {{--<h6 class="name">  {{Auth::user()->name}}</h6>--}}
        {{--</div>--}}

        {{--<div class="cus text-center border col-md-3 col-sm-3" style="width: 25%">--}}
        {{--<div class="img-cover "><br><br><img src="https://www.shantongulf.com/uploads/clients/avatar2.png" alt="" class="w-50"></div>--}}
        {{--<h6 class="name">  {{Auth::user()->name}}</h6>--}}
        {{--</div>--}}

        {{--<div class="cus text-center border col-md-3 col-sm-3" style="width: 25%">--}}
        {{--<div class="img-cover "><br><br><img src="https://www.shantongulf.com/uploads/clients/avatar2.png" alt="" class="w-50"></div>--}}
        {{--<h6 class="name">  {{Auth::user()->name}}</h6>--}}
        {{--</div>--}}



        {{--<div class="cus text-center border col-md-3 col-sm-3" style="width: 25%">--}}
        {{--<div class="img-cover "><br><br><img src="https://www.shantongulf.com/uploads/clients/avatar2.png" alt="" class="w-50"></div>--}}
        {{--<h6 class="name">  {{Auth::user()->name}}</h6>--}}
        {{--</div>--}}

        {{--<br><br>--}}
        {{--</div>--}}


    </div>

    <!-----  ----->
    <br><br>

    <!-----  ----->
    <div class="container-fluid pad-top-25">
        <div class="row text-dir dir-rtl col-dir" style="display: flex">
            <div class="col-xs-4 col-4 col-md-2  left-menu row-dir" style="float:right">


                <a href="{{route('myaccount')}}" class="icon-container">
                    <div class="bg-b"><i class="fas fa-user"></i><br><span class="title-span">@lang('site.my_account') </span></div>
                </a>
                <a href="{{route('wishlist.view')}}" class="icon-container">
                    <div class=""><i class=" far fa-heart"></i><br><span class="title-span">@lang('site.wishlist')</span></div>
                </a>
                <a href="{{route('myorder')}}" class="icon-container">
                    <div class=""><i class="fas fa-clock"></i><br><span class="title-span"> @lang('site.myorder')</span></div>
                </a>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="icon-container">
                    <div><i class="fas fa-lock"></i><br><span class="title-span"> @lang('site.logout')</span></div>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>


            </div>
            <div class="col-md-10 col-sm-8 col-xs-8 col-8">
                <h6 class="account-table-head">@lang('site.personal_information') </h6>

                <div id="successmessage2" class="success" style="width:100%;display:none;text-align:center"></div>


                <form enctype="multipart/form-data" class="personal-detail form-vertical" id="loginform"
                      action="{{route('update.user' , Auth::id())}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-xs-12" style="float:right">

                            <div class="form-group">

                                <label class="type-text w-100">@lang('site.username') *
                                    <input class="form-control placeholder-fix" placeholder="   " required="required"
                                           name="name" id="Clients_username" type="text" maxlength="200"
                                           value="{{Auth::user()->name}}">
                                </label>
                            </div>

                            <div class="form-group">

                                <label class="type-text w-100">@lang('site.password') *
                                    <input class="form-control placeholder-fix" placeholder="   "
                                           name="password" id="Clients_password" type="password" maxlength="20"
                                           value="{{Auth::user()->password_view}}" required>
                                </label>
                            </div>
                            <div class="form-group ">
                                <label class="type-text w-100">@lang('site.email') *
                                    <input class="form-control placeholder-fix" placeholder="   "
                                           name="email" id="Clients_email" type="email" value="{{Auth::user()->email}}">
                                </label>
                            </div>
                            <div class="form-group ">
                                <label for="country" class="type-text w-100">@lang('site.country') *</label>

                                <select
                                    class="form-control s-styled hasCustomSelect  @error('country') is-invalid @enderror"
                                    name="country" id="country">
                                    @foreach(\App\Country::all() as $c)


                                        @if(Auth::user()->country_id == $c->id)

                                            <option value="{{$c->id}}" selected>
                                                {{$c->name_ar}} - {{$c->name_en}}
                                            </option>
                                        @else
                                            <option value="{{$c->id}}">
                                                {{$c->name_ar}} - {{$c->name_en}}
                                            </option>

                                        @endif
                                    @endforeach
                                </select>


                            </div>


                            <div class="form-group">
                                <label class="type-text w-100"> @lang('site.phone')
                                    <input type="text" class="form-control placeholder-fix"
                                           value="{{Auth::user()->phone}}" name="phone" required>
                                </label>
                            </div>
                            {{--                            <div class="form-group">--}}

                            {{--                                <label class="type-text">picture--}}
                            {{--                                    <input id="ytClients_image" type="hidden" value="" name="Clients[image]"><input class="form-control placeholder-fix" maxlength="255" style="" name="Clients[image]" id="Clients_image" type="file">--}}

                            {{--                                </label>--}}
                            {{--                            </div>--}}

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12" style="margin: 13px">
                            <button class="btn btn-danger" type="submit">@lang('site.save')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-----  ----->

    <!--- end  --->

@endsection
