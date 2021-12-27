@extends('dashboard.layouts.app')
@section('page_title')  @lang('site.add_color')  @endsection

@section('content')
    <form class="card col-md-6 col-12" style="margin: auto" action="{{route('colors.store')}}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="card-body">

            <div class="form-group">
                <label for="name_ar">

                    @lang('site.name_arabic')

                </label>
                <input value="{{ old('name_ar') }}"  type="text" name="name_ar"
                       class="form-control @error('name_ar') is-invalid @enderror" id="name_ar">
            </div>

            <div class="form-group">
                <label for="name_en">

                    @lang('site.name_english')

                </label>
                <input value="{{ old('name_en') }}"  type="text" name="name_en"
                       class="form-control @error('name_en') is-invalid @enderror" id="name_en">
            </div>





            {{-- <div class="form-group">
                <label for="code">

                    @lang('site.country_code')   [ Like 00965 ]

                </label>
                <input value="{{ old('code') }}"  type="number" name="code"
                       class="form-control @error('code') is-invalid @enderror" id="code">
            </div> --}}


        </div>

            <button type="submit" class="btn btn-primary">
                @lang('site.save')

            </button>

    </form>
@endsection
