@extends('layouts.front')
@section('title')
    @lang('site.home')

@endsection
@section('content')
    <!-----start  --->
    <br><br>

    <div class="container">
        <div class="row dir-rtl">
            <div class="col-md-6 product pad-0">
                {{-- <div class="  heart "> --}}
                {{-- <i class="far fa-heart "></i></div> --}}

                {{-- <div class="   "> --}}
                {{-- <a href="#" class="heart addToWishList text-white" data-product-id="{{ $hall->id }}">
                    <i class="far fa-heart "></i>
                </a> --}}
                {{-- </div><!----> --}}


                <div id="carouselExampleIndicators" class="carousel slide carousel1 " data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            {{-- <div class="  zoom "><a href="" data-toggle="modal" data-target="#zoom"><i
                                        class="fas fa-expand-alt"></i></a></div> --}}

                            <img data-enlargeable src="{{ asset('/storage/' . $hall->img) }}"
                                 class="d-block w-100 h-img" alt="..." data-toggle="modal"
                                 data-target="#staticBackdrop">
                        </div>
                        {{-- <div class="carousel-item"> --}}
                        {{-- <img src="{{asset('/storage/'.$hall->height_img)}}" class="d-block w-100 h-img" alt="..." data-toggle="modal" data-target="#staticBackdrop"> --}}
                        {{-- <div class="  zoom "><a href=""  data-toggle="modal" data-target="#zoom2"><i class="fas fa-expand-alt"></i></a></div> --}}

                        {{-- </div> --}}

                        @if ($hall->images->count() > 0)
                            @foreach ($hall->images as $img)
                                <div class="carousel-item">
                                    <img data-enlargeable src="{{ asset($img->img) }}" class="d-block w-100 h-img"
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

            <div class="col-sm-5 ml-auto product-dir"> {{-- <div class="is-divider"></div> --}}
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

                    @guest()
                        @if (Cookie::get('name'))
                            {{ number_format($hall->price / App\Country::find(Cookie::get('name'))->currency->rate, 2) }}
                            {{-- {{ App\Country::find(Cookie::get('name'))->currency->code }} --}}
                            @lang('site.kwd')

                        @else
                            {{ $hall->price }}
                            @lang('site.kwd')
                        @endif

                    @else
                        {{ Auth::user()->getPrice($hall->price) }}
                        {{ Auth::user()->country->currency->code }}
                    @endguest
                </h6>

                <br>

                <form method="post" action="{{ route('hall.order', $hall->id) }}">
                    @csrf
                    <div class="input-group date justify-content-between" data-provide="datepicker" style="
        border-bottom-width: 5px;
        padding-bottom: 10px;
    ">
                        <span>بدايه الحجز</span>
                        <div style="
        padding-left: 5px;
        padding-right: 5px;
    "><input type="date" class="form-control" id="start_date" name="start_date" style="
        /* width: 5px; */
    " required></div>
                    </div>

                    <div class="input-group date justify-content-between" data-provide="datepicker" style="
        border-bottom-width: 5px;
        padding-bottom: 10px;
    ">
                        <span>نهايه الحجز</span>
                        <div style="
        padding-left: 5px;
        padding-right: 5px;
    "><input type="date" class="form-control" id="end_date" name="end_date" style="
        /* width: 5px; */
    " required></div>
                    </div>

                    <button type="submit" id="add_cart" class="btn bg-main hv" style="margin:10px 0px;background-color: #c49b63;">@lang('site.book_now')</button>
                </form>
            </div>
        </div>

    </div>
    <!--- end  ---><br>


    <!-- Button trigger modal -->


@endsection
@section('script')
    <script>
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            startDate: '-3d'
        });


        $(document).ready(function () {


            //TODO :: GET #S ->CONTENT
            $('#add_cart').on('click', function () {


                //GET PRODUCT ID
                //GET QUANTITY
                //GET SIZE ID
                //GET HEIGHT ID


                let size = $('#size_val').find(":selected").val();
                let height = 0;
                let hall = '{{ $hall->id }}';
                let end_date = $("input[name=end_date]").val();
                let start_date = $("input[name=end_date]").val();


                //TODO :: IF NOT SELECTED HEIGHT OR SIZE ASK TO CHOOSE


                if ((basic_type != 1 && size == 0)) {
                    Swal.fire({
                        icon: '?',
                        title: 'يرجي تحديد الخيارات ',
                        confirmButtonColor: '#d76797',
                        position: 'bottom-start',
                        showCloseButton: true,
                    })
                } else {
                    // console.log("ok");
                    addToCart(product, quantity, height, size);
                }

            });

            function addToCart(productId, quantity, heightId, sizeId) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('add.to.cart') }}",
                    method: 'post',
                    data: {
                        _token: "{{ csrf_token() }}",
                        quantity: quantity,
                        product_id: productId,
                        product_size_id: sizeId,
                        product_height_id: heightId,
                    },
                    success: function (result) {
                        //CHECK SIZE VALUES
                        //CHECK HEIGHTS VALUE
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: 'تمت الإضافه الي السله',
                            animation: false,
                            position: 'bottom-start',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });
                        // console.log(result);

                        // location.reload();


                    },
                    error: function (error) {


                        console.log(error);
                        Swal.fire({
                            title: 'لم تكتمل العمليه ',
                            icon: '?',
                            confirmButtonColor: '#d76797',
                            position: 'bottom-start',
                            showCloseButton: true,
                        })
                        // Swal.fire({
                        //         title: 'لم تكتمل العمليه ',
                        //         icon: '؟',
                        //         iconHtml: '؟',
                        //         confirmButtonText: 'ok',
                        //         showCancelButton: false,
                        //         showCloseButton: true
                        //         })
                    }
                });
            }

            function getHeights(sizeId) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('get.heights') }}",
                    method: 'get',
                    data: {
                        size_id: sizeId
                    },
                    success: function (result) {
                        //CHECK SIZE VALUES
                        //CHECK HEIGHTS VALUE
                        // console.log(result);
                        $('#heights').html(result);
                        $('#heights').show();
                    }
                });
            }

            //TODO :: WHEN CHOOSE SIZE SHOW HEIGHT
            //TODO :: REFRESH CHECKOUT CART
            //TODO :: ADD & REMOVE FROM CART
        })

        $(document).on('click', '.addToWishList', function (e) {

            e.preventDefault();
            @guest()
            // $('.not-loggedin-modal').css('display','block');
            // console.log('You are guest'

            {{-- {{\RealRashid\SweetAlert\Facades\Alert::error('error', 'Please Login first!')}} --}}
            Swal.fire({
                icon: '?',
                title: 'Login first!',
                confirmButtonColor: '#d76797',
                position: 'bottom-start',
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
                            icon: '?',
                            title: 'Added successfully!',
                            confirmButtonColor: '#d76797',
                            position: 'bottom-start',
                            showCloseButton: true,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $(".heart").click(function () {
                            $(this).toggleClass("heart-hover");

                        });

                    } else {
                        // alert('This product already in you wishlist');
                        Swal.fire({
                            title: 'This product already in you wishlist',
                            icon: '?',
                            confirmButtonColor: '#d76797',
                            position: 'bottom-start',
                            showCloseButton: true,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $(".heart").click(function () {
                            $(this).toggleClass("heart-hover");

                        });


                    }
                }
            });
            @endauth


        });
    </script>
    <script>
        $('img[data-enlargeable]').addClass('img-enlargeable').click(function () {
            var src = $(this).attr('src');
            var modal;

            function removeModal() {
                modal.remove();
                $('body').off('keyup.modal-close');
            }

            modal = $('<div>').css({
                background: 'RGBA(0,0,0,.5) url(' + src + ') no-repeat center',
                backgroundSize: 'contain',
                width: '100%',
                height: '100%',
                position: 'fixed',
                zIndex: '10000',
                top: '0',
                left: '0',
                cursor: 'zoom-out'
            }).click(function () {
                removeModal();
            }).appendTo('body');
            //handling ESC
            $('body').on('keyup.modal-close', function (e) {
                if (e.key === 'Escape') {
                    removeModal();
                }
            });
        });
    </script>
@endsection
