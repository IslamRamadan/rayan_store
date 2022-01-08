@extends('layouts.front')
@section('title')
    @lang('site.home')

@endsection
@section('content')
    <?php use App\User; ?>
    {{-- {{ dd(Auth::user()->country->name_ar)}} --}}

    @if (session()->get('order'))
        <?php $invoice = session()->get('order'); ?>
        {{-- <h1>The name of fatorah is {{session()->get( 'order' )->name}}</h1> --}}
        <div class="  col-md-5 d-md-block" style="margin: 20px auto !important">
            <div class="table_block table-responsive dir-rtl">
                <table class="table table-bordered">
                    <thead class="gq text-dark">

                        <tr>
                            <th colspan="2" class="text-center">@lang('site.order_summary')</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <tr>
                            <th scope="row" class="gq text-dark">@lang('site.invoice_id')</th>
                            <td>{{ $invoice->invoice_id }}</td>

                        </tr>
                        <tr>
                            <th scope="row" class="gq text-dark">@lang('site.total_price')</th>
                            <td>{{ $invoice->total_price }} @lang('site.kwd')</td>

                        </tr>
                        <th scope="row" class="gq text-dark">@lang('site.email')</th>
                        <td>{{ $invoice->email }}</td>

                        </tr>
                        <tr>
                            <th scope="row" class="gq text-dark">@lang('site.phone')</th>
                            <td>{{ $invoice->phone }}</td>

                        </tr>
                        @if ($invoice->address1)
                        <tr>
                            <th scope="row" class="gq text-dark">@lang('site.address1')</th>
                            <td>{{ $invoice->address1 }}</td>

                        </tr>
                        @endif

                        <tr>
                            <th scope="row" class="gq text-dark">@lang('site.name')</th>
                            <td>{{ $invoice->name }}</td>

                        </tr>
                        @if ($invoice->address1)
                        <tr>
                            <th scope="row" class="gq text-dark">@lang('site.total_quantity')</th>
                            <td>{{ $invoice->total_quantity }}</td>

                        </tr>
                        @endif

                        <tr>
                            <th scope="row" class="gq text-dark">@lang('site.date_of_order')</th>
                            <td>{{ $invoice->created_at }}</td>

                        </tr>

                    </tbody>
                </table>
            </div>
        </div>








        {{ Session::forget('order') }}

        {{-- @dd( "The name of fatorah is ".session()->get( 'order' )->name) --}}
        {{-- @dd( "The name of fatorah is ".session()->get( 'order' )->name) --}}

    @endif



    <!-----start carousel --->
    <div id="carouselExampleIndicators" class="carousel slide relative" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            <?php
            $i = 0;
            ?>
            @foreach ($sliders as $one)
                <div class="carousel-item  @if ($i == 0) active @endif ">
                    <img class=" w-100 h " src="{{ asset('storage/' . $one->img) }}" alt="1 slide"
                        style="height: 90vh">
                    @if (app()->getLocale() == 'en')
                        <div class="abs w-100">
                            <p class="c-w mr-0"></p>
                            <h1 class=""> </h1>
                            {{-- <button class=" btn btn-danger">@lang('site.shop_now') <i class="far fa-heart"></i></button> --}}
                    </div> @else
                        <div class="abs w-100">
                            <p class="c-w mr-0"></p>
                            <h1 class=""> </h1>
                            {{-- <button class=" btn btn-danger">@lang('site.shop_now') <i class="far fa-heart"></i></button> --}}
                        </div>
                    @endif


                </div>
                <?php
                $i++;
                ?>
            @endforeach


        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon " aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!--- end head --->
    <br>


    <br><br>
    </div>

    <div class="container pad-0">
        <br>
        <h2 class="text-center  d-flex justify-content-between">
            <b></b>
            <span class="">@lang('site.our_menu')

            </span>
            <b></b>
        </h2>
        <br>
        <br>
        <div class="row dir-rtl">
            <div class="col-lg-4 col-md-5 col-sm-5 text-dir">
                <div class="heading-section text-md-right ftco-animate">
                    <h2 class="mb-2">@lang('site.our_menu')</h2>
                    <p class="mb-4">@lang('site.far')</p>
                    {{-- <p><a href="#" class="btn btn-primary btn-outline-primary px-4 py-3">@lang('site.view_menu')</a></p> --}}
                </div>

            </div>
            <div class="col-lg-8 col-md-7 col-sm-7">
                <div class="owl-carousel owl-four owl-theme">
                    @foreach (App\BasicCategory::all() as $item)
                   <a href="{{ route('category', [1, $item->id]) }}">
                    <div class="item">
                        <div class="img-slider" style="position: relative">
                            <img src="{{ asset('/storage/' . $item->image_url) }}" alt="">
                            <div class="middle">
                                @if (Lang::locale() == 'en')
                                <div class="btn btn-danger">{{$item->name_en}}</div>
                                @else
                                <div class="btn btn-danger">{{$item->name_ar}}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                  </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>







    <div class="container pad-0 ">

        <br>
        <h2 class="text-center  d-flex justify-content-between">
            <b></b>
            <span class="">@lang('site.new_arrival')

            </span>
            <b></b>
        </h2>
        <br>
        <br>
        {{-- <br class="d-none d-md-block">
        <br class="d-none d-md-block"> --}}

        {{-- <div class="col-lg-9 col-md-8 pad-0 "> --}}
        <div class="row text-center dir-rtl">
            @foreach ($new_arrive as $p)

                <div class="col-6 col-md-4 col-lg-3">
                    <div class=" product relative text-dir mb-5">

                        {{-- <div class="  heart ">
                                    <a href="#" class="addToWishList text-white" data-product-id="{{$p->id}}">
                                        <i class="far fa-heart "></i>
                                    </a>

                                </div> --}}

                        <a href="{{ route('product', $p->id) }}" class="image-hover ">
                            <div style="position: relative">
                                <img src="{{ asset('/storage/' . $p->img) }}"
                                    onerror="this.onerror=null;this.src='{{ asset('front/img/3.jpg') }}'" width="100%"
                                    class="show-img image">
                                <div class="middle">
                                    <div class="btn btn-danger">@lang('site.add_to_cart')</div>
                                </div>
                                @if ($img = App\ProdImg::where('product_id', $p->id)->first())
                                    <img src="{{ asset($img->img) }}" width="100%" class="hide-img image">
                                    <div class="middle">
                                        <div class="btn btn-danger">@lang('site.add_to_cart')</div>
                                    </div>
                                @else
                                    <img src="{{ asset('/storage/' . $p->img) }}" width="100%" class="hide-img image">
                                    <div class="middle">
                                        <div class="btn btn-danger">@lang('site.add_to_cart')</div>
                                    </div>
                                @endif
                            </div>
                        </a>
                        <p class="mr-0">
                            <a href="{{ route('product', $p->id) }}">
                                @if (Lang::locale() == 'ar')
                                    {{ $p->title_ar }}

                                @else

                                    {{ $p->title_en }}

                                @endif


                            </a>
                        </p>
                        <h6><a href="{{ route('product', $p->id) }}">


                                @if (Lang::locale() == 'ar')
                                    {{-- {{$p->basic_category->name_ar}}
                                            -
                                            {{$p->category->name_ar}} --}}
                                    <?php $pieces = explode(' ', $p->description_ar);
                                    $first_part = implode(' ', array_splice($pieces, 0, 4)); ?>
                                    {{ $first_part }}
                                @else

                                    {{-- {{$p->basic_category->name_en}}
                                            -
                                            {{$p->category->name_en}} --}}
                                    <?php $pieces = explode(' ', $p->description_en);
                                    $first_part = implode(' ', array_splice($pieces, 0, 4)); ?>
                                    {{ $first_part }}
                                @endif


                            </a></h6>
                        <h5>


                            @auth()
                                {{ Auth::user()->getPrice($p->price) }}
                                {{ Auth::user()->country->currency->code }}
                            @endauth
                            @guest()
                                @if (Cookie::get('name'))
                                    {{ number_format($p->price / App\Country::find(Cookie::get('name'))->currency->rate, 2) }}
                                    {{ App\Country::find(Cookie::get('name'))->currency->code }}
                                    {{-- @lang('site.kwd') --}}
                                @else
                                    {{ $p->price }}
                                    @lang('site.kwd')
                                @endif
                            @endguest

                        </h5>
                    </div>

                </div>
            @endforeach


            {{-- @else
                    <h5 style="text-align: center;margin: auto">
                        @lang('site.no_data')
                    </h5> --}}
            {{-- @endif --}}

        </div>
        <br>
        <div class="text-center m-auto gq gr gs dg ck dh di cn gt c1 gu gv cq p cr gw gx gy">
            <a href="{{ route('new') }}" class="">
                <div class="text-center text-dark">@lang('site.new_in')</div>
            </a>
        </div>
        <br><br>

        {{-- </div> --}}
        <br><br>
    </div>


    <div class="container pad-0">
        <br>
        <h2 class="text-center  d-flex justify-content-between">
            <b></b>
            <span class="">@lang('site.reserve_hall')

            </span>
            <b></b>
        </h2>
        <br>
        <br>
        <div class="row dir-rtl">
            <div class="col-lg-3 col-md-4 col-sm-5 text-dir">
                <div class="heading-section text-md-right ftco-animate">
                    <h2 class="mb-2">@lang('site.reserve_now')</h2>
                    <p class="mb-4">@lang('site.hall')</p>
                    {{-- <p><a href="#" class="btn btn-primary btn-outline-primary px-4 py-3">@lang('site.view_menu')</a></p> --}}
                </div>

            </div>
            <div class="col-lg-9 col-md-8 col-sm-7">
                <a href="{{ route('hall', 1) }}">
                <div class="w-100 " style="height: 50vh">
                    <img src="{{url('front/img/9.jpg')}}" alt="" style="width:100%;height:100%">
                </div>
            </a>
            </div>

        </div>
    </div>

    <br>
    <br>
    <br>

    <div class="owl-carousel owl-five owl-theme p-3">
        @foreach (App\Post::all() as $post)
        <a href="{{route('cart')}}" target="_blank">
            <div class="item">
                <div class="text-dir new1 "
                    style="background-image:url({{ asset('/storage/' . $post->img1) }})">

                    <h1 class="c-w">

                    </h1>
                    <p class="c-w ">

                    </p>

                </div>
            </div>
        </a>
        @endforeach



    </div>
<br>
<br>
<br>



<div class="container pad-0 ">

    <br>
    <h2 class="text-center  d-flex justify-content-between">
        <b></b>
        <span class="">@lang('site.catering')

        </span>
        <b></b>
    </h2>
    <br>
    <br>
    {{-- <br class="d-none d-md-block">
    <br class="d-none d-md-block"> --}}

    {{-- <div class="col-lg-9 col-md-8 pad-0 "> --}}
    <div class="row text-center dir-rtl">
        @foreach (App\Product::where('best_selling',1)->get() as $p)

            <div class="col-6 col-md-4 col-lg-3">
                <div class=" product relative text-dir mb-5">

                    {{-- <div class="  heart ">
                                <a href="#" class="addToWishList text-white" data-product-id="{{$p->id}}">
                                    <i class="far fa-heart "></i>
                                </a>

                            </div> --}}

                    <a href="{{ route('product', $p->id) }}" class="image-hover ">
                        <div style="position: relative">
                            <img src="{{ asset('/storage/' . $p->img) }}"
                                onerror="this.onerror=null;this.src='{{ asset('front/img/3.jpg') }}'" width="100%"
                                class="show-img image">
                            <div class="middle">
                                <div class="btn btn-danger">@lang('site.add_to_cart')</div>
                            </div>
                            @if ($img = App\ProdImg::where('product_id', $p->id)->first())
                                <img src="{{ asset($img->img) }}" width="100%" class="hide-img image">
                                <div class="middle">
                                    <div class="btn btn-danger">@lang('site.add_to_cart')</div>
                                </div>
                            @else
                                <img src="{{ asset('/storage/' . $p->img) }}" width="100%" class="hide-img image">
                                <div class="middle">
                                    <div class="btn btn-danger">@lang('site.add_to_cart')</div>
                                </div>
                            @endif
                        </div>
                    </a>
                    <p class="mr-0">
                        <a href="{{ route('product', $p->id) }}">
                            @if (Lang::locale() == 'ar')
                                {{ $p->title_ar }}

                            @else

                                {{ $p->title_en }}

                            @endif


                        </a>
                    </p>
                    <h6><a href="{{ route('product', $p->id) }}">


                            @if (Lang::locale() == 'ar')
                                {{-- {{$p->basic_category->name_ar}}
                                        -
                                        {{$p->category->name_ar}} --}}
                                <?php $pieces = explode(' ', $p->description_ar);
                                $first_part = implode(' ', array_splice($pieces, 0, 4)); ?>
                                {{ $first_part }}
                            @else

                                {{-- {{$p->basic_category->name_en}}
                                        -
                                        {{$p->category->name_en}} --}}
                                <?php $pieces = explode(' ', $p->description_en);
                                $first_part = implode(' ', array_splice($pieces, 0, 4)); ?>
                                {{ $first_part }}
                            @endif


                        </a></h6>
                    <h5>


                        @auth()
                            {{ Auth::user()->getPrice($p->price) }}
                            {{ Auth::user()->country->currency->code }}
                        @endauth
                        @guest()
                            @if (Cookie::get('name'))
                                {{ number_format($p->price / App\Country::find(Cookie::get('name'))->currency->rate, 2) }}
                                {{ App\Country::find(Cookie::get('name'))->currency->code }}
                                {{-- @lang('site.kwd') --}}
                            @else
                                {{ $p->price }}
                                @lang('site.kwd')
                            @endif
                        @endguest

                    </h5>
                </div>

            </div>
        @endforeach


        {{-- @else
                <h5 style="text-align: center;margin: auto">
                    @lang('site.no_data')
                </h5> --}}
        {{-- @endif --}}

    </div>
    <br>
    <div class="text-center m-auto gq gr gs dg ck dh di cn gt c1 gu gv cq p cr gw gx gy">
        <a href="{{ route('new') }}" class="">
            <div class="text-center text-dark">@lang('site.new_in')</div>
        </a>
    </div>
    <br><br>

    {{-- </div> --}}
    <br><br>
</div>







    @if ($offers->count() > 0)

        <div class="container pad-0 ">

            <br>
            <h2 class="text-center  d-flex justify-content-between">
                <b></b>
                <span class="">@lang('site.offer')

                </span>
                <b></b>
            </h2>
            <br>
            <br>
            {{-- <br class="d-none d-md-block">
        <br class="d-none d-md-block"> --}}

            {{-- <div class="col-lg-9 col-md-8 pad-0 "> --}}
            <div class="row text-center dir-rtl">
                @foreach ($offers as $p)

                    <div class="col-6 col-md-4 col-lg-3">
                        <div class=" product relative text-dir mb-5">

                            {{-- <div class="  heart ">
                                    <a href="#" class="addToWishList text-white" data-product-id="{{$p->id}}">
                                        <i class="far fa-heart "></i>
                                    </a>

                                </div> --}}

                            <a href="{{ route('product', $p->id) }}" class="image-hover ">
                                <div style="position: relative">
                                    <img src="{{ asset('/storage/' . $p->img) }}"
                                        onerror="this.onerror=null;this.src='{{ asset('front/img/3.jpg') }}'"
                                        width="100%" class="show-img image">
                                    <div class="middle">
                                        <div class="btn btn-danger">@lang('site.add_to_cart')</div>
                                    </div>
                                    @if ($img = App\ProdImg::where('product_id', $p->id)->first())
                                        <img src="{{ asset($img->img) }}" width="100%" class="hide-img image">
                                        <div class="middle">
                                            <div class="btn btn-danger">@lang('site.add_to_cart')</div>
                                        </div>
                                    @else
                                        <img src="{{ asset('/storage/' . $p->img) }}" width="100%"
                                            class="hide-img image">
                                        <div class="middle">
                                            <div class="btn btn-danger">@lang('site.add_to_cart')</div>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <p class="mr-0">
                                <a href="{{ route('product', $p->id) }}">
                                    @if (Lang::locale() == 'ar')
                                        {{ $p->title_ar }}

                                    @else

                                        {{ $p->title_en }}

                                    @endif


                                </a>
                            </p>
                            <h6><a href="{{ route('product', $p->id) }}">


                                    @if (Lang::locale() == 'ar')
                                        {{-- {{$p->basic_category->name_ar}}
                                            -
                                            {{$p->category->name_ar}} --}}
                                        <?php $pieces = explode(' ', $p->description_ar);
                                        $first_part = implode(' ', array_splice($pieces, 0, 4)); ?>
                                        {{ $first_part }}
                                    @else

                                        {{-- {{$p->basic_category->name_en}}
                                            -
                                            {{$p->category->name_en}} --}}
                                        <?php $pieces = explode(' ', $p->description_en);
                                        $first_part = implode(' ', array_splice($pieces, 0, 4)); ?>
                                        {{ $first_part }}
                                    @endif


                                </a></h6>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-small" style="text-decoration: line-through">


                                    @auth()
                                        {{ Auth::user()->getPrice($p->before_price) }}
                                        {{ Auth::user()->country->currency->code }}
                                    @endauth
                                    @guest()
                                        @if (Cookie::get('name'))
                                            {{ number_format($p->before_price / App\Country::find(Cookie::get('name'))->currency->rate, 2) }}
                                            {{ App\Country::find(Cookie::get('name'))->currency->code }}
                                            {{-- @lang('site.kwd') --}}
                                        @else
                                            {{ $p->before_price }}
                                            @lang('site.kwd')
                                        @endif
                                    @endguest

                                </h6>
                                <h5>


                                    @auth()
                                        {{ Auth::user()->getPrice($p->price) }}
                                        {{ Auth::user()->country->currency->code }}
                                    @endauth
                                    @guest()
                                        @if (Cookie::get('name'))
                                            {{ number_format($p->price / App\Country::find(Cookie::get('name'))->currency->rate, 2) }}
                                            {{ App\Country::find(Cookie::get('name'))->currency->code }}
                                            {{-- @lang('site.kwd') --}}
                                        @else
                                            {{ $p->price }}
                                            @lang('site.kwd')
                                        @endif
                                    @endguest

                                </h5>

                            </div>
                        </div>

                    </div>
                @endforeach


                {{-- @else
                    <h5 style="text-align: center;margin: auto">
                        @lang('site.no_data')
                    </h5> --}}
                {{-- @endif --}}

            </div>
            <br>
            <div class="text-center m-auto gq gr gs dg ck dh di cn gt c1 gu gv cq p cr gw gx gy">
                <a href="{{ route('offer') }}" class="">
                    <div class="text-center text-dark">@lang('site.more')</div>
                </a>
            </div>
            <br><br>

            {{-- </div> --}}
            <br><br>
        </div>

    @endif





    <br> <br>







    <!-----start  --->


    {{-- <div class="country ">

        <div class="relative">

            <video class="h-100 w-100 " autoplay controls muted>
                <source src="{{asset('front/img/video.mp4')}}" type="video/mp4">
            </video>
            <div class="abs-shop text-center">
                <button class=" btn btn-danger close-country  ">@lang('site.shop_now') <i class="far fa-heart"></i></button>
            </div>

            <br>
        </div>
    </div> --}}














    <script>
        $(document).on('click', '.addToWishList', function(e) {

            e.preventDefault();
            @guest()
                // $('.not-loggedin-modal').css('display','block');
                // console.log('You are guest'

                {{-- {{\RealRashid\SweetAlert\Facades\Alert::error('error', 'Please Login first!')}} --}}
                Swal.fire({

                icon: '?',
                title:'Login first!',
                confirmButtonColor: '#d76797',
                position:'bottom-start',
                showCloseButton: true,
                })
            @endguest
            @auth
                $.ajax({
                type: 'get',
                url:"{{ route('wishlist.store') }}",
                data:{
                'productId':$(this).attr('data-product-id'),
                },
                success:function (data) {
                if (data.message){
                Swal.fire({
                icon: '?',
                confirmButtonColor: '#d76797',
                position:'bottom-start',
                showCloseButton: true,
                title: 'Added successfully!',
                showConfirmButton: false,
                timer: 1500
                })
                {{-- {{\RealRashid\SweetAlert\Facades\Alert::error('ok', 'ok!')}} --}}

                }
                else {
                // alert('This product already in you wishlist');
                Swal.fire({
                icon: '?',
                confirmButtonColor: '#d76797',
                position:'bottom-start',
                showCloseButton: true,
                title: 'This product already in you wishlist',
                showConfirmButton: false,
                timer: 1500
                })

                {{-- {{\RealRashid\SweetAlert\Facades\Alert::error('no', 'this product added already!')}} --}}

                }
                }
                });
            @endauth


        });
    </script>
@endsection
