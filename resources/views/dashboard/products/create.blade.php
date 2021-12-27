@extends('dashboard.layouts.app')
@section('page_title') @lang('site.add_product')
@endsection

@section('content')
    {{-- {{dd($sizes)}} --}}
    <form class="card col-md-12 col-12" style="margin: auto" action="{{ route('products.store') }}" method="post"
        enctype="multipart/form-data">
        @csrf

        <div class="card-body text-dir">


            <div class="d-flex justify-content-center">
                <div class="form-group">
                    <div class="col-md-12 d-flex justify-content-center ">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="new" value="1" id="new">

                            <label class="form-check-label" for="new">
                                @lang('site.new_arrival')
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-md-12 d-flex justify-content-center ">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="appearance" value="1" id="appearance"
                                {{ old('appearance') ? 'checked' : '' }}>

                            <label class="form-check-label" for="appearance">
                                @lang('site.appear')
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group " id="has_offer1">
                    <div class="col-md-12 d-flex justify-content-center ">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="has_offer" value="1" id="has_offer"
                                {{ old('has_offer') ? 'checked' : '' }}
                                >

                            <label class="form-check-label" for="has_offer">
                                @lang('site.has_offer')
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-md-12 d-flex justify-content-center ">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="best_selling" value="1" id="best_selling"
                                {{ old('best_selling') ? 'checked' : '' }}>

                            <label class="form-check-label" for="best_selling">
                                @lang('site.best_selling')
                            </label>
                        </div>
                    </div>
                </div>
            </div>



            <div class="d-flex flex-wrap">
                <div class="form-group col-6">
                    <label for="basic_category_id" >
                        @lang('site.basic_cat')

                    </label>

                    <select name="basic_category_id" class="form-control @error('basic_category_id') is-invalid @enderror"
                        id="basic_category_id" >
                        <option value="">
                            @lang('site.choose_cat')
                        </option>
                        @foreach ($basic_categories as $basic_category)


                            <option value="{{ $basic_category->id }}" id="test_id" name="{{$basic_category->id}}">
                                {{ $basic_category->name_en }} &nbsp; - &nbsp; {{ $basic_category->name_ar }}
                            </option>


                        @endforeach
                    </select>
                </div>

                <div class="form-group col-6">
                    <label for="category_id">
                        @lang('site.cat')
                    </label>

                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror"
                        id="category_id">
                        {{-- @foreach ($categories as $category) --}}


                        <option value=""></option>


                        {{-- @endforeach --}}
                    </select>
                </div>


                <div class="form-group col-6">
                    <label for="title_ar">
                        @lang('site.title_ar')

                    </label>
                    <input value="{{ old('title_ar') }}" type="text" name="title_ar"
                        class="form-control @error('title_ar') is-invalid @enderror" id="title_ar">
                </div>

                <div class="form-group col-6">
                    <label for="title_en">

                        @lang('site.title_en')

                    </label>
                    <input value="{{ old('title_en') }}" type="text" name="title_en"
                        class="form-control @error('title_en') is-invalid @enderror" id="title_en">
                </div>



                <div class="form-group col-12">
                    <label for="name">

                        @lang('site.description_ar')
                    </label>
                    <textarea name="description_ar" class="form-control @error('description_ar') is-invalid @enderror"
                        id="description_ar">{{ old('description_ar') }}</textarea>
                </div>



                <div class="form-group col-12">
                    <label for="name">

                        @lang('site.description_en')
                    </label>
                    <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror"
                        id="description_ar">{{ old('description_en') }}</textarea>

                </div>

                {{-- <div class="form-group col-2">
                    <label for="colors">

                        @lang('site.colors')


                    </label>
                    <select class="selectpicker" multiple name="color[]">
                        @foreach ($colors as $color)
                        <option value="{{$color->id}}">{{$color->name_ar}}-{{$color->name_en}}</option>
                        @endforeach

                      </select>
                </div> --}}
                <div class="form-group col-2">
                    <label for="before_price">

                        @lang('site.before_price')


                    </label>
                    <input value="" type="text" name="before_price" type="number" step=".01"
                        class="form-control @error('before_price') is-invalid @enderror" id="before_price" disabled>
                </div>

                <div class="form-group col-2">
                    <label for="price">

                        @lang('site.price')


                    </label>
                    <input value="{{ old('price') }}" type="text" name="price" type="number" step=".01"
                        class="form-control @error('price') is-invalid @enderror" id="price">
                </div>
                <div class="form-group col-3" id="size_guide_id1">
                    <label for="basic_category_id">
                        @lang('site.size_guid')

                    </label>

                    <select name="size_guide_id" class="form-control @error('size_guide_id') is-invalid @enderror"
                        id="size_guide_id">
                        <option value="">
                            @lang('site.size_guid')
                        </option>
                        @foreach ($size_guides as $size_guide)


                            <option value="{{ $size_guide->id }}">
                                {{ $size_guide->name_en }} &nbsp; - &nbsp; {{ $size_guide->name_ar }}
                            </option>


                        @endforeach
                    </select>
                </div>
                <div class="form-group col-3" id="qut" style="display:none ">
                    <label for="qut">

                        @lang('site.quantity')


                    </label>
                    <input value="" type="text" name="qut" type="number" step=".01"
                        class="form-control @error('qut') is-invalid @enderror">
                </div>

                <div class="form-group col-3">
                    <label for="photo">

                        @lang('site.img')
                    </label>
                    <input type="file" name="photo" class="form-control">
                </div>
            </div>


            {{-- <div class="form-group"> --}}
            {{-- <label for="size_photo"> --}}

            {{-- @lang('site.size_img') --}}
            {{-- </label> --}}
            {{-- <input type="file" name="size_photo" --}}
            {{-- class="form-control"> --}}
            {{-- </div> --}}


            {{-- <div class="form-group"> --}}
            {{-- <label for="delivery_period"> --}}

            {{-- @lang('site.ship_period') --}}

            {{-- </label> --}}
            {{-- <input value="{{ old('delivery_period') }}"  type="number" name="delivery_period" --}}
            {{-- class="form-control @error('delivery_period') is-invalid @enderror" id="delivery_period"> --}}
            {{-- </div> --}}


            <ul class="align-content-right" style="list-style-type: none" id="size_ul">
                @foreach ($sizes as $size)
                    <li style="margin: 5px 5px 15px 5px">

                        <div class="form-group">

                            <div class="col-md-12 ">
                                <div class="form-check d-flex justify-content-center">

                                    <label class="form-check-label" for="name" style="font-weight: bold">
                                        {{ $size->name }}
                                    </label>
                                    <input class="form-check-input" type="checkbox" value="{{ $size->id }}"
                                        style="margin-left: 15px" name="size[]" {{-- {{ old('size',$size->id) ? 'checked' : '' }} --}}>
                                </div>
                            </div>
                        </div>


                        <div class="d-flex justify-content-left" style="flex-wrap: wrap;margin: 5px">
                            @foreach ($heights as $height)

                                <div class="form-check" style="margin: 10px">
                                    <input class="form-check-input" type="checkbox" name="{{ $size->id }}height[]"
                                        id="height" value="{{ $height->id }}">
                                    <label class="form-check-label" for="height">{{ $height->name }}
                                    </label>

                                    <input type="number"
                                        style="border: 1px solid rgba(0,0,0,0.1) ; border-radius: 10px;padding: 5px;width: 70px"
                                        placeholder="الكميه" name="{{ $size->id }}{{ $height->id }}quantity"
                                        value="">

                                </div>
                            @endforeach

                        </div>

                    </li>
                @endforeach

            </ul>


        </div>
        <select class="js-example-basic-multiple" name="states[]" multiple="multiple">
            <option value="AL">Alabama</option>
              ...
            <option value="WY">Wyoming</option>
          </select>

        <button type="submit" class="btn btn-primary col-6 m-auto mb-5">
            @lang('site.save')
        </button>

    </form>



    <script type="text/javascript">


        $('#basic_category_id').on('change', function(e) {

            console.log(e);
            var cat_id = e.target.value;
            var test= $('#test_id').attr('name')
            console.log('test ID is '+ test);



            $.get('/ajax-subcat?cat_id=' + cat_id, function(data) {
                $('#category_id').empty();
                $.each(data, function(index, subcatObj) {
                    $('#category_id').append('<option value="' + subcatObj.id + '">' + subcatObj
                        .name_en + ' - ' + subcatObj.name_ar + '</option>');
                })
            })


        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('check.cat') }}",
                method: 'post',
                data: {
                    _token: "{{ csrf_token() }}",
                    cat_id: cat_id
                },
                success: function(result) {
                    // console.log(result);

                    if (!result.success) {
                        console.log('no');
                        if (result.cat_type == 1) {
                            $('#size_ul').hide()
                            $('#size_guide_id1').hide()
                            $('#qut').show()
                        }
                        else{
                            $('#size_ul').show()
                            $('#size_guide_id1').show()
                            $('#qut').hide()

                        }

                    } else {

                        if (result.cat_type == 1) {
                            $('#size_ul').hide()
                            $('#size_guide_id1').hide()
                            $('#qut').show()

                        }
                        else{
                            $('#size_ul').show()
                            $('#size_guide_id1').show()
                            $('#qut').hide()

                        }



                        // getDelivery();

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

        });


        $('#basic_category_id').on('change', function(e) {
            var cat_id = e.target.value;

    });




        // when page is ready
        $(document).ready(function() {

            $("#form").on('submit', function() {
                // to each unchecked checkbox
                $(this + 'input[type=checkbox]:not(:checked)').each(function() {
                    // set value 0 and check it
                    $(this).attr('checked', true).val(0);
                });
            })


            $(function() {
                if ($('#has_offer').is(':checked')) {
                        $('#before_price').attr('disabled', false);
                    } else {
                        $('#before_price').attr('disabled', true);
                        $('#before_price').val("");

                    }
                $('#has_offer').on('click', function() {
                    if ($(this).is(':checked')) {
                        $('#before_price').attr('disabled', false);
                    } else {
                        $('#before_price').attr('disabled', true);
                        $('#before_price').val("");

                    }
                });

                $('#has_offer').on('click', function() {
                    // assuming the textarea is inside <div class="controls /">
                    if ($(this).is(':checked')) {
                        $('#before_price input:number, .controls textarea').attr('disabled', false);

                    } else {
                        $('#before_price input:number, .controls textarea').attr('disabled', true);
                        $('#before_price input:number, .controls textarea').val("");

                    }
                });
            });
        })
    </script>




@endsection
