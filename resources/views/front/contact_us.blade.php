@extends('layouts.front')
@section('title')
    @lang('site.home')

@endsection
@section('content')
    <!-----start  --->


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


                <button type="submit" class="btn btn-danger">
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
