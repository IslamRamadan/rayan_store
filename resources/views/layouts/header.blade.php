<html dir="ltr" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/main-style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/media.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('front/css/owl.carousel.min.css') }}"> --}}

    <!-- slick css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/slick.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('front/css/slick-theme.css') }}" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <link rel="stylesheet" href="{{ asset('front/css/animate.css') }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/duotone.css"
        integrity="sha384-R3QzTxyukP03CMqKFe0ssp5wUvBPEyy9ZspCB+Y01fEjhMwcXixTyeot+S40+AjZ" crossorigin="anonymous" />
    {{-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/fontawesome.css"
        integrity="sha384-eHoocPgXsiuZh+Yy6+7DsKAerLXyJmu2Hadh4QYyt+8v86geixVYwFqUvMU8X90l" crossorigin="anonymous" /> --}}
    <link href="{{ asset('front/img/logo1.PNG') }}" rel="icon" type="image/png">
    {{-- <link href="//db.onlinewebfonts.com/c/be395203fb38e2f170265aa2a9785467?family=M+Sung+PRC" rel="stylesheet" --}}
        {{-- type="text/css" /> --}}
         {{-- slider ismail start --}}
    {{-- <link rel="stylesheet" href="{{ asset('front/assets/css/bootstrap..min.css')}}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('front/assets/css/boxicons.min.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('front/assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css')}}">

    {{-- slider ismail end --}}


    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <style>
        .heart2 {

            right: 35px !important;

        }

        .title-span {
            display: block;
        }

        .icon-container div {
            width: 150px;
            height: 150px;
        }


        @media only screen and (max-width: 960px) {
            .title-span {
                display: none;
            }

            .icon-container div {
                width: 100px;
                height: 100px;
            }
        }

    </style>
    <title>

        @if ($my_setting->site_name_en)

            {{ $my_setting->site_name_en }}

        @endif

    </title>

    <script>
        $(document).ready(function() {
            // alert('hiiiiiiiiiiiiii')

            $('.circle').on('click', function(e) {
                e.preventDefault();
                alert('hola');
            })

            //TODO ::VIEW CART FIRST ITEM AND CALL THIS WHEN READY AND ON HOVER

            $('#cart-hover').on({
                mouseenter: function() {
                    // $('#cart-items').html('<p style="color:black;">wait  ... </p> ');
                    viewFromCart();
                    //stuff to do on mouse enter
                },
                mouseleave: function() {
                    //stuff to do on mouse leave
                    // alert('i am leaving')
                }
            });


            function viewFromCart() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('view.from.cart') }}",
                    method: 'get',
                    success: function(result) {
                        //CHECK SIZE VALUES
                        //CHECK HEIGHTS VALUE
                        // Swal.fire({
                        //     toast: true,
                        //     icon: 'success',
                        //     title: 'تمت الإضافه الي السله',
                        //     animation: false,
                        //     position: 'bottom',
                        //     showConfirmButton: false,
                        //     timer: 3000,
                        //     timerProgressBar: true,
                        //     didOpen: (toast) => {
                        //         toast.addEventListener('mouseenter', Swal.stopTimer)
                        //         toast.addEventListener('mouseleave', Swal.resumeTimer)
                        //     }
                        // });

                        //CART . HTML = RESULT
                        // location.reload();
                        // $('#cart-items').html(result);

                        $('#cart-items').html(result);

                        console.log(result);
                    },
                    error: function(error) {
                        // Swal.fire({
                        //     icon: 'error',
                        //     title: 'لم تكتمل العمليه ',
                        // })
                        console.log(error);
                    }
                });
            }

            // viewFromCart();
        })
    </script>
</head>


<body>
    <div class="vwrap">
        <div class="vmove">

            @foreach (App\News::where('appearance', 1)->get() as $news)
                <div class="vitem">
                    @if (app()->getLocale() == 'en')
                        {{ $news->content_en }}
                    @else
                        {{ $news->content_ar }}
                    @endif


                </div>
            @endforeach
        </div>
    </div>


    <div class="container-fluid pad-0 bg-white  head-flex d-md-flex d-sm-none" >
        <!-- <div class="container  "> -->
        <div class="align-self-center ml-4">
            <ul class="navbar-nav1  mr-auto ">

                <li class="nav-item "><a class="nav-link " href="{{ route('myaccount') }}"><i
                            class="far fa-user sml-fa" style="font-size: 30px;"></i> </a></li>
                <li class="nav-item relative ul1 align-self-center custom-nav-icon d-flex">
                    @if (app()->getLocale() == 'en')
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            @if ($localeCode == 'en')
                                @continue
                            @endif

                            <a class="nav-link" rel="alternate" hreflang="{{ $localeCode }}"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                <img src="{{ asset('front/img/kuwait.png') }}" width="20">
                                <span class="LocaleSwitch2__diamond-divider"></span>
                                Switch to Arabic
                            </a>
                        @endforeach
                    @else
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            @if ($localeCode == 'ar')
                                @continue
                            @endif

                        <a class="nav-link " rel="alternate" hreflang="{{ $localeCode }}"
                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"  style="font-size: 12px">  التحويل الي الانجليزيه<span class="LocaleSwitch2__diamond-divider"></span><img src="{{ asset('front/img/en.png') }}" width="20"> </a>

                        @endforeach
                    @endif

                    {{-- <a class="nav-link " href="{{route('/')}}" style="font-size: 12px"> <img src="{{asset('front/img/en.png')}}" width="20"><span class="LocaleSwitch2__diamond-divider"></span> Switch to Arabic </a> --}}


                </li>


            </ul>
        </div>

        <div>
            <a class="nav-link " href="{{ route('/') }}" style="padding: 3px !important;"> <img
                    src="{{ asset('/storage/' . $my_setting->logo) }}" width="70"></a>
        </div>

        <div class="text-right align-self-center mr-4">
            <nav class="navbar navbar-expand-md pad-0 p-0 ">
                <ul class="navbar-nav1  mr-auto ">



                    <li class="nav-item relative ul1 mr-3">
                        <a class="nav-link " href="">
                            <i class="fas fa-search sml-fa" style="font-size: 25px;"></i></a>
                        <div class=" ul2  bg-w  text-left "
                            style="padding: 10px;width: 200px;background: transparent !important;box-shadow: none;border: none;">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="search-word" name="search"
                                placeholder="search " value="islam two" >
                                <div class="input-group-append">
                                    <button class="input-group-text bg-main"> <i
                                            class="fas fa-search sml-fa" id="search-submit"></i></button>
                                </div>
                            </div>

                        </div>

                    </li>


                    <li class="nav-item mr-3 "><a class="nav-link " href="{{ route('wishlist.view') }}"><i
                                class="far fa-heart sml-fa" style="font-size: 25px;"></i> </a></li>
                    <li class="nav-item mr-3" id="cart-hover"><a class="nav-link "
                            href="{{ route('cart') }}"><i class="fas fa-shopping-cart sml-fa"
                                style="font-size: 25px;"></i><span class='badge badge-warning' id='lblCartCount'>
                                {{ Session::has('cart_details') ? Session::get('cart_details')['totalQty'] : '0' }}
                            </span>
                        </a>
                        <div class=" ul2  bg-w  text-right " style="padding: 10px;width: 300px">

                            <div id="cart-items">
                                <strong style="text-align: center;margin:auto;font-size:20px">

                                    @lang('site.bin_empty')

                                </strong>
                            </div>

                            <a href="{{ route('product.shoppingCart') }}"
                                class="btn bg-main w-100">@lang('site.view_cart')</a>
                            <br><br>
                            <a href="{{ route('checkout') }}" class="btn bg-main w-100">
                                @lang('site.checkout')
                            </a>
                        </div>

                    </li>
                </ul>


            </nav>
        </div>

        <!-- </div> -->
    </div>

    <div class="container-fluid pad-0 bg-b d-md-block d-none head_rtl" style="background: #000 !important">
        <div class="d-flex justify-content-center  ">
            <div class="float-left">
                <nav class="navbar navbar-expand-md pad-0 p-0">
                    <ul class="navbar-nav float-right pad-0">



                        @foreach (\App\BasicCategory::all() as $b)
                            <li class="nav-item relative ul1"><a class="nav-link "
                                    href="{{ route('category', [1, $b->id]) }}">
                                    @if (app()->getLocale() == 'en')
                                        {{ $b->name_en }}
                                    @else
                                        {{ $b->name_ar }}
                                    @endif

                                </a>

                                <div class=" ul2  bg-w  text-left ">


                                    @if (\App\Category::where('basic_category_id', $b->id)->count() > 0)
                                        @foreach (\App\Category::where('basic_category_id', $b->id)->get() as $c)
                                            <a class="nav-link " href="{{ route('category', [2, $c->id]) }}">
                                                @if (app()->getLocale() == 'en')
                                                    {{ $c->name_en }}
                                                @else
                                                    {{ $c->name_ar }}
                                                @endif
                                            </a>
                                            <hr class="mr-0">
                                        @endforeach
                                    @endif

                                </div>

                            </li>
                        @endforeach


                        <li class="nav-item relative ul1"><a class="nav-link "
                            href="#">
                            @lang('site.halls')
                        </a>

                        <div class=" ul2  bg-w  text-left ">


                            @if (\App\Hall::count() > 0)
                                @foreach (\App\hall::all() as $c)
                                    <a class="nav-link " href="{{ route('hall',$c->id) }}">
                                        @if (app()->getLocale() == 'en')
                                            {{ $c->title_en }}
                                        @else
                                            {{ $c->title_ar }}
                                        @endif
                                    </a>
                                    <hr class="mr-0">
                                @endforeach
                            @endif

                        </div>

                    </li>
                        <li class="nav-item relative ul1"><a class="nav-link "
                            href="#">
                            @lang('site.catering')
                        </a>

                        <div class=" ul2  bg-w  text-left ">


                            @if (\App\Catering::count() > 0)
                                @foreach (\App\Catering::all() as $c)
                                    <a class="nav-link " href="{{ route('hall',$c->id) }}">
                                        @if (app()->getLocale() == 'en')
                                            {{ $c->title_en }}
                                        @else
                                            {{ $c->title_ar }}
                                        @endif
                                    </a>
                                    <hr class="mr-0">
                                @endforeach
                            @endif

                        </div>

                    </li>



                        <li class="nav-item "><a class="nav-link " href="{{ route('policy') }}">
                                @lang('site.policy')

                            </a></li>
                        <li class="nav-item "><a class="nav-link " href="{{ route('checkout') }}">
                                @lang('site.payment')
                            </a></li>

                        <li class="nav-item "><a class="nav-link " href="{{ route('contact.us') }}">
                                @lang('site.contact_us')
                            </a></li>

                    </ul>


                </nav>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <nav class="d-md-none d-block bg-white " style="position: fixed;
    top: 0;
    z-index: 3;
    width: -webkit-fill-available;">

        <div class=" d-flex justify-content-between ">
            <div class="relative" style="align-self: center">
               <div class="d-flex">
                <div class="nav-link p-0">
                    <button class="navbar-toggler  btn bg-none " onclick="history.back()" type="button">
                        <i class=" fas  fa-arrow-left " style="font-size: 18px;color:rgb(255, 255, 255)"></i>
                    </button>
                </div>
                <div class="nav-link p-0">
                    <button class="navbar-toggler  btn bg-none " type="button">
                        <i class=" fas fa-bars " style="font-size: 18px;color:rgb(255, 255, 255)"></i>
                    </button>
                </div>
            </div>


                <div class="sidbar bg-dark text-dir dir-rtl" style="overflow: scroll;
                max-height: 91vh;">
                    <div class="border-bottom">
                        <br>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="search-word2" name="search"
                                placeholder="search " value="" >
                            <div class="input-group-append">
                                <button class="input-group-text bg-main" id="search-submit2"><i
                                        class="fas fa-search "></i>
                                </button>
                            </div>
                        </div>
                        <br>
                    </div>
                    {{-- @guest()

                    <div class="nav-link relative ul1">
                        <a style="display: flex;justify-content: space-between;align-items: center">
                            @if (Cookie::get('name'))
                                @if (app()->getLocale() == 'en')

                                    {{App\Country::find(Cookie::get('name'))->name_en}}
                                @else
                                    {{App\Country::find(Cookie::get('name'))->name_ar}}
                                @endif
                                <img src="{{ asset('storage/'.App\Country::find(Cookie::get('name'))->image_url)}}" width="20px"> <i
                                        class="fas fa-chevron-down "></i>
                            @else
                                @if (app()->getLocale() == 'en')

                                    Choose country
                                @else
                                    اختر دوله

                                @endif
                            @endif

                        </a>
                        <div class=" ul2  bg-w  text-left ">

                            <div class=" ul2  bg-w  text-left ">


                                @foreach (App\Country::all() as $country)

                                    <a class="dropdown-item" rel="alternate"
                                       href="{{route('cookie.set',$country->id)}}">
                                        @if (app()->getLocale() == 'en')
                                            {{ $country->name_en}}

                                        @else
                                            {{ $country->name_ar}}

                                        @endif


                                        <img src="{{asset('/storage/'.$country->image_url)}}"
                                             width="20">
                                    </a>


                                @endforeach

                            </div>

                        </div>
                    </div>
                @endguest --}}


                    @foreach (\App\BasicCategory::all() as $b)
                        <div class="relative ul1">

                            <a class="border-bottom nav-link "
                                style="display: flex;justify-content: space-between;align-items: center">

                                <span class="p-0">
                                    @if (app()->getLocale() == 'en')
                                        {{ $b->name_en }}
                                    @else
                                         {{ $b->name_ar }}
                                    @endif

                                </span>



                                <i class="fas fa-chevron-down "></i>
                            </a>
                            <div class=" ul2  bg-w  text-dir ">


                                @if (\App\Category::where('basic_category_id', $b->id)->count() > 0)
                                    @foreach (\App\Category::where('basic_category_id', $b->id)->get() as $c)

                                        <a class="dropdown-item" rel="alternate"
                                            href="{{ route('category', [2, $c->id]) }}" style="padding: 10px">
                                            @if (app()->getLocale() == 'en')
                                                 {{ $c->name_en }}
                                            @else
                                                {{ $c->name_ar }}
                                            @endif
                                        </a>

                                    @endforeach
                                @endif

                            </div>
                        </div>
                    @endforeach



                    <div class="relative ul1">

                        <a class="border-bottom nav-link "
                            style="display: flex;justify-content: space-between;align-items: center">

                            <span class="p-0">
                               @lang('site.halls')

                            </span>



                            <i class="fas fa-chevron-down "></i>
                        </a>
                        <div class=" ul2  bg-w  text-dir ">


                            @if (\App\Hall::count() > 0)
                                @foreach (\App\Hall::all() as $c)

                                    <a class="dropdown-item" rel="alternate"
                                        href="{{ route('hall',  $c->id)}}" style="padding: 10px">
                                        @if (app()->getLocale() == 'en')
                                             {{ $c->title_en }}
                                        @else
                                            {{ $c->title_ar }}
                                        @endif
                                    </a>

                                @endforeach
                            @endif

                        </div>
                    </div>



                    <ul class="navbar nav pad-0  border-bottom" style="justify-content: space-evenly ">

                        @if (\App\Settings::all()->first()->facebook)
                            <li class="nav-item "><a class=" " href="{{ $my_setting->facebook }}"
                                    target="_blank" title="facebook"><i class="fab fa-facebook-f"></i> </a>
                            </li>
                        @endif

                        @if (\App\Settings::all()->first()->instagram)
                            <li class="nav-item "><a href="{{ $my_setting->instagram }}" target="_blank"
                                    title="instagram"><i class="fab fa-instagram"></i> </a>
                            </li>
                        @endif



                        @if (\App\Settings::all()->first()->twitter)
                            <li class="nav-item "><a class=" " href="{{ $my_setting->twitter }}"
                                    target="_blank" title="twitter"><i class="fab fa-twitter"></i>
                                </a></li>
                        @endif


                        @if (\App\Settings::all()->first()->email)
                            <li class="nav-item "><a class=" " href="mailto:{{ $my_setting->email }}"
                                    target="_blank" title="email"><i class="far fa-envelope"></i>
                                </a></li>
                        @endif

                        @if (\App\Settings::all()->first()->whatsapp)
                            <li class="nav-item "><a class=" "
                                    href="https://wa.me/{{ $my_setting->whatsapp }}" target="_blank" title="call us"><i
                                        class="fab fa-whatsapp"></i> </a>
                            </li>
                        @endif

                    </ul>


                    <div class="nav-link relative ul1">
                        <a style="display: flex;justify-content: space-between;align-items: center">
                            @if (app()->getLocale() == 'en')
                                English <img src="{{ asset('front/img/en.png') }}" width="20"> <i
                                    class="fas fa-chevron-down "></i>
                            @else
                                العربية
                                <img src="{{ asset('front/img/kuwait.png') }}" width="20"> <i
                                    class="fas fa-chevron-down "></i>
                            @endif

                        </a>
                        <div class=" ul2  bg-w  text-left ">

                            <div class=" ul2  bg-w  text-left ">


                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                                    <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        {{ $properties['native'] }}
                                    </a>

                                @endforeach
                            </div>

                        </div>
                    </div>
                    <a class="nav-link  border-bottom" href="{{ route('policy') }}">@lang('site.privacy_policy')</a>
                    <a class="nav-link  border-bottom" href="{{ route('checkout') }}"> @lang('site.payment')</a>
                    <a class="nav-link  border-bottom" href="{{ route('contact.us') }}">@lang('site.contact_us')</a>
                    <a class="nav-link  border-bottom" href="{{ route('checkout') }}">@lang('site.checkout')</a>
                    <a class="nav-link  border-bottom" href="{{ route('cart') }}">@lang('site.shopping_cart')</a>
                    @guest()
                    <a class="nav-link  border-bottom" href="{{ route('login') }}"> @lang('site.login')</a>

                @else

                    <a class="nav-link  border-bottom" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                        <div><span> log out</span></div>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest
                </div>


            </div>

            <div>
                @auth
                    <a class="nav-link p-0" href="{{ route('/') }}" style="padding-top: 12px;;margin-left:10px"> <img
                            src="{{ asset('/storage/' . $my_setting->logo) }}" width="60"></a>
                @endauth
                @guest
                    <a class="nav-link p-0" href="{{ route('/') }}" style="padding-top: 12px"> <img
                            src="{{ asset('/storage/' . $my_setting->logo) }}" width="60"></a>

                @endguest

            </div>

            <!--islam here-->

            {{-- <div class="nav-item relative ul1"  id="cart-hover"  ><a class="nav-link " > --}}

            {{-- @lang('site.cart') / --}}
            {{--  --}}{{-- {{Session::has('cart_details')?Session::get('cart_details')['totalPrice']." DK":''}} --}}
            {{-- <i --}}
            {{-- class="fas fa-weight-hanging" ></i> --}}
            {{-- <sup --}}
            {{-- class="badge"> --}}
            {{-- {{Session::has('cart_details')? --}}
            {{-- Session::get('cart_details')['totalQty'] ." items":0}} --}}
            {{-- </sup> --}}


            {{-- </a> --}}
            {{-- <div class=" ul2  bg-w  text-right " style="padding: 10px;width: 300px"> --}}

            {{-- <div  id="cart-items"> </div> --}}

            {{-- <a href="{{route('product.shoppingCart')}}" --}}
            {{-- class="btn bg-main w-100">@lang('site.view_cart')</a> --}}
            {{-- <br><br> --}}
            {{-- <a href="{{route('checkout')}}" class="btn bg-main w-100"> --}}
            {{-- Check out --}}
            {{-- </a> --}}
            {{-- </div> --}}
            {{-- </div> --}}


            <ul class="navbar nav pad-0">
                @auth()
                    <li class="nav-item ">
                        <a class="nav-link " href="{{ route('myaccount') }}"> <i class="fas fa-user sml-fa"
                                style=""></i> </a>
                    </li>
                @endauth

                <li class="nav-item"><a class="nav-link " href="{{ route('cart') }}"><i
                            class="fas fa-shopping-cart sml-fa" style="font-size: 25px"></i><span
                            class='badge badge-warning' id='lblCartCount'>
                            {{ Session::has('cart_details') ? Session::get('cart_details')['totalQty'] : '0' }}
                        </span>
                    </a> </li>


            </ul>

        </div>
    </nav>
    <a  class="whats-app" href="https://wa.me/{{ $my_setting->whatsapp }}" target="_blank"
        title="whatsapp">
        <i class="fab fa-whatsapp my-float"></i>
    </a>
    <div id="content-container">

    </div>

    <script>
        $('#search-submit').on('click', function(e) {
            e.preventDefault();
            console.log('xxx');

            //TODO :: CALL AJAX

            let id = $('#id').val();
            let cat_or_sub = $('#cat_or_sub').val();
            let search = $('#search-word').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: 'GET',
                url: '{{ url('/searching') }}',
                data: {
                    id: id,
                    cat_or_sub: cat_or_sub,
                    search: search,
                },
                success: function(data) {
                    // $("#msg").html(data.msg);
                    console.log(data);
                    $('#content-container').html(data)

                }
            });
        })

        $('#search-submit2').on('click', function(e) {
            e.preventDefault();
            console.log('clicked');

            //TODO :: CALL AJAX

            let id = $('#id2').val();
            let cat_or_sub = $('#cat_or_sub2').val();
            let search = $('#search-word2').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: 'GET',
                url: '{{ url('/searching') }}',
                data: {
                    id: id,
                    cat_or_sub: cat_or_sub,
                    search: search,
                },
                success: function(data) {
                    // $("#msg").html(data.msg);
                    console.log(data);
                    $('#content-container').html(data)

                }
            });


        })
        $('#search-submit3').on('click', function(e) {
            e.preventDefault();

            //TODO :: CALL AJAX

            let id = $('#id2').val();
            let cat_or_sub = $('#cat_or_sub2').val();
            let search = $('#search-word3').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: 'GET',
                url: '{{ url('/searching') }}',
                data: {
                    id: id,
                    cat_or_sub: cat_or_sub,
                    search: search,
                },
                success: function(data) {
                    // $("#msg").html(data.msg);

                    //TODO :: CLOSE NAV BAR
                    console.log(data);
                    $('#content-container').html(data)

                }
            });


        })
    </script>
