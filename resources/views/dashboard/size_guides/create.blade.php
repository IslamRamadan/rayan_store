@extends('dashboard.layouts.app')

@section('content')
    <form class="card col-md-6 col-12" style="margin: auto" action="{{route('size_guides.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-header" style="display: flex;justify-content: space-between;align-items: center">
            <h3 >
            @lang('site.add_size_guide')
            </h3>
            {{--            <button class="btn btn-light" >--}}
            {{--                <i class="fas fa-phone-alt"></i>--}}
            {{--                {{Auth::user()->phone}}--}}
            {{--            </button>--}}
        </div>

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


            <div class="form-group">
                <label for="image_url">

                   @lang('site.img')
                </label>
                <input value="{{ old('image_url') }}"  type="file" name="image_url"
                       class="@error('image_url') is-invalid @enderror form-control" id="image_url">
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                @lang('site.save')

            </button>
        </div>
    </form>
@endsection
