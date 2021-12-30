<footer class="container-fluid dir-rtl">
    <div class="container">
        <div class="row res-mobile text-dir">

            <div class="col-lg-3 col-md-6 mb-6 col-sm-6 mb-lg-0 pr-4 pl-3 text-dir">
                <div class="footer-head">

                <h5 class="font-weight-bold">@lang('site.customer_services')
                </h5>
                </div>
                <p class="brdr-btm"> <a href="{{ route('policy') }}"> @lang('site.privacy_policy') </a>
                <p class="brdr-btm"> <a href="{{ route('contact.us') }}"> @lang('site.contact_us') </a>
                <p class="brdr-btm"> <a href="{{ route('wishlist.view') }}"> @lang('site.mywishlist') </a>
                <p class="brdr-btm"> <a href="{{ route('checkout') }}"> @lang('site.payment') </a>


            </div>
            <div class="col-lg-3 col-md-6 mb-6 col-sm-6 mb-lg-0 pr-4 pl-3 text-dir">
                <div class="footer-head">
                <h5 class="font-weight-bold">@lang('site.branches')
                </h5>
                </div>
                <p class="brdr-btm"><span class="font-weight-bold">@lang('site.address1') &nbsp;</span> <br> <a href=""> @lang('site.address_one') </a>
                <p class="brdr-btm"><span class="font-weight-bold">@lang('site.address2') &nbsp;</span> <br> <a href=""> @lang('site.address_two') </a>



            </div>
            <div class="col-lg-3 col-md-6 mb-6 col-sm-6 mb-lg-0 pr-4 pl-2 text-dir">
                <div class="footer-head">
                    <h5 class="font-weight-bold">@lang('site.direct_contact')
                    </h5>

                </div>
                <p class="brdr-btm font-weight-bold" style="font-size: 20px"> <a href=""> {{$my_setting->phone}} </a>
                <p class="brdr-btm font-weight-bold" style="font-size: 20px"> <a href=""> {{$my_setting->whatsapp}} </a>

            </div>
            <div class="col-lg-3 col-md-6 mb-6 col-sm-6 mb-lg-0">
                <div class="text-center">
                <img src="{{ asset('/storage/' . $my_setting->footer_logo) }}"  alt="" width="140" class="mb-3">
                    </div>
                {{-- <p class="font-italic text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt.</p> --}}
                <ul class="list-inline mt-4 text-center" style="direction: ltr">
                    @if (\App\Settings::all()->first()->whatsapp)
                        <li class="list-inline-item"><a href="https://wa.me/{{ $my_setting->whatsapp }}" target="_blank"
                                title="whatsapp"><i class="fab fa-whatsapp fa-3x" style="color:#0cff3c"></i></a></li>
                    @endif
                    @if (\App\Settings::all()->first()->instagram)
                        <li class="list-inline-item"><a href="{{ $my_setting->instagram }}" target="_blank"
                                title="instagram"><i class="fab fa-instagram fa-3x" style="color:#fc79b5"></i></a></li>
                    @endif
                    @if (\App\Settings::all()->first()->twitter)
                        <li class="list-inline-item"><a href="{{ $my_setting->twitter }}" target="_blank"
                                title="snapchat"><i class="fab fa-snapchat-ghost fa-3x" style="color:#d5d334
                                "></i></a></li>
                    @endif

                </ul>
            </div>

        </div>
    </div>

</footer>
<div class="container-fluid pad-0 bg-dark  text-center">
    <div class="container  ">
        <br>
        <p class="c-w mr-0">Copyright 2021 © MASAHA 13
            Design by <a target="_blank" href="https://bluezonekw.com/">bluezone</a>
        </p>
        <br>
    </div>
</div>



<script src="{{ asset('front/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('front/js/popper.min.js') }}"></script>
<script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('front/js/all.min.js') }}"></script>
<script src="{{ asset('front/js/wow.min.js') }}"></script>
{{-- <script src="{{ asset('front/js/owl.carousel.min.js') }}"></script> --}}

<script>
    new WOW().init();
</script>
<script src="{{ asset('front/js/main-js.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/js/slick.min.js') }}"></script>
<script src="{{ asset('front/js/counterup.min.js') }}"></script>
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script>
    $(document).ready(function() {

        // jQuery counterUp
        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });

        $('.MyServices').slick({
            autoplay: true,
            dots: true,
            autoplaySpeed: 2000,
            centerMode: false,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [{
                    breakpoint: 1260,
                    settings: {
                        arrows: false,
                        slidesToShow: 5
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        arrows: false,
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 576,
                    settings: {
                        arrows: false,
                        slidesToShow: 2
                    }
                }
            ]
        });


    });
</script>
<script>
    var swiper = new Swiper(".mySwiper", {
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            // when window width is >= 480px
            770: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            // when window width is >= 640px
            1000: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        },
        freeMode: true,
        // autoplay: {
        //     delay: 1500,
        // },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
    var swiper = new Swiper(".mySwiper1", {
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            // when window width is >= 480px
            770: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            // when window width is >= 640px
            1000: {
                slidesPerView: 4,
                spaceBetween: 30
            }
        },
        freeMode: true,
        // autoplay: {
        //     delay: 1500,
        // },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    $('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})

</script>


{{-- slider ismail start --}}
{{-- <script src="{{asset('front/assets/js/jquery.min.js')}}"></script> --}}
{{-- <script src="{{asset('front/assets/js/bootstrap.min.js')}}"></script> --}}
<script src="{{asset('front/assets/js/owl.carousel.min.js')}}"></script>
{{-- <script src="{{asset('front/assets/js/mixitup.min.js')}}"></script> --}}
<script src="{{asset('front/assets/js/meanmenu.min.js')}}"></script>
<script src="{{asset('front/assets/js/main.js')}}"></script>
<script>
    $('.owl-one').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    // autoplay:true,
    lazyLoad:true,
    autoWidth:true,

    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:2,
            nav:false
        },
        1080:{
            items:6,
            nav:true,
            loop:true
        }
    }
});
    $('.owl-two').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    // autoplay:true,
    lazyLoad:true,
    // autoWidth:true,

    responsive:{
        0:{
            items:1,
            nav:false
        },
        600:{
            items:2,
            nav:false
        },
        1080:{
            items:3,
            nav:true,
            loop:true
        }
    }
});

// $('.owl-slider').owlCarousel({
//     loop: false,
//         margin: 10,

//         responsive: {
//             0: {
//                 items: 1,
//                 nav: true
//             },
//             600: {
//                 items: 1,
//                 nav: false
//             },
//             1000: {
//                 items: 3,
//                 nav: true,
//                 loop: false
//             }
//         }
// });
$('.owl-three').owlCarousel({
    loop:true,
    margin:10,
    responsiveClass:true,
    // autoplay:true,
    lazyLoad:true,
    autoWidth:true,

    responsive:{
        0:{
            items:1,
            nav:true
        },
        600:{
            items:2,
            nav:false
        },
        1080:{
            items:1,
            nav:true,
            loop:true
        }
    }
});

$('.owl-four').owlCarousel({
    loop:true,
    margin:10,
    rtl:true,
    nav:true,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    }});

$('.owl-five').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }});
</script>
{{-- slider ismail end --}}

@yield('script')
</body>

</html>
