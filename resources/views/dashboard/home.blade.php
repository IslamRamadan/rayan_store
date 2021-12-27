@extends('dashboard.layouts.app')
@section('page_title')  @lang('site.home')  @endsection

@section('style')

    <script src="{{asset('js/app.js')}}" defer></script>

@endsection
@section('content')
    <div class="container-fluid py-4">

        <div class="row mt-2">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <a href="{{route('orders.index')}}">

                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">@lang('site.num_orders')</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{App\Order::where('status','!=',0)->count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <a href="{{route('products.index')}}">

                <div class="card">

                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">@lang('site.num_products')</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{App\Product::count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>

            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <a href="{{route('users.index')}}">

                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">@lang('site.num_users')</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{App\User::count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>

            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <a href="{{route('basic_categories.index')}}">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">@lang('site.num_basic_categories')</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{App\BasicCategory::count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>


        </div>

        <div class="row mt-2">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <a href="{{route('categories.index')}}">

                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">@lang('site.num_categories')</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{App\Category::count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <a href="{{route('countries.index')}}">

                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">@lang('site.num_countries')</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{App\Country::count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            {{--<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">--}}
                {{--<a href="{{route('cities.index')}}">--}}

                {{--<div class="card">--}}
                    {{--<div class="card-body p-3">--}}
                        {{--<div class="row">--}}
                            {{--<div class="col-8">--}}
                                {{--<div class="numbers">--}}
                                    {{--<p class="text-sm mb-0 text-capitalize font-weight-bold">@lang('site.num_cities')</p>--}}
                                    {{--<h5 class="font-weight-bolder mb-0">--}}
                                        {{--{{App\City::count()}}--}}
                                    {{--</h5>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-4 text-end">--}}
                                {{--<div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">--}}
                                    {{--<i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--</a>--}}
            {{--</div>--}}
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <a href="{{route('sizes.index')}}">

                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">@lang('site.num_sizes')</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{App\Size::count()}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <a href="{{route('heights.index')}}">

                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">@lang('site.num_heights')</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{App\Height::count()}}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{--<div class="row mt-2">--}}

        {{--</div>--}}
    </div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

{{--                    <div class="card-header pb-0">--}}
{{--                        <h6>Home</h6>--}}
{{--                    </div>--}}
                    <div class="card-body px-0 pt-0 pb-2">


                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


{{--                        @if(Auth::user()->hasRole('admin'))--}}

{{--welcome admin--}}
{{--                        @else--}}
{{--                    welcome user--}}

                        {{--                        @endif--}}



                        <div class="pd-0">
                            <br>
                            <h6 style="text-align: center">
                                @lang('site.last_ten')
                            </h6>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center justify-content-center mb-0 data-table  text-secondary text-xs ">
                                <thead>
                                <tr>
                        <th>
                            @lang('site.username')
                        </th>
                        <th>
                            @lang('site.email')

                        </th>
                        <th>
                            @lang('site.password')

                        </th>
                                </tr>
                        </thead>
                        <tbody>
                        @foreach(\App\User::where('job_id' , 0)->take(10)->get() as $u)

                            <tr>
                                <td>
                                    {{$u->name}}
                                </td>
                                <td>
                                    {{$u->email}}
                                </td>
                                <td>
                                    {{$u->password_view}}
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

    </div>
    </div>
</div>
@endsection
