@extends('layouts.front')
@section('title')
    @lang('site.home')

@endsection
@section('content')
    <!-----start  --->
    <!-- end header -->
    <div class="container-fluid pad-0 m-3">
        <h1 class="title text-center">@lang('site.mywishlist') </h1>
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

    <!-----  ----->
    <br><br>
    <div class="container-fluid ">
        <div class="row  dir-rtl col-dir" style="display: flex">
            <div class="col-xs-3 col-3 col-md-2  left-menu row-dir" style="float:right">

                <a href="{{route('myaccount')}}"  class="icon-container"><div class=""><i class="fas fa-user">

                        </i><br><span class="title-span">@lang('site.myaccount')</span></div></a>
                <a href="{{route('wishlist.view')}}"  class="icon-container"><div class="bg-b"><i class=" far fa-heart"></i><br>
                        <span class="title-span">@lang('site.mywishlist') </span></div></a>
                <a href="{{route('myorder')}}" class="icon-container">
                    <div class=""><i class="fas fa-clock"></i><br><span class="title-span">@lang('site.my_order')  </span></div></a>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="icon-container">
                    <div><i class="fas fa-lock"></i><br><span class="title-span">@lang('site.logout')</span></div>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>


            </div>
            <div class=" col-md-10 d-md-block d-none">
                <div class="table_block table-responsive " >
                    <table class="table table-bordered">
                        <thead class="btn-dark">

                        <tr>
                            <th colspan="2" >@lang('site.product_name')</th>
                            <th >@lang('site.price')</th>

                            <th >@lang('site.delete')</th>
                        </tr>
                        </thead>
                        <tbody >
                        @if($products->count() > 0)
                            @foreach($products as $wih)
                                <tr>
                                    <td >
                                        <a href="{{route('product' , $wih->id)}}">
                                            <img alt=" T-shirts" src="{{asset( '/storage/'.$wih->img)}}" width="100px;">
                                        </a>
                                    </td>
                                    <td >
                                        <p class="">
                                            <a href="{{route('product' , $wih->id)}}" class="active">{{$wih->title_ar}}</a>
                                        </p>

{{--                                        <p>   size: s </p>--}}
{{--                                        <p>  color: </p>--}}
                                    </td>
                                    <td >
                                        <span> {{ Auth::user()->getPrice($wih->price)}} @lang('site.kwd')</span>
                                    </td>
                                    <td class="subtotal text-center" data-title="SUBTOTAL">
                                        <a href="#" class="removeFromWishList text-danger" data-product-id="{{$wih->id}}" >
                                            <i class="fas fa-trash" ></i>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                               <td colspan="4">
                                   <h3 style="text-align: center">

@lang('site.no_data')                                   </h3>
                               </td>

                            </tr>

                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-8 col-8 d-md-none d-block"style="align-self: center; ">
                @if($products->count() > 0)
                    @foreach($products as $wih)
                <div class="row border  text-center"><br>
                    <a href="{{route('product' , $wih->id)}}" class="col-12 "><br>
                        <img alt=" T-shirts" src="{{asset( '/storage/'.$wih->img)}}" width="100px;">
                    </a>
                    <br>

                    <a href="{{route('product' , $wih->id)}}" class="active col-12">{{$wih->title_ar}}</a>
                    <br>


                    <p class="col-12">price: {{Auth::user()->getPrice($wih->price)}} @lang('site.kwd')</p>

                    <p class="col-12 text-left">
                        <a href="#" class="removeFromWishList text-danger d-flex justify-content-center" data-product-id="{{$wih->id}}" >
                            <i class="fas fa-trash" ></i>
                        </a>                    </p>

                </div>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">
                            <h3 style="text-align: center">

                                @lang('site.no_data')                                   </h3>
                        </td>

                    </tr>
                @endif
            </div>
        </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide">Slide 1</div>
              <div class="swiper-slide">Slide 2</div>
              <div class="swiper-slide">Slide 3</div>
              <div class="swiper-slide">Slide 4</div>
              <div class="swiper-slide">Slide 5</div>
              <div class="swiper-slide">Slide 6</div>
              <div class="swiper-slide">Slide 7</div>
              <div class="swiper-slide">Slide 8</div>
              <div class="swiper-slide">Slide 9</div>
            </div>
            <div class="swiper-pagination"></div>
          </div>
    </div>
    <!-----  ----->
    <!--- end  --->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).on('click','.removeFromWishList',function (e) {
        console.log('ok');
            e.preventDefault();
            @guest()
            //                    $('.not-loggedin-modal').css('display','block');
            //                    console.log('You are guest'

            {{--            {{\RealRashid\SweetAlert\Facades\Alert::error('error', 'Please Login first!')}}--}}
            Swal.fire({
                icon: '?',
                title:'Login first!',
                confirmButtonColor: '#ec7d23',
                position:'bottom-start',
                showCloseButton: true,
            })
            @endguest
            @auth
            $.ajax({
                type: 'delete',
                url:"{{route('wishlist.destroy')}}",
                data:{
                    "_token": "{{ csrf_token() }}",
                    'productId':$(this).attr('data-product-id'),

                },
                success:function (data) {
                    if (data.message){
                        Swal.fire({
                            icon: '?',
                            confirmButtonColor: '#ec7d23',
                            position:'bottom-start',
                            showCloseButton: true,
                            title: 'This product already deleted!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        {{--{{\RealRashid\SweetAlert\Facades\Alert::error('ok', 'ok!')}}--}}

                    }
                    else {
//                        alert('This product already in you wishlist');
                        Swal.fire({
                            icon: '?',
                            confirmButtonColor: '#ec7d23',
                            position:'bottom-start',
                            showCloseButton: true,
                            title: 'Deleted successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        location.reload();

                        {{--                        {{\RealRashid\SweetAlert\Facades\Alert::error('no', 'this product added already!')}}--}}

                    }
                }
            });
            @endauth


        });

    </script>

@endsection
