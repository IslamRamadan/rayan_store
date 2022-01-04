@extends('dashboard.layouts.app')
@section('page_title') Edit Product : @lang('site.edit_prod'){{ $hall->title_ar }} @endsection

@section('style')
    <style>
        .input {
            border: 5px solid black;
        }

    </style>

@endsection
@section('content')

    <form class="card col-md-12 col-12" style="margin: auto" action="{{ route('halls.update.hall', $hall->id) }}"
        method="post" enctype="multipart/form-data">
        @csrf

        <div class="card-body text-right">




            <div class="d-flex flex-wrap">

                <div class="form-group col-6">
                    <label for="title_ar">

                        @lang('site.title_ar')

                    </label>
                    <input value="{{ $hall->title_ar }}" type="text" name="title_ar"
                        class="form-control @error('title_ar') is-invalid @enderror" id="title_ar">
                </div>

                <div class="form-group col-6">
                    <label for="title_en">

                        @lang('site.title_en')

                    </label>
                    <input value="{{ $hall->title_en }}" type="text" name="title_en"
                        class="form-control @error('title_en') is-invalid @enderror" id="title_en">
                </div>

                <div class="form-group col-12">
                    <label for="description_ar">

                        @lang('site.description_ar')
                    </label>
                    <textarea name="description_ar" class="form-control @error('description_ar') is-invalid @enderror"
                        id="description_ar">{{ $hall->description_ar }}</textarea>
                </div>

                <div class="form-group col-12">
                    <label for="name">

                        @lang('site.description_en')
                    </label>
                    <textarea name="description_en" class="form-control @error('description_en') is-invalid @enderror"
                        id="description_en">{{ $hall->description_en }}</textarea>

                </div>


                <div class="form-group col-3">
                    <label for="over_price">

                        @lang('site.over_price')

                    </label>
                    <input value="{{ $hall->over_price }}" type="number" step=".01" name="over_price"
                        class="form-control @error('over_price') is-invalid @enderror" id="over_price">
                </div>
                <div class="form-group col-3">
                    <label for="price">

                        @lang('site.price')

                    </label>
                    <input value="{{ $hall->price }}" type="number" step=".01" name="price"
                        class="form-control @error('price') is-invalid @enderror" id="price">
                </div>


                <div class="form-group col-6">
                    <label for="photo">

                        @lang('site.img')
                    </label>
                    <input type="file" name="photo" class="form-control">
                </div>
            </div>








        <input type="hidden" value="{{ $hall->id }}" name="id">




        </div>

        <button type="submit" class="btn btn-primary col-6 m-auto mb-5">
            @lang('site.save')
        </button>

    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">




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
            });
        })
    </script>
@endsection
