@extends('layouts.front')
@section('title')
    @lang('site.home')

@endsection
@section('content')
    <!-----start carousel --->
    {{-- <div id="carouselExampleIndicators" class="carousel slide relative" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active ">
                <img class=" w-100 h " src="{{ asset('front/img/11.jpeg') }}" alt="1 slide">
                <div class="abs w-100">
                    <p class="c-w mr-0">it has finally started</p>
                    <h1 class=""> Sara Almutairi</h1>
                    <button class=" btn btn-danger">shop now <i class="far fa-heart"></i> </button>
                </div>
            </div>
            <div class="carousel-item  ">
                <img class=" w-100 h " src="{{ asset('front/img/5.jpeg') }}" alt="1 slide">
                <div class="abs w-100">
                    <p class="c-w mr-0">it has finally started</p>
                    <h1 class=""> Sara Almutairi</h1>
                    <button class=" btn btn-danger">shop now <i class="far fa-heart"></i> </button>
                </div>
            </div>
            <div class="carousel-item  ">
                <img class=" w-100 h " src="{{ asset('front/img/8.jpeg') }}" alt="1 slide">
                <div class="abs w-100">
                    <p class="c-w mr-0">it has finally started</p>
                    <h1 class=""> Sara Almutairi</h1>
                    <button class=" btn btn-danger">shop now <i class="far fa-heart"></i> </button>
                </div>
            </div>

        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon " aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div> --}}
    <!-----start  --->
    <div class="container ">
        <div class="row dir-rtl text-dir">
            <div class="col-md-4 center">
                <h2 style="margin-top: 20px">
                    {{-- @if (app()->getLocale() == 'en')
                        {{ $new_arrivals->name_en }} --}}
                    @lang('site.offer')
                    {{-- @else
                        {{ $new_arrivals->name_ar }}
                    @endif --}}
                </h2>
                <nav class="navbar navbar-expand pad-0 center">
                    <ul class="navbar-nav center" style="padding-inline-start: 0px">
                        <li class="nav-item "><a class="nav-link c-light" href="{{ route('/') }}">

                                @if (app()->getLocale() == 'en')
                                    HOME / @lang('site.offer')
                                @else
                                    الرئيسيه / @lang('site.offer')
                                @endif
                            </a></li>





                    </ul>
                </nav>
            </div>

        </div>
    </div>

    <div class="container">
        <div class=" dir-rtl">



            <div class="row text-center">
                @if ($new_arrivals->count() > 0)
                    @foreach ($new_arrivals as $p)
                        @if ($p)
                            @if ($p->appearance == 1)

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
                                                    {{-- {{ App\Country::find(Cookie::get('name'))->currency->code }} --}}
                                                    @lang('site.kwd')
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
                                                    {{-- {{ App\Country::find(Cookie::get('name'))->currency->code }} --}}
                                                    @lang('site.kwd')
                                                @else
                                                    {{ $p->price }}
                                                    @lang('site.kwd')
                                                @endif
                                            @endguest

                                        </h5>
                                        </div>
                                    </div>

                                </div>

                            @endif

                        @endif
                    @endforeach

                @else
                    <h5 style="text-align: center;margin: auto">
                        @lang('site.no_data')
                    </h5>
                @endif

            </div>
            <br><br>


        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                url: "{{ route('wishlist.store') }}",
                data: {
                'productId': $(this).attr('data-product-id'),
                },
                success: function (data) {
                if (data.message) {
                Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Added successfully!',
                showConfirmButton: false,
                timer: 1500
                })
                {{-- {{\RealRashid\SweetAlert\Facades\Alert::error('ok', 'ok!')}} --}}

                } else {
                // alert('This product already in you wishlist');
                Swal.fire({
                position: 'center',
                icon: 'info',
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
