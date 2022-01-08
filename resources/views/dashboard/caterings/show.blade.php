@extends('dashboard.layouts.app')
@section('page_title') Edit Product : @lang('site.show'){{ $catering->title_ar }} @endsection

@section('style')
    <style>
        .input {
            border: 5px solid black;
        }

        label{
            float: left;
        }

    </style>

@endsection
@section('content')

        <div class="card-body text-right">




            <div class="d-flex flex-wrap">

                <div class="form-group col-6">
                    <label for="title_ar">

                        @lang('site.title_ar')

                    </label>
                    <input value="{{ $catering->title_ar }}" type="text" name="title_ar" readonly
                        class="form-control @error('title_ar') is-invalid @enderror" id="title_ar">
                </div>

                <div class="form-group col-6">
                    <label for="title_en">

                        @lang('site.title_en')

                    </label>
                    <input value="{{ $catering->title_en }}" type="text" name="title_en" readonly
                        class="form-control @error('title_en') is-invalid @enderror" id="title_en">
                </div>
                <div class="form-group col-6">
                    <label for="title_ar">

                        @lang('site.hint_ar')

                    </label>
                    <input value="{{ $catering->hint_ar }}" type="text" name="hint_ar" readonly
                        class="form-control @error('hint_ar') is-invalid @enderror" id="hint_ar">
                </div>

                <div class="form-group col-6">
                    <label for="title_en">

                        @lang('site.hint_en')

                    </label>
                    <input value="{{ $catering->hint_en }}" type="text" name="hint_en" readonly
                        class="form-control @error('hint_en') is-invalid @enderror" id="hint_en">
                </div>
                <div class="form-group col-6">
                    <label for="title_ar">

                        @lang('site.requirement_ar')

                    </label>
                    <input value="{{ $catering->requirement_ar }}" type="text" name="requirement_ar" readonly
                        class="form-control @error('requirement_ar') is-invalid @enderror" id="requirement_ar">
                </div>

                <div class="form-group col-6">
                    <label for="title_en">

                        @lang('site.requirement_en')

                    </label>
                    <input value="{{ $catering->requirement_en }}" type="text" name="requirement_en" readonly
                        class="form-control @error('requirement_en') is-invalid @enderror" id="requirement_en">
                </div>
                <div class="form-group col-6">
                    <label for="title_ar">

                        @lang('site.persons_no')

                    </label>
                    <input value="{{ $catering->persons_no }}" type="number" name="persons_no" readonly
                        class="form-control @error('persons_no') is-invalid @enderror" id="persons_no">
                </div>
                <div class="form-group col-6">
                    <label for="title_ar">

                        @lang('site.ad_person_price')

                    </label>
                    <input value="{{ $catering->ad_person_price }}" type="number" name="ad_person_price" readonly
                        class="form-control @error('ad_person_price') is-invalid @enderror" id="ad_person_price">
                </div>

                <div class="form-group col-6">
                    <label for="title_en">

                        @lang('site.price')

                    </label>
                    <input value="{{ $catering->price }}" type="number" name="price" readonly
                        class="form-control @error('price') is-invalid @enderror" id="price">
                </div>
                <div class="form-group col-6">
                    <label for="title_ar">

                        @lang('site.setup_time')

                    </label>
                    <input value="{{ $catering->setup_time }}" type="text" name="setup_time" readonly
                        class="form-control @error('setup_time') is-invalid @enderror" id="setup_time">
                </div>

                <div class="form-group col-6">
                    <label for="title_en">

                        @lang('site.max_time')

                    </label>
                    <input value="{{ $catering->max_time }}" type="text" name="max_time" readonly
                        class="form-control @error('max_time') is-invalid @enderror" id="max_time">
                </div>
                <div class="form-group col-6">
                    <label for="title_ar">

                        @lang('site.ad_hour_price')

                    </label>
                    <input value="{{ $catering->ad_hour_price }}" type="number" name="ad_hour_price" readonly
                        class="form-control @error('ad_hour_price') is-invalid @enderror" id="ad_hour_price">
                </div>

                <div class="form-group col-6">
                    <label for="title_en">

                        @lang('site.ad_service_price')

                    </label>
                    <input value="{{ $catering->ad_service_price }}" type="number" name="ad_service_price" readonly
                        class="form-control @error('ad_service_price') is-invalid @enderror" id="ad_service_price">
                </div>
                <div class="form-group col-6">
                    <label for="title_ar">

                        @lang('site.ad_service_ar')

                    </label>
                    <input value="{{ $catering->ad_service_ar }}" type="text" name="ad_service_ar" readonly
                           class="form-control @error('ad_service_ar') is-invalid @enderror" id="ad_service_ar">
                </div>

                <div class="form-group col-6">
                    <label for="title_en">

                        @lang('site.ad_service_en')

                    </label>
                    <input value="{{ $catering->ad_service_en }}" type="text" name="ad_service_en" readonly
                           class="form-control @error('ad_service_en') is-invalid @enderror" id="ad_service_en">
                </div>

                <div class="form-group col-12">
                    <label for="desc_ar">

                        @lang('site.desc_ar')
                    </label>
                    <div class="row col-md-12">{!! $catering->desc_ar !!}</div>
                </div>

                <div class="form-group col-12">
                    <label for="name">

                        @lang('site.desc_en')
                    </label>
                    <div class="row col-md-12">{!! $catering->desc_en !!}</div>

                </div>
            </div>

        </div>
@endsection
