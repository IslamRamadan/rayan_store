
@extends('dashboard.layouts.app')

    @section('page_title')  @lang('site.hallOrders')  @endsection

    @section('style')
        <script src="https://code.jquery.com/jquery-3.6.0.js"
                integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />--}}
        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    @endsection
    @section('content')
        <div class="container">
            <br>
            <div class="card-header pb-0">
                <h6>@lang('site.hallOrders')</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0 data-table  text-secondary text-xs ">
                        <thead>
                        <tr>
                <th width="5%">No</th>
                <th width="10%">@lang('site.user_name')</th>
                <th width="10%">@lang('site.hall_id')</th>
                <th width="10%">@lang('site.start_date')</th>
                <th width="10%">@lang('site.end_date')</th>
                <th width="10%">@lang('site.day_price')</th>
                <th width="10%">@lang('site.days')</th>
                <th width="30%">@lang('site.total_price')</th>
                <th width="30%">@lang('site.action')</th>

            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>

</div>

@endsection

@section('script')
<script type="text/javascript">

    $(document).ready(function () {

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('hallOrders.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'user_id', name: 'user_id'},
                {data: 'hall_id', name: 'hall_id'},
                {data: 'start_date', name: 'start_date'},
                {data: 'end_date', name: 'end_date'},
                {data: 'day_price', name: 'day_price'},
                {data: 'days', name: 'days'},
                {data: 'total_price', name: 'total_price'},
                {data: 'action', name: 'action'},
            ]
        });
    });

</script>
@endsection


