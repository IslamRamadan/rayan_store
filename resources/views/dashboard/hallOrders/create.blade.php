@extends('dashboard.layouts.app')
@section('page_title')      @lang('site.contact_add') @endsection
@section('content')
    <form class="card col-md-6 col-12" style="margin: auto" action="{{route('contact_us.store')}}" method="post">
        @csrf

        <div class="card-body">

            <div class="form-group">
                <label for="name">

                    @lang('site.client_name')

                </label>
                <input value="{{ old('name') }}"  type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror" id="name">
            </div>
            <div class="form-group">
                <label for="email">

                    @lang('site.email')

                </label>
                <input value="{{ old('email') }}"  type="text" name="email"
                       class="form-control @error('email') is-invalid @enderror" id="email">
            </div>


            <div class="form-group">
                <label for="phone"
{{--                       class="col-md-4 col-form-label text-md-right"--}}
                >                    @lang('site.phone')
                </label>


                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="name" autofocus>

            </div>



            <div class="form-group">
                <label for="subject"
                    {{--                       class="col-md-4 col-form-label text-md-right"--}}
                >
                @lang('site.subject')
                </label>


                <input id="subject" type="text" class="form-control @error('subject') is-invalid @enderror"
                       name="subject" value="{{ old('subject') }}" autofocus>

            </div>

            <div class="form-group">
                <label for="body"
                    {{--                       class="col-md-4 col-form-label text-md-right"--}}
                >
                    @lang('site.body')

                </label>


                <textarea id="body" rows="5" class="form-control @error('body') is-invalid @enderror"
                       name="body" autofocus>
                    {{ old('subject') }}
                </textarea>

            </div>


        </div>

            <button type="submit" class="btn btn-primary">
                @lang('site.save')

            </button>

    </form>
@endsection
