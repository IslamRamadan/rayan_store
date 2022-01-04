@extends('dashboard.layouts.app')
@section('page_title') Edit Product : @lang('site.edit_prod'){{ $product->title_ar }} @endsection

@section('style')
    <style>
        .input {
            border: 5px solid black;
        }

    </style>

@endsection
@section('content')
{{-- {{dd($product->basic_category->type)}} --}}
    {{-- {{dd(count($height_products_array[0]))}} --}}
    <input hidden value="{{$product->basic_category->type}}" id="basic_cat_type">
    <form class="card col-md-12 col-12" style="margin: auto" action="{{ route('products.update.product', $product->id) }}"
        method="post" enctype="multipart/form-data">
        @csrf

        <div class="card-body text-right">

            <div class="d-flex justify-content-center">

                <div class="form-group">
                    <div class="col-md-12 d-flex justify-content-center ">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="new" value="1" id="new"
                                @if ($product->new == 1)  {{ 'checked' }} @endif>

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
                                @if ($product->appearance == 1)  {{ 'checked' }} @endif>

                            <label class="form-check-label" for="appearance">
                                @lang('site.appear')
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="col-md-12 d-flex justify-content-center ">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="has_offer" value="1" id="has_offer"
                                @if ($product->has_offer == 1)  {{ 'checked' }} @endif>

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
                                @if ($product->best_selling == 1)  {{ 'checked' }} @endif>

                            <label class="form-check-label" for="best_selling">
                                @lang('site.best_selling')
                            </label>
                        </div>
                    </div>
                </div>
            </div>



            <div class="d-flex flex-wrap">

                <div class="form-group col-6">
                    <label for="basic_category_id">
                        @lang('site.basic_cat')
                    </label>

                    <select name="basic_category_id" class="form-control @error('basic_category_id') is-invalid @enderror"
                        id="basic_category_id">
                        <option value="">
                            @lang('site.choose_cat')
                        </option>
                        @foreach ($basic_categories as $basic_category)


                            <option value="{{ $basic_category->id }}" @if ($basic_category->id == $product->basic_category_id)  {{ 'selected' }} @endif>
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
                        @if ($product->category_id != 0)

                            @foreach ($categories as $category)


                                <option value="{{ $category->id }}" @if ($category->id == $product->category_id)  {{ 'selected' }} @endif>
                                    {{ $category->name_en }} &nbsp; - &nbsp; {{ $category->name_ar }}
                                </option>


                            @endforeach
                        @endif

                    </select>
                </div>

                <div class="form-group col-6">
                    <label for="title_ar">

                        @lang('site.title_ar')

                    </label>
                    <input value="{{ $product->title_ar }}" type="text" name="title_ar"
                        class="form-control @error('title_ar') is-invalid @enderror" id="title_ar">
                </div>

                <div class="form-group col-6">
                    <label for="title_en">

                        @lang('site.title_en')

                    </label>
                    <input value="{{ $product->title_en }}" type="text" name="title_en"
                        class="form-control @error('title_en') is-invalid @enderror" id="title_en">
                </div>

                <div class="form-group col-12">
                    <label for="description_ar">

                        @lang('site.description_ar')
                    </label>
                    <textarea name="description_ar" class="form-control @error('description_ar') is-invalid @enderror"
                        id="description_ar">{{ $product->description_ar }}</textarea>
                </div>

                <div class="form-group col-12">
                    <label for="name">

                        @lang('site.description_en')
                    </label>
                    <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror"
                        id="description_en">{{ $product->description_en }}</textarea>

                </div>


                <div class="form-group col-3">
                    <label for="before_price">

                        @lang('site.before_price')

                    </label>
                    <input value="{{ $product->before_price }}" type="number" step=".01" name="before_price"
                        class="form-control @error('before_price') is-invalid @enderror" id="before_price">
                </div>
                <div class="form-group col-3">
                    <label for="price">

                        @lang('site.price')

                    </label>
                    <input value="{{ $product->price }}" type="number" step=".01" name="price"
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


                            <option value="{{ $size_guide->id }}" @if ($size_guide->id == $product->size_guide_id)  {{ 'selected' }} @endif>
                                {{ $size_guide->name_en }} &nbsp; - &nbsp; {{ $size_guide->name_ar }}
                            </option>


                        @endforeach
                    </select>
                </div>

                <div class="form-group col-3" id="qut"



                >
                    <label for="qut">

                        @lang('site.quantity')


                    </label>
                    <input  type="text" name="qut" type="number" step=".01"
                        class="form-control @error('qut') is-invalid @enderror"
                        @if ($product->basic_category->type == 1)
                        value={{$height_products}}
                        @endif
                        >
                </div>


                <div class="form-group col-3">
                    <label for="photo">

                        @lang('site.img')
                    </label>
                    <input type="file" name="photo" class="form-control">
                </div>
            </div>





            <ul class="align-content-right d-flex justify-content-center" style="list-style-type: none;" id="size1">
                @foreach ($sizes as $size)
                    <li style="margin-bottom: 15px">

                        <div class="form-group">

                            <div class="col-md-6 ">
                                <div class="form-check">

                                    <label class="form-check-label" for="name" style="font-weight: bold;">
                                        {{ $size->name }}
                                    </label>
                                    <input class="form-check-input" type="checkbox" value="{{ $size->id }}"
                                        style="margin-left: 15px" name="size[]" @foreach ($size_products as $size_product)
                                    @if ($size_product == $size->id)  {{ 'checked' }} @endif
                @endforeach
                >
                <input type="number"
                                    style="border: 1px solid rgba(0,0,0,0.1) ; border-radius: 10px;padding: 5px;width: 70px"
                                    placeholder="الكميه" name="{{ $size->id }}quantity"

                                    {{-- @foreach ($size_products as $size_product ) --}}
                                     @for ($i=0;$i<count($height_products_array) ; $i++ )
                                     @if ($size->id == $height_products_array[$i][0]->size_id) value="{{$height_products_array[$i][0]->quantity}}" @endif
                                     @endfor
                                    {{-- @endforeach --}}
                                    >
        </div>
        </div>
        </div>




        </li>
        @endforeach

        </ul>





        <input type="hidden" value="{{ $product->id }}" name="id">




        </div>

        <button type="submit" class="btn btn-primary col-6 m-auto mb-5">
            @lang('site.save')
        </button>

    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
        console.log($("#basic_cat_type").val());
        if ($("#basic_cat_type").val()==1) {
            console.log("value is 1");
            $('#size_guide_id1').hide();
            $('#size1').hide();
        }
        else{
            $('#size_guide_id1').show();
            $('#size1').show();
            $('#qut').hide();
        }


        $('#basic_category_id').on('change', function(e) {

            console.log(e);
            var cat_id = e.target.value;


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
                            $('#size1').hide()
                            $('#size_guide_id1').hide()
                            $('#qut').show()

                        }
                        else{
                            $('#size1').show()
                            $('#size_guide_id1').show()
                            $('#qut').hide()

                        }

                    } else {

                        if (result.cat_type == 1) {
                            $('#size1').hide()
                            $('#size_guide_id1').hide()
                            $('#qut').show()

                                                }
                        else{
                            $('#size1').show()
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

        // when page is ready
        $(document).ready(function() {
            // on form submit
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
