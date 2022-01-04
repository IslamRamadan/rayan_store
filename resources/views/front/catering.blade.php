@extends('layouts.front')
@section('title')
    @lang('site.home')

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
                {{-- <a href="#" class="heart addToWishList text-white" data-product-id="{{ $product->id }}">
                    <i class="far fa-heart "></i>
                </a> --}}
                {{-- </div><!----> --}}


                <div id="carouselExampleIndicators" class="carousel slide carousel1 " data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            {{-- <div class="  zoom "><a href="" data-toggle="modal" data-target="#zoom"><i
                                        class="fas fa-expand-alt"></i></a></div> --}}

                            <img data-enlargeable src="{{ asset('/storage/' . $product->img) }}"
                                class="d-block w-100 h1-img" alt="..." data-toggle="modal" data-target="#staticBackdrop">
                        </div>
                        {{-- <div class="carousel-item"> --}}
                        {{-- <img src="{{asset('/storage/'.$product->height_img)}}" class="d-block w-100 h1-img" alt="..." data-toggle="modal" data-target="#staticBackdrop"> --}}
                        {{-- <div class="  zoom "><a href=""  data-toggle="modal" data-target="#zoom2"><i class="fas fa-expand-alt"></i></a></div> --}}

                        {{-- </div> --}}

                        @if ($product->images->count() > 0)
                            @foreach ($product->images as $img)
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
                    style="width:100%;margin-top:10px;z-index: 10;list-style: none;justify-content:center">
                    <br>



                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="">
                        <img src=" {{ asset('/storage/' . $product->img) }}" class="img">
                    </li><br>
                    {{-- <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""> --}}
                    {{-- <img src=" {{asset('/storage/'.$product->height_img)}}"  class="img"> --}}
                    {{-- </li><br> --}}
                    @if ($product->images->count() > 0)
                        @foreach ($product->images as $img)

                            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index + 1 }}"
                                class="">
                                <img src="{{ asset($img->img) }}" class="img">
                            </li><br>

                        @endforeach
                    @endif
                </ol>

                {{-- <div class="owl-carousel owl-theme">
                    <div class="item" data-target="#carouselExampleIndicators" data-slide-to="0"><h4>
                        <img src=" {{ asset('/storage/' . $product->img) }}" class="img">
                        </h4></div>
                        @if ($product->images->count() > 0)
                        @foreach ($product->images as $img)
                    <div class="item" data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index + 1 }}"><h4>
                        <img src="{{ asset($img->img) }}" class="img">
                                            </h4></div>
                                            @endforeach
                                            @endif

                </div> --}}

            </div>

            <div class="col-sm-12  product-dir">

                <br>
                <h6 class="text-dir  h6-product">
                    @if (Lang::locale() == 'ar')
                        {{ $product->title_ar }}
                    @else
                        {{ $product->title_en }}

                    @endif


                </h6>
                <br>
                <h6 class="text-dir" style="font-size: 17px">
                    @if (Lang::locale() == 'ar')
                        {{ $product->description_ar }}
                    @else
                        {{ $product->description_en }}
                    @endif

                </h6>
                <br>

                <h6 class="text-dir h6-product">

                    @guest()
                        @if (Cookie::get('name'))
                            {{ number_format($product->price / App\Country::find(Cookie::get('name'))->currency->rate, 2) }}
                            {{-- {{ App\Country::find(Cookie::get('name'))->currency->code }} --}}
                            @lang('site.kwd')

                        @else
                            {{ $product->price }}
                            @lang('site.kwd')
                        @endif

                    @else
                        {{ Auth::user()->getPrice($product->price) }}
                        {{ Auth::user()->country->currency->code }}
                    @endguest
                </h6>


                <br>


                <br>
                @if (Lang::locale() == 'ar')
                    <br>
                @endif

                <div class="panel-body text-dir">
                    <div>
                        <p><strong>يكفي: </strong>١٠٠ شخص مع إمكانية إضافة العدد</p>
                        <p><strong>المشروبات:</strong> (لكل شخص: ١ مشروب)</p>
                        <ul>
                            <li>قهوة ساخنة وباردة: لاتيه إسباني ولاتيه الفانيلا ولاتيه الكراميل المملح وأمريكانو ولاتيه
                                وكورتادو وإسبريسو</li>
                            <li>مشروبات ساخنة: شوكولاتة ساخنة مملحة وشوكولاتة ساخنة وشوكولاتة ساخنة مبشورة وكرك وشاي أخضر
                            </li>
                        </ul>
                        <p><strong>الخدمة وطريقة التقديم:</strong> ١ باريستا وأكوب استهلاكية مع غلاف للأكواب</p>
                        <p><strong>ملاحظة: </strong>الستيشن غير متوفر للسرداب والطوابق العلوية إلا في حالة وجود مصعد</p>
                    </div>
                    <div class="row menu-requirements text-center justify-content-around">
                        <div class="col-xs-4"><i class="fas fa-tachometer-alt fa-3x"></i>
                            <p class="item-title">وقت التجهيز</p>
                            <p class="item-text"> 30 دقيقة</p>
                        </div>
                        <div class="col-xs-4"><i class="fas fa-cog fa-3x"></i>
                            <p class="item-title">المتطلبات</p>
                            <div>
                                <p dir="ltr" class="item-text">توصيلات كهربائية</p>
                            </div>
                        </div>
                        <div class="col-xs-4"><i class="fas fa-clock fa-3x"></i>
                            <p class="item-title">الحد الأقصى</p>
                            <p class="item-text">3 ساعة </p>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="panel-body">
                    <div class="text-center">
                        <h3 class="section-title">
                            الإضافات
                            <span class="tip uppercase text-grey">(اختياري)</span>
                        </h3>
                    </div>
                    <div class="item-group">
                        <div class="row header">
                            <div class="pull-left">
                                <h3>ساعات إضافية</h3>
                            </div>
                            <!---->
                        </div>
                        <div class="row item-section">
                            <div class="col-xs-6 col-sm-8 d-flex">
                                <p class="name">١ ساعة</p>
                            </div>
                            <div class="col-xs-6 col-sm-4">
                                <div class="no-padding row justify-content-between">
                                    <div class="col-xs-7 no-padding">
                                        <p class="price hidden-xs">+ 15.000 د.ك</p>
                                    </div>
                                    <div class="col-xs-5">
                                        <form class=" product-count " method="post"
                                            style="display: flex;flex-direction: column;align-items: center">
                                            @csrf
                                            <div class="form-group"
                                                style="display: flex;align-items: center;justify-content: center">
                                                <a rel="nofollow" class="btn btn-default btn-minus" href="#"
                                                    onclick="">&ndash;</a>
                                                <input type="number"
                                                    style="width: 40px; border: 0;border-radius: 10px ; text-align:center"
                                                    class="count" value="1" name="quantity">
                                                <a rel="nofollow" class="btn btn-default btn-plus" href="#" onclick="">+</a>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item-group">
                        <div class="row header">
                            <div class="pull-left">
                                <h3>خدمات إضافية</h3>
                            </div>
                            <!---->
                        </div>
                        <div class="row item-section">
                            <div class="col-xs-6 col-sm-8 d-flex">
                                <p class="name">١ باريستا</p>
                            </div>
                            <div class="col-xs-6 col-sm-4">
                                <div class="no-padding row justify-content-between">
                                    <div class="col-xs-7 no-padding">
                                        <p class="price hidden-xs">+ 20.000 د.ك</p>
                                    </div>
                                    <div class="col-xs-5">
                                        <form class=" product-count " method="post"
                                            style="display: flex;flex-direction: column;align-items: center">
                                            @csrf
                                            <div class="form-group"
                                                style="display: flex;align-items: center;justify-content: center">
                                                <a rel="nofollow" class="btn btn-default btn-minus" href="#"
                                                    onclick="">&ndash;</a>
                                                <input type="number"
                                                    style="width: 40px; border: 0;border-radius: 10px ; text-align:center"
                                                    class="count" value="1" name="quantity">
                                                <a rel="nofollow" class="btn btn-default btn-plus" href="#" onclick="">+</a>
                                            </div>
                                            {{-- <button class="col-12 text-center" --}}
                                            {{-- type="submit" --}}
                                            {{-- style="background-color: transparent;border: 0;"> --}}
                                            {{-- <a   class=""><i class="fas fa-archive active"  ></i></a> --}}
                                            {{-- </button> --}}
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div>
                        <div class="text-center">
                            <h3 class="section-title"><span>طلبات خاصة</span></h3>
                        </div>
                        <div class="form-group"><textarea placeholder="طلبات إضافية اختيارية" aria-label="طلبات خاصة"
                                class="form-control"></textarea></div>
                    </div>
                    <div class="row text-dir">
                        <div class="col-xs-12 col-sm-8"><label for="chkFemaleService" class="checkbox-inline"><input
                                    id="chkFemaleService" type="checkbox" class="checkbox-round"> <span
                                    class="checkbox-text">طلب الخدمة النسائية (على حسب التوفر)</span></label>
                            <!---->
                        </div>
                        <div class="col-xs-12 col-sm-4 checkbox-price">
                            <!---->
                        </div>
                    </div>
                </div>

                <br><br>
                <form class=" product-count float-right d-none">
                    <a rel="nofollow" class="btn btn-default btn-minus" href="#" title="Subtract">&ndash;</a>
                    <input type="text" disabled="" size="2" autocomplete="off"
                        class="cart_quantity_input form-control grey count" value="1" name="quantity">
                    <a rel="nofollow" class="btn btn-default btn-plus" href="#" title="Add" style="margin: -9px;">+</a>
                </form>

                <a id="add_cart" class="btn bg-main hv "
                    style="margin:10px 0px;">@lang('site.add_to_cart')</a>



            </div>
        </div>

    </div>
    <!--- end  ---><br>


    <!-- Button trigger modal -->



@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#heights').hide();
            let sizeVal;

            $('input[name="size"]').on('click', function() {

                $('#heights').hide();
                // console.log($(this).val())
                //TODO :: ON CLICK IF CHECKED VIEW THE HEIGHTS ELSE MAKE CONTAINER HIDDEN

                if ($('input[name=size]').is(':checked')) {
                    var card_type = $("input[name=size]:checked").val();
                    sizeVal = card_type;
                    getHeights(sizeVal);
                }
            });
            //TODO :: GET #S ->CONTENT
            $('#add_cart').on('click', function() {


                //GET PRODUCT ID
                //GET QUANTITY
                //GET SIZE ID
                //GET HEIGHT ID


                let size = $('#size_val').find(":selected").val();
                let height = 0;
                let product = '{{ $product->id }}';
                let quantity = $("input[name=quantity]").val();
                let basic_type = '{{ $product->basic_category->type }}';


                //TODO :: IF NOT SELECTED HEIGHT OR SIZE ASK TO CHOOSE
                if (basic_type == 1) {
                    size = 0;
                }
                // if ($('input[name=size]').is(':checked')) {
                //     size = $("input[name=size]:checked").val();
                // }

                // if ($('input[name=height]').is(':checked')) {
                //     height = $("input[name=height]:checked").val();
                // }

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
                    success: function(result) {
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
                    error: function(error) {


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
                    success: function(result) {
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
                title: 'Added successfully!',
                confirmButtonColor: '#d76797',
                position:'bottom-start',
                showCloseButton: true,
                showConfirmButton: false,
                timer: 1500
                })
                $(".heart").click(function() {
                $(this).toggleClass("heart-hover");

                });

                }
                else {
                // alert('This product already in you wishlist');
                Swal.fire({
                title: 'This product already in you wishlist',
                icon: '?',
                confirmButtonColor: '#d76797',
                position:'bottom-start',
                showCloseButton: true,
                showConfirmButton: false,
                timer: 1500
                });
                $(".heart").click(function() {
                $(this).toggleClass("heart-hover");

                });


                }
                }
                });
            @endauth


        });
    </script>
    <script>
        $('img[data-enlargeable]').addClass('img-enlargeable').click(function() {
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
            }).click(function() {
                removeModal();
            }).appendTo('body');
            //handling ESC
            $('body').on('keyup.modal-close', function(e) {
                if (e.key === 'Escape') {
                    removeModal();
                }
            });
        });
    </script>
@endsection
