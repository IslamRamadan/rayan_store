@extends('layouts.front')
@section('title')
    @lang('site.home')

@endsection
@section('content')

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
                        style="height: 70vh">
                    @if (app()->getLocale() == 'en')
                        <div class="abs w-100">
                            <p class="c-w mr-0">{{ $one->description_en }}</p>
                            <h1 class=""> {{ $one->name_en }}</h1>
                            <button class=" btn btn-danger">@lang('site.shop_now') <i class="far fa-heart"></i></button>
                    </div> @else
                        <div class="abs w-100">
                            <p class="c-w mr-0">{{ $one->description_ar }}</p>
                            <h1 class=""> {{ $one->name_ar }}</h1>
                            <button class=" btn btn-danger">@lang('site.shop_now') <i class="far fa-heart"></i></button>
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
    <!-----start  --->
    <div class="container ">
        <div class="row dir-rtl text-dir">
            <div class="col-md-4 center">
                <h2 style="margin-top: 20px">
                    @if (app()->getLocale() == 'en')
                        {{ $category->name_en }}
                    @else
                        {{ $category->name_ar }}
                    @endif
                </h2>
                <nav class="navbar navbar-expand pad-0 center">
                    <ul class="navbar-nav center" style="padding-inline-start: 0px">
                        <li class="nav-item "><a class="nav-link c-light" href="{{ route('/') }}">

                                @if (app()->getLocale() == 'en')
                                    HOME /
                                @else
                                    الرئيسيه /
                                @endif
                            </a></li>
                        {{-- <li class="nav-item "> --}}

                        @if ($type == 1)
                            <li class="nav-item ">

                                @if (app()->getLocale() == 'en')
                                    <a class="nav-link " href="{{ route('category', [$type, $category->id]) }}">

                                        {{ $category->name_en }}
                                    </a>
                                @else
                                    <a class="nav-link " href="{{ route('category', [$type, $category->id]) }}">

                                        {{ $category->name_ar }}
                                    </a>
                                @endif

                            </li>

                        @else

                            @if (app()->getLocale() == 'en')
                                <li class="nav-item ">

                                    <a class="nav-link c-light"
                                        href="{{ route('category', [1, $category->basicCategory->id]) }}">
                                        {{ $category->basicCategory->name_en }} /
                                    </a>
                                </li>

                                <li class="nav-item ">

                                    <a class="nav-link " href="{{ route('category', [$type, $category->id]) }}">
                                        {{ $category->name_en }}
                                    </a>
                                </li>

                            @else
                                <li class="nav-item ">

                                    <a class="nav-link c-light"
                                        href="{{ route('category', [1, $category->basicCategory->id]) }}">
                                        {{ $category->basicCategory->name_ar }} /
                                    </a>
                                </li>

                                <li class="nav-item ">

                                    <a class="nav-link " href="{{ route('category', [$type, $category->id]) }}">
                                        {{ $category->name_ar }}
                                    </a>
                                </li>

                            @endif

                        @endif

                        {{-- </li> --}}
                    </ul>
                </nav>
            </div>
            {{-- <div class="d-md-none d-block w-100"> --}}
            {{-- <div class="text-center"> --}}
            {{-- <div class="toggler1   "> --}}
            {{-- <i class=" fas fa-bars" style="font-size: 18px"></i> filtter --}}
            {{-- </div> --}}
            {{-- <br> --}}
            {{-- <select class=" border"> --}}
            {{-- <option> --}}
            {{-- Default sorting --}}
            {{-- </option> --}}
            {{-- <option> --}}
            {{-- Sort by popularity --}}
            {{-- </option> --}}
            {{-- <option>sort by latest</option> --}}
            {{-- <option>sort by price : low to high</option> --}}
            {{-- <option>sort by price : high to low</option> --}}
            {{-- </select> --}}
            {{-- <br><br> <br></div> --}}
            {{-- <div class="sidbar1"> --}}
            {{-- <div class="close-sidbar1"> --}}
            {{-- <i class=" fas fa-times" style="font-size: 18px"></i> --}}
            {{-- </div> --}}
            {{-- <h3>CATEGORIES</h3> --}}
            {{-- <div class="is-divider"></div> --}}
            {{-- <a href="category.html" class="nav-link border-bottom pad-0"> abayat --}}
            {{-- <div class="float-right c-light">(103)</div> --}}
            {{-- </a> --}}
            {{-- <a href="category.html" class="nav-link border-bottom pad-0"> bisht abaya --}}
            {{-- <div class="float-right c-light">(43)</div> --}}
            {{-- </a> --}}
            {{-- <a href="category.html" class="nav-link border-bottom pad-0"> blazer abaya --}}
            {{-- <div class="float-right c-light">(103)</div> --}}
            {{-- </a> --}}
            {{-- <a href="category.html" class="nav-link border-bottom pad-0"> outfit --}}
            {{-- <div class="float-right c-light">(103)</div> --}}
            {{-- </a> --}}
            {{-- <a href="category.html" class="nav-link border-bottom pad-0"> summer abaya --}}
            {{-- <div class="float-right c-light">(103)</div> --}}
            {{-- </a> --}}
            {{-- <a href="category.html" class="nav-link border-bottom pad-0"> winter abaya --}}
            {{-- <div class="float-right c-light">(103)</div> --}}
            {{-- </a> --}}
            {{-- <br> --}}
            {{-- <h4>RECENTLY VIEWED --}}
            {{-- </h4> --}}
            {{-- <div class="is-divider"></div> --}}
            {{-- <div class=" row"> --}}
            {{-- <div class="col-3 pad-0"> --}}
            {{-- <img src="{{asset('front/img/11.jpg')}}" width="50"> --}}
            {{-- </div> --}}
            {{-- <div class="col-9"> --}}
            {{-- <h6><a href="product.html" class="main-color">CH-L1 </a></h6> --}}
            {{-- <h5>30.000 @lang('site.kwd') --}}
            {{-- </h5></div> --}}
            {{-- </div> --}}
            {{-- <hr> --}}
            {{-- <div class="  row"> --}}
            {{-- <div class="col-3 pad-0"> --}}
            {{-- <img src="{{asset('front/img/11.jpg')}}" width="50"><br><br> --}}
            {{-- </div> --}}
            {{-- <div class="col-9"> --}}
            {{-- <h6><a href="product.html" class="main-color">CH-L1 </a></h6> --}}
            {{-- <h5>30.000 @lang('site.kwd') --}}
            {{-- </h5></div> --}}


            {{-- </div> --}}


            {{-- </div> --}}

            {{-- </div> --}}

            {{-- <div class="col-md-8 text-left  d-md-block d-none "> --}}
            {{-- <br> --}}
            {{-- <span class=""> --}}
            {{-- Showing all 5 results</span> --}}
            {{-- <select class=" border"> --}}
            {{-- <option> --}}
            {{-- Default sorting --}}
            {{-- </option> --}}
            {{-- <option> --}}
            {{-- Sort by popularity --}}
            {{-- </option> --}}
            {{-- <option>sort by latest</option> --}}
            {{-- <option>sort by price : low to high</option> --}}
            {{-- <option>sort by price : high to low</option> --}}
            {{-- </select> --}}

            {{-- </div> --}}
        </div>
    </div>

    <div class="container">
        <div class="row dir-rtl">


            <div class="col-lg-3 col-md-4 d-md-block d-none ">
                @if ($type == 1)
                    <a style="font-size: 20px;display: flex;
                            justify-content: space-between;align-items: center;flex-direction:row-reverse"
                        data-toggle="collapse" href="#collapseExample" aria-expanded="false"
                        aria-controls="collapseExample">

                        <i class="fas fa-chevron-down"></i>

                        <span>
                            @lang('site.categories')
                        </span>
                    </a>

                    <div class="collapse" id="collapseExample">

                        <div class="is-divider"></div>

                        @if ($category->categories->count() > 0)
                            @foreach ($category->categories as $c)
                                <a href="{{ route('category', [2, $c->id]) }}" class="nav-link border-bottom pad-0">
                                    @if (app()->getLocale() == 'en')
                                        {{ $c->name_en }}
                                    @else
                                        {{ $c->name_ar }}
                                    @endif
                                    <div class="float-right c-light">(
                                        {{ $c->products->count() }}
                                        )
                                    </div>
                                </a>
                            @endforeach
                        @endif


                    </div>
                @endif
                <br>
                <h4 class="text-dir">@lang('site.best_selling')
                </h4>
                <div class="is-divider"></div>
                @if ($last_views->count() > 0)

                    @foreach ($last_views as $b)

                        @if ($b)
                            {{-- @if ($b->product) --}}
                            <div class=" row text-dir">
                                <div class="col-3 pad-0">
                                    <a href="{{ route('product', $b->id) }}"><img
                                            src="{{ asset('/storage/' . $b->img) }}"
                                            onerror="this.onerror=null;this.src='{{ asset('front/img/5.jpg') }}'"
                                            style="width: 100%"></a>
                                </div>
                                <div class="col-9">
                                    <h6 style="font-weight:bold"><a href="{{ route('product', $b->id) }}"
                                            class="main-color">
                                            @if (Lang::locale() == 'ar')
                                                {{ $b->title_ar }}

                                            @else
                                                {{ $b->title_en }}


                                            @endif


                                        </a></h6>
                                    <h5>

                                        @auth()
                                            {{ Auth::user()->getPrice($b->price) }}
                                            {{ Auth::user()->country->currency->code }}
                                        @endauth
                                        @guest()
                                            @if (Cookie::get('name'))
                                                {{ number_format($b->price / App\Country::find(Cookie::get('name'))->currency->rate, 2) }}
                                                {{ App\Country::find(Cookie::get('name'))->currency->code }}
                                                {{-- @lang('site.kwd') --}}
                                            @else
                                                {{ $b->price }} @lang('site.kwd')

                                            @endif
                                        @endguest
                                    </h5>
                                </div>
                            </div>
                            <hr>
                            {{-- @endif --}}
                        @endif


                    @endforeach
                @endif
            </div>
            <div class="col-lg-9 col-md-8 pad-0 ">
                <div class="row text-center">
                    @if ($category->products->count() > 0)
                        @foreach ($category->products as $p)
                            @if ($p)
                                @if ($p->appearance == 1)

                                    <div class="col-6 col-md-6 col-lg-4">
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
                                                        <img src="{{ asset($img->img) }}" width="100%"
                                                            class="hide-img image">
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

                {{-- <nav aria-label="Page navigation example  "> --}}
                {{-- <ul class="pagination justify-content-center"> --}}
                {{-- <li class="page-item"> --}}
                {{-- <a class="page-link"><i class="fas fa-angle-right  main-color" style="font-size: 20px;"></i> --}}
                {{-- </a> --}}
                {{-- </li> --}}
                {{-- <li class="page-item"><a class="page-link">1</a></li> --}}
                {{-- <li class="page-item"><a class="page-link">2</a></li> --}}
                {{-- <li class="page-item"><a class="page-link">3</a></li> --}}


                {{-- <li class="page-item "> --}}
                {{-- <a class="page-link"> <i class="fas fa-angle-left main-color" style="font-size: 20px;"></i></a> --}}
                {{-- </li> --}}
                {{-- </ul> --}}
                {{-- </nav> --}}
            </div>
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
