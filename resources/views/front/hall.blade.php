@extends('layouts.front')
@section('title')
    @lang('site.home')

@endsection
@section('content')
    <!-----start  --->
    <br><br>

    <div class="container mt-sm-5">
        <div class="row dir-rtl justify-content-center">
            <div class="col-md-9 product pad-0">
                {{-- <div class="  heart "> --}}
                {{-- <i class="far fa-heart "></i></div> --}}

                {{-- <div class="   "> --}}
                {{-- <a href="#" class="heart addToWishList text-white" data-product-id="{{ $hall->id }}">
                    <i class="far fa-heart "></i>
                </a> --}}
                {{-- </div><!----> --}}


                <div id="carouselExampleIndicators" class="carousel slide carousel1 " data-ride="carousel">
                    <div class="carousel-inner custom">
                        <div class="carousel-item active">
                            {{-- <div class="  zoom "><a href="" data-toggle="modal" data-target="#zoom"><i
                                        class="fas fa-expand-alt"></i></a></div> --}}

                            <img data-enlargeable src="{{ asset('/storage/' . $hall->img) }}" class="d-block w-100 h1-img"
                                alt="..." data-toggle="modal" data-target="#staticBackdrop">
                        </div>
                        {{-- <div class="carousel-item"> --}}
                        {{-- <img src="{{asset('/storage/'.$hall->height_img)}}" class="d-block w-100 h1-img" alt="..." data-toggle="modal" data-target="#staticBackdrop"> --}}
                        {{-- <div class="  zoom "><a href=""  data-toggle="modal" data-target="#zoom2"><i class="fas fa-expand-alt"></i></a></div> --}}

                        {{-- </div> --}}

                        @if ($hall->images->count() > 0)
                            @foreach ($hall->images as $img)
                                <div class="carousel-item">
                                    <img data-enlargeable src="{{ asset($img->img) }}" class="d-block w-100 h1-img"
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
                    style="width:100%;margin-top:10px;list-style: none;justify-content:center">
                    <br>


                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="">
                        <img src=" {{ asset('/storage/' . $hall->img) }}" class="img">
                    </li>
                    <br>

                    @if ($hall->images->count() > 0)
                        @foreach ($hall->images as $img)

                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index + 1 }}"
                                class="">
                                <img src="{{ asset($img->img) }}" class="img">
                            </li><br>

                        @endforeach
                    @endif
                </ol>


            </div>

            <div class="col-sm-9  product-dir"> {{-- <div class="is-divider"></div> --}}
                <br>
                <h6 class="text-dir  h6-product">
                    @if (Lang::locale() == 'ar')
                        {{ $hall->title_ar }}
                    @else
                        {{ $hall->title_en }}

                    @endif


                </h6>
                <br>
                <h6 class="text-dir" style="font-size: 17px">
                    @if (Lang::locale() == 'ar')
                        {{ $hall->description_ar }}
                    @else
                        {{ $hall->description_en }}
                    @endif

                </h6>
                {{-- <div class="is-divider"></div> --}}
                <br>
                {{-- <a href="{{asset('front/img/size.jpeg')}}"> <img src="{{asset('front/img/size.jpeg')}}" --}}
                {{-- onerror="this.onerror=null;this.src='{{asset('front/img/5.jpg')}}'" --}}
                {{-- class="w-100">  </a> --}}
                <h6 class="text-dir h6-product">
                    <span>@lang('site.total_price'): &nbsp;&nbsp;</span>
                    @guest()
                        @if (Cookie::get('name'))
                            <span id="t_price"> {{ number_format($hall->price / App\Country::find(Cookie::get('name'))->currency->rate, 2) }}</span>
                            {{-- {{ App\Country::find(Cookie::get('name'))->currency->code }} --}}
                            @lang('site.kwd')

                        @else
                        <span id="t_price"> {{ $hall->price }}</span>
                            @lang('site.kwd')
                        @endif

                    @else
                    <span id="t_price"> {{ Auth::user()->getPrice($hall->price) }}</span>
                        {{ Auth::user()->country->currency->code }}
                    @endguest
                </h6>

                <br>

                <form method="post" action="{{ route('hall.order', $hall->id) }}">
                    @csrf
                    <div class="input-group date date_gap" data-provide="datepicker" style="
            border-bottom-width: 5px;
            padding-bottom: 10px;

        ">
                        <span>@lang('site.start_date')</span>
                        <div style="
            padding-left: 5px;
            padding-right: 5px;
        "><input type="date" class="form-control" id="start_date" name="start_date" style="
            /* width: 5px; */
        " required value="{{ old('start_date') }}"></div>
                    </div>

                    <div class="input-group date " data-provide="datepicker" style="
            border-bottom-width: 5px;
            padding-bottom: 10px;
            gap:20%
        ">
                        <span>@lang('site.end_date')</span>
                        <div style="
            padding-left: 5px;
            padding-right: 5px;
        "><input type="date" class="form-control" id="end_date" name="end_date" style="
            /* width: 5px; */
        " required value="{{ old('end_date') }}"></div>
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
                                    id="Orders_email" value="{{ old('email') }}" type="email">
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
                                    style="color:red">@lang('site.country') <span class="required">*</span></label>
                                <select style="height: 45px;    ;" class="form-control" name="country_id"
                                    value="{{ old('country_id') }}" id="Orders_country_id">

                                    @foreach (\App\Country::all() as $country)

                                        <option value="{{ $country->id }}"
                                            {{ Request::old('country_id') == $country->id ? 'selected' : '' }}>
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
                                <select style="height: 45px; " class="form-control" name="city_id" id="Orders_city_id">
                                </select>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="Orders_address_line1" class="required font-weight-bold" style="color:red">
                                    @lang('site.block')
                                    <span class="required">*</span></label>
                                <input class="form-control" placeholder="{{ \Lang::get('site.block') }}" name="block"
                                    id="block" value="{{ old('block') }}" type="number">
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="Orders_address_line1" class="required font-weight-bold" style="color:red">
                                    @lang('site.floor')
                                    <span class="required">*</span></label>
                                <input class="form-control" placeholder="{{ \Lang::get('site.floor') }}" name="floor"
                                    id="floor" value="{{ old('floor') }}" type="number">
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="Orders_address_line1" class="required font-weight-bold" style="color:red">
                                    @lang('site.street')
                                    <span class="required">*</span></label>
                                <input class="form-control" placeholder="{{ \Lang::get('site.street') }}" name="street"
                                    id="street" value="{{ old('street') }}" type="street">
                            </div>
                            <div class="form-group col-12">
                                <label for="Orders_address_line1" class="required font-weight-bold" >
                                    @lang('site.note')
                                    </label>
                                <textarea placeholder="{{\Lang::get('site.additional_orders')}}"

                                class="form-control" name="note"></textarea>
                            </div>
                            <div class="form-group col-12">
                                <h4 class="text-center">
                                    <span>@lang('site.total_price'): &nbsp;&nbsp;</span>
                                    <span id="t_price1"></span> @lang('site.kwd')
                                </h6>
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


    <!-- Button trigger modal -->


@endsection

@section('script')
    <script>
        // $('#checkout_now').on('click', function() {
        //     $(this).hide();
        //     $("#checkout").css("display", "block");

        // });
    </script>

    <script>
        $(document).ready(function() {




            $('#checkout_now').on('click',
                function() {
                //     console.log('clicked');
                    checkDate();



            }
            )



            function checkDate() {
                var date1 = $('#start_date').val().split("-");
                day1 = date1[2];
                month1 = date1[1];
                year1 = date1[0];

                var date2 = $('#end_date').val().split("-");
                day2 = date2[2];
                month2 = date2[1];
                year2 = date2[0];

                var start_date = year1 +"-"+ month1 +"-"+ day1;
                var end_date = year2 +"-"+ month2 +"-"+ day2;
                var hall_price="{{$hall->price}}"

                var startDate = new Date($('#start_date').val());
                var endDate = new Date($('#end_date').val());
                var difference =  endDate.getTime()-startDate.getTime();
                var days = Math.ceil(difference / (1000 * 3600 * 24));
                var total_price = hall_price*(days+1) ;
                console.log(days,hall_price,total_price);




                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('check.date') }}",
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        start_date: start_date,
                        end_date: end_date
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

                            // $('#Orders_city_id').html(result.cities)
                                $("#checkout_now").hide();
                                $("#checkout").css("display", "block");
                                $('#t_price').html(total_price);
                                $('#t_price1').html(total_price);
                                $("#start_date").prop("readonly", true);
                                $("#end_date").prop("readonly", true);







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
