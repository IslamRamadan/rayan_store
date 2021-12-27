@extends('layouts.front')
@section('title')
    @lang('site.home')

@endsection
@section('content')
    <!-----start  --->

    <br><br>

    <div class="container-fluid">
        <br>
        <h2 class="text-center  d-flex justify-content-between">
            <b></b>
            <span class="">@lang('site.best_selling')

            </span>
            <b></b>
        </h2>
        <br>
        <br>
        <div class="owl-carousel owl-two owl-theme" id="one">
            @if ($best_sell->count()>0)
                @foreach ($best_sell as $b)
                <div class="item best-sell">
                    <div class="row dir-rtl" style="height:45vh">
                        <div class="col-6 p-0 res-wid">
                            <a href="{{ route('product', $b->id) }}">
                                <img src="{{ asset('/storage/' . $b->img) }}" style="width: 100%;height:100%">
                            </a>
                        </div>
                        <div class=" col-6 p-2 text-dir m-auto">
                            <h5 class="font-weight-bold">
                                <a href="{{ route('product', $b->id) }}">
                                    @if (Lang::locale() == 'ar')
                                    {{ $b->title_ar }}

                                @else
                                    {{ $b->title_en }}


                                @endif
                                </a>
                            </h5>
                            <p><a href="{{ route('product', $b->id) }}">


                                @if (Lang::locale() == 'ar')
                                    {{-- {{$p->basic_category->name_ar}}
                                        -
                                        {{$p->category->name_ar}} --}}
                                    <?php $pieces = explode(' ', $b->description_ar);
                                    $first_part = implode(' ', array_splice($pieces, 0, 4)); ?>
                                    {{ $first_part }}
                                @else

                                    {{-- {{$p->basic_category->name_en}}
                                        -
                                        {{$p->category->name_en}} --}}
                                    <?php $pieces = explode(' ', $b->description_en);
                                    $first_part = implode(' ', array_splice($pieces, 0, 4)); ?>
                                    {{ $first_part }}
                                @endif


                            </a></p>
                            <div class="d-flex justify-content-between">
                                @if ($b->has_offer == 1)
                                <h6 class="font-small" class="font-weight-bold  " style="text-decoration: line-through">
                                        @auth()
                                        {{ Auth::user()->getPrice($b->before_price) }}
                                        {{ Auth::user()->country->currency->code }}
                                    @endauth
                                    @guest()
                                        @if (Cookie::get('name'))
                                            {{ number_format($b->before_price / App\Country::find(Cookie::get('name'))->currency->rate, 2) }}
                                            {{-- {{ App\Country::find(Cookie::get('name'))->currency->code }} --}}
                                            @lang('site.kwd')
                                        @else
                                            {{ $b->before_price }}
                                            @lang('site.kwd')
                                        @endif
                                    @endguest
                                </h6>
                                @endif
                                <h5 class="font-weight-bold  ">
                                    @auth()
                                    {{ Auth::user()->getPrice($b->price) }}
                                    {{ Auth::user()->country->currency->code }}
                                @endauth
                                @guest()
                                    @if (Cookie::get('name'))
                                        {{ number_format($b->price / App\Country::find(Cookie::get('name'))->currency->rate, 2) }}
                                        {{-- {{ App\Country::find(Cookie::get('name'))->currency->code }} --}}
                                        @lang('site.kwd')
                                    @else
                                        {{ $b->price }} @lang('site.kwd')

                                    @endif
                                @endguest
                                </h5>


                            </div>
                            <a href="{{ route('product', $b->id) }}" class="btn btn-dark text-light font-weight-bold" style="background: #f13582;border:none">
                            @lang('site.add_to_cart')
                            </a>
                        </div>

                    </div>
                </div>
                @endforeach
            @endif


        </div>
    </div>
    <br> <br>
    <div class="col-md-6 col-10 col-sm-12 col-xs-12 text-dir" style="margin: auto;">
        <h3 class="account-table-head">@lang('site.contact_us')</h3>
        <br>
        <div id="successmessage2" class="success" style="width:100%;display:none;text-align:center"></div>




    <form enctype="multipart/form-data" class="personal-detail form-vertical"
          id="loginform"  style="margin: auto" action="{{route('contact.us')}}" method="post">
            @csrf

                <div class="form-group">
                    <label for="name" class="type-text w-100">
                        @lang('site.name') *
                    </label>
                        <input class="form-control placeholder-fix" value="{{ old('name') }}"  type="text" name="name" id="name">
                </div>
                <div class="form-group">
                    <label for="email"  class="type-text w-100">

                        @lang('site.email')

                    </label>
                    <input value="{{ old('email') }}"  type="text" name="email"
                           class="form-control placeholder-fix" id="email">
                </div>


                <div class="form-group">
                    <label for="phone"  class="type-text w-100">
                        {{--                       class="col-md-4 col-form-label text-md-right"--}}
                        @lang('site.phone') </label>


                    <input id="phone" type="text"  class="form-control placeholder-fix"  name="phone" value="{{ old('phone') }}" required autocomplete="name" autofocus>

                </div>



                <div class="form-group">
                    <label for="subject"  class="type-text w-100"
                        {{--                       class="col-md-4 col-form-label text-md-right"--}}
                    >
                        @lang('site.subject')
                    </label>


                    <input id="subject" type="text"  class="form-control placeholder-fix"
                           name="subject" value="{{ old('subject') }}" autofocus>

                </div>

                <div class="form-group">
                    <label for="body"  class="type-text w-100"
                        {{--                       class="col-md-4 col-form-label text-md-right"--}}
                    >

                    </label>


                    <textarea id="body" rows="5"  class="form-control placeholder-fix"
                              name="body" autofocus>
                    {{ old('body') }}
                </textarea>

                </div>


                <button type="submit" class="btn btn-dark">
                    save
                </button>

        </form>


</div>

    <br><br><br>
    <!--- end  --->
@endsection
<script src="{{ asset('front/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{asset('front/assets/js/owl.carousel.min.js')}}"></script>

<script>

    console.log('ok');
    $('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    responsive:{
        0:{
            items:2,
            nav:true
        },
        600:{
            items:3,
            nav:false
        },
        1080:{
            items:3,
            nav:true,

        }
    }
});
</script>
