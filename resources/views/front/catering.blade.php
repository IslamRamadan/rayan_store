@extends('layouts.front')
@section('title')
    @lang('site.caterings')

@endsection
@section('content')
    <!-----start  --->
    <br><br>

    <div class="container">
        <div class="row dir-rtl justify-content-center">
            <div class="col-md-12 product pad-0">
                {{-- <div class="  heart "> --}}
                {{-- <i class="far fa-heart "></i></div> --}}

                {{-- <div class="   "> --}}
                {{-- <a href="#" class="heart addToWishList text-white" data-product-id="{{ $catering->id }}">
                    <i class="far fa-heart "></i>
                </a> --}}
                {{-- </div><!----> --}}


                <div id="carouselExampleIndicators" class="carousel slide carousel1 " data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            {{-- <div class="  zoom "><a href="" data-toggle="modal" data-target="#zoom"><i
                                        class="fas fa-expand-alt"></i></a></div> --}}

                            <img data-enlargeable src="{{ asset('/storage/' . $catering->image) }}"
                                 class="d-block w-100 h1-img" alt="..." data-toggle="modal"
                                 data-target="#staticBackdrop">
                        </div>
                        {{-- <div class="carousel-item"> --}}
                        {{-- <img src="{{asset('/storage/'.$catering->height_img)}}" class="d-block w-100 h1-img" alt="..." data-toggle="modal" data-target="#staticBackdrop"> --}}
                        {{-- <div class="  zoom "><a href=""  data-toggle="modal" data-target="#zoom2"><i class="fas fa-expand-alt"></i></a></div> --}}

                        {{-- </div> --}}

                        @if ($catering->images->count() > 0)
                            @foreach ($catering->images as $img)
                                <div class="carousel-item">
                                    <img data-enlargeable src="{{ asset($img->image) }}" class="d-block w-100 h1-img"
                                         alt="..." data-toggle="modal" data-target="#staticBackdrop">
                                    {{-- <div class="  zoom "><a href="" data-toggle="modal" data-target="#zoom3"><i
                                                class="fas fa-expand-alt"></i></a></div> --}}

                                </div>


                            @endforeach
                        @endif


                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev"
                       style="bottom: 25%!important">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">@lang('site.previous')</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next"
                       style="bottom: 25%!important">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">@lang('site.next')</span>
                    </a>
                </div>

                <ol class=" position-relative navbar"
                    style="width:100%;margin-top:10px;z-index: 10;list-style: none;justify-content:center">
                    <br>


                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="">
                        <img src=" {{ asset('/storage/' . $catering->image) }}" class="img">
                    </li>
                    <br>
                    {{-- <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""> --}}
                    {{-- <img src=" {{asset('/storage/'.$catering->height_img)}}"  class="img"> --}}
                    {{-- </li><br> --}}
                    @if ($catering->images->count() > 0)
                        @foreach ($catering->images as $img)

                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index + 1 }}"
                                class="">
                                <img src="{{ asset($img->image) }}" class="img">
                            </li><br>

                        @endforeach
                    @endif
                </ol>

                {{-- <div class="owl-carousel owl-theme">
                    <div class="item" data-target="#carouselExampleIndicators" data-slide-to="0"><h4>
                        <img src=" {{ asset('/storage/' . $catering->img) }}" class="img">
                        </h4></div>
                        @if ($catering->images->count() > 0)
                        @foreach ($catering->images as $img)
                    <div class="item" data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index + 1 }}"><h4>
                        <img src="{{ asset($img->img) }}" class="img">
                                            </h4></div>
                                            @endforeach
                                            @endif

                </div> --}}

            </div>

            <div class="col-sm-12  product-dir">

                <br>
                <h6 class="text-dir  h6-product">{!! $catering['title_'.app()->getLocale()] !!}</h6>
                <br>
                <h6 class="text-dir" style="font-size: 17px">{!! $catering['hint_'.app()->getLocale()] !!}</h6>
                <br>

                <h6 class="text-dir h6-product">{{ $catering->price }} @lang('site.kwd')</h6><br><br>
                @if (Lang::locale() == 'ar')
                    <br>
                @endif

                <div class="panel-body text-dir">

                    <div>{!! $catering['desc_'.app()->getLocale()] !!}</div>
                    <div class="row menu-requirements text-center justify-content-around">
                        <div class="col-xs-4"><i class="fas fa-tachometer-alt fa-3x"></i>
                            <p class="item-title">@lang('site.setup_time')</p>
                            <p class="item-text"> {{ $catering->setup_time }} @lang('site.minute')</p>
                        </div>
                        <div class="col-xs-4"><i class="fas fa-cog fa-3x"></i>
                            <p class="item-title">@lang('site.requirements')</p>
                            <div>
                                <p dir="ltr" class="item-text">{{ $catering['requirement_'.app()->getLocale()] }}</p>
                            </div>
                        </div>
                        <div class="col-xs-4"><i class="fas fa-clock fa-3x"></i>
                            <p class="item-title">@lang('site.max_time')</p>
                            <p class="item-text">{{ $catering->max_time }} @lang('site.hour')</p>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <form method="post" action="{{ route('catering.order', $catering->id) }}">
                    @csrf
                    <div class="panel-body">
                        <div class="text-center">
                            <h3 class="section-title">
                                @lang('site.additionals')
                                {{-- <span class="tip uppercase text-grey">(اختياري)</span> --}}
                            </h3>
                        </div>
                        <div class="item-group">
                            <div class="row header">
                                <div class="pull-left">
                                    <h3>@lang('site.add_persons')</h3>
                                </div>
                                <!---->
                            </div>
                            <div class="row item-section">
                                <div class="col-xs-6 col-sm-8 d-flex">
                                    <p class="name">1 @lang('site.person')</p>
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <div class="no-padding row justify-content-between">
                                        <div class="col-xs-7 no-padding">
                                            <p class="price hidden-xs">+ {{ $catering->ad_person_price }} @lang('site.kwd')</p>
                                        </div>
                                        <div class="col-xs-5">
                                            <div class="form-group"
                                                 style="display: flex;align-items: center;justify-content: center">
                                                <a rel="nofollow" class="btn btn-default btn-minus1" href="#"
                                                   onclick="">&ndash;</a>
                                                <input type="number" readonly
                                                       style="width: 40px; border: 0;border-radius: 10px ; text-align:center"
                                                       class="count1" value="{{$catering->persons_no}}" name="persons_no">
                                                <a rel="nofollow" class="btn btn-default btn-plus1" href="#"
                                                   onclick="">+</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item-group">
                            <div class="row header">
                                <div class="pull-left">
                                    <h3>@lang('site.add_hours')</h3>
                                </div>
                                <!---->
                            </div>
                            <div class="row item-section">
                                <div class="col-xs-6 col-sm-8 d-flex">
                                    <p class="name">1 @lang('site.hourr')</p>
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <div class="no-padding row justify-content-between">
                                        <div class="col-xs-7 no-padding">
                                            <p class="price hidden-xs">+ {{ $catering->ad_hour_price }} @lang('site.kwd')</p>
                                        </div>
                                        <div class="col-xs-5">
                                            <div class="form-group"
                                                 style="display: flex;align-items: center;justify-content: center">
                                                <a rel="nofollow" class="btn btn-default btn-minus" href="#"
                                                   onclick="">&ndash;</a>
                                                <input type="number" readonly
                                                       style="width: 40px; border: 0;border-radius: 10px ; text-align:center"
                                                       class="count" value="0" name="ad_hours">
                                                <a rel="nofollow" class="btn btn-default btn-plus" href="#"
                                                   onclick="">+</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item-group">
                            <div class="row header">
                                <div class="pull-left">
                                    <h3>@lang('site.add_service')</h3>
                                </div>
                                <!---->
                            </div>
                            <div class="row item-section">
                                <div class="col-xs-6 col-sm-8 d-flex">
                                    <p class="name"> {{ $catering['ad_service_'.app()->getLocale()] }}</p>
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <div class="no-padding row justify-content-between">
                                        <div class="col-xs-7 no-padding">
                                            <p class="price hidden-xs">+ {{ $catering->ad_service_price }} @lang('site.kwd')</p>
                                        </div>
                                        <div class="col-xs-5">
                                            <div class="form-group"
                                                 style="display: flex;align-items: center;justify-content: center">
                                                <a rel="nofollow" class="btn btn-default btn-minus" href="#"
                                                   onclick="">&ndash;</a>
                                                <input type="number" readonly
                                                       style="width: 40px; border: 0;border-radius: 10px ; text-align:center"
                                                       class="count" value="0" name="ad_service">
                                                <a rel="nofollow" class="btn btn-default btn-plus" href="#"
                                                   onclick="">+</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div>
                            <div class="text-center">
                                <h3 class="section-title"><span>@lang('site.special_orders')</span></h3>
                            </div>
                            <div class="form-group"><textarea placeholder="{{\Lang::get('site.additional_orders')}}"
                                                              aria-label="طلبات خاصة"
                                                              class="form-control" name="note"></textarea></div>
                        </div>
                        <div class="row text-dir">
                            <div class="col-xs-12 col-sm-8 p-0"><label for="chkFemaleService" class="checkbox-inline p-0"><input
                                        id="chkFemaleService" type="checkbox" class="checkbox-round"
                                        name="request_female" value="1"> <span
                                        class="checkbox-text">@lang('site.lady_service')</span></label>
                                <!---->
                            </div>
                            <div class="col-xs-12 col-sm-4 checkbox-price">
                                <!---->
                            </div>
                        </div>
                    </div>
                    <button type="button" id="checkout_now" class="btn bg-main hv "
                            style="margin:10px 0px;background-color: #c49b63;">@lang('site.checkout_now')</button>
                    <div id="checkout" style="display: none">
                    <div class="row checkout text-dir mt-5">
                    <div class="form-group col-md-6 col-sm-12">
                        <label for="Orders_address_line1" class="required font-weight-bold" style="color:red">
                            @lang('site.full_name')
                            <span class="required">*</span></label>
                        <input class="form-control" placeholder="User Name" name="name" id="Orders_full_name"
                            value="{{ old('name') }}" type="text">
                    </div>

                    <div class="form-group col-md-6 col-sm-12">
                        <label for="Orders_address_line1" class="required font-weight-bold" style="color:red">
                            @lang('site.email') <span class="required">*</span></label>
                        <input class="form-control" placeholder="E-mail" required="required" name="email"
                            id="Orders_email" type="email">
                    </div>
                    <div class="form-group col-md-4 col-sm-12">
                        <label for="Orders_address_line1" class="required font-weight-bold"
                            style="color:red">@lang('site.phone')
                            <span class="required">*</span>
                        </label>
                        <br>
                        <input id="phone_code" class="form-control" required="required" name="phone"
                            value="{{ old('phone') }}" type="number" maxlength="11">
                    </div>
                    <div class="form-group col-md-4 col-sm-12">
                        <label for="Orders_country_id" class="required font-weight-bold"
                            style="color:red">@lang('site.country') <span
                                class="required">*</span></label>
                        <select style="height: 45px;    ;" class="form-control" name="country_id"
                            value="{{ old('country_id') }}" id="Orders_country_id">

                            @foreach (\App\Country::all() as $country)

                                <option value="{{ $country->id }}">
                                    @if (Lang::locale() == 'ar')
                                        {{ $country->name_ar }}

                                    @else
                                        {{ $country->name_en }}


                                    @endif


                                </option>

                            @endforeach


                        </select>

                    </div>

                    <div class="form-group col-md-4 col-sm-12">
                        <label for="Orders_city_id" class="required font-weight-bold" style="color:red">
                            @lang('site.region') <span class="required">*</span></label>
                        <select style="height: 45px; " class="form-control" name="city_id"
                            id="Orders_city_id">
                        </select>
                    </div>
                    <div class="form-group col-md-4 col-sm-12">
                        <label for="Orders_address_line1" class="required font-weight-bold" style="color:red">
                            @lang('site.block')
                            <span class="required">*</span></label>
                        <input class="form-control" placeholder="{{\Lang::get('site.block')}}" name="block" id="block"
                            value="{{ old('block') }}" type="number">
                    </div>
                    <div class="form-group col-md-4 col-sm-12">
                        <label for="Orders_address_line1" class="required font-weight-bold" style="color:red">
                            @lang('site.floor')
                            <span class="required">*</span></label>
                        <input class="form-control" placeholder="{{\Lang::get('site.floor')}}" name="floor" id="floor"
                            value="{{ old('floor') }}" type="number">
                    </div>
                    <div class="form-group col-md-4 col-sm-12">
                        <label for="Orders_address_line1" class="required font-weight-bold" style="color:red">
                            @lang('site.street')
                            <span class="required">*</span></label>
                        <input class="form-control" placeholder="{{\Lang::get('site.street')}}" name="street" id="street"
                            value="{{ old('street') }}" type="street">
                    </div>

                </div>

                    <br><br>
                    <button type="submit" id="add_cart" class="btn bg-main hv "
                            style="margin:10px 0px;background-color: #c49b63;">@lang('site.book_now')</button>
                        </div>
                </form>
            </div>
        </div>

    </div>
    <!--- end  ---><br>

@endsection


@section('script')
<script>
            var person = "{{$catering->persons_no}}"
            var person_max = "{{$catering->persons_max}}"
            $('.btn-plus1').on('click', function() {
                    var $count = $(this).parent().find('.count1');

                    var val = parseInt($count.val(), 10);
                    if($count.val() < person_max){
                        $count.val(val + 1);
                    }
                    return false;
                });
                $('.btn-minus1').on('click', function() {

                    var $count = $(this).parent().find('.count1');
                    var val = parseInt($count.val(), 10);

                    if(val > 0 && $count.val() > person){
                        $count.val(val -1);
                    }
                    return false;
                });
                $('#checkout_now').on('click', function() {
                    $(this).hide();
                    $("#checkout").css("display", "block");

                });


  </script>

    <script>
        $(document).ready(function() {



            getCities();

            $('#Orders_country_id').on('change',
                function() {
                    getCities();
                }
            )


            function getCities() {
                var country = $('#Orders_country_id').val() ? $('#Orders_country_id').val() : 1;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('get.cities') }}",
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        country: country
                    },
                    success: function(result) {
                        // console.log(result);

                        if (!result.success) {
                            Swal.fire({
                                icon: '?',
                                confirmButtonColor: '#d76797',
                                position: 'bottom-start',
                                showCloseButton: true,
                                title: result.msg,
                            })
                        } else {

                            $('#Orders_city_id').html(result.cities)




                        }

                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'لم تكتمل العمليه ',
                            icon: '?',
                            confirmButtonColor: '#d76797',
                            position: 'bottom-start',
                            showCloseButton: true,
                        })
                    }
                });

            }

        })
    </script>


@endsection
