@extends('dashboard.layouts.app')
@section('page_title')  Visitors  @endsection

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


    <script>
        error = false

        function validate() {
            if (document.userForm.name.value != '' && document.userForm.email.value != '' && document.userForm.password.value != '')
                document.userForm.btnsave.disabled = false
            else
                document.userForm.btnsave.disabled = true
        }
    </script>

@endsection
@section('content')

    <div class="container">

        <div class="row mt-2 justify-content-center">
            <div class="col-xl-3 col-sm-6">

                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers dir-rtl ">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">@lang('site.num_visitors')</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{App\Visitor::count()}}
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
            </div>
        </div>
        <div class="card-header pb-0">
            <h6>
            Visitors
            </h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0 data-table  text-secondary text-xs ">
                    <thead>
                    <tr>
                    <th width="5%">No</th>
                    <th width="5%">Id</th>
                    <th width="10%">@lang('site.name')</th>
                    <th width="10%">@lang('site.email')</th>
                    <th width="20%">@lang('site.phone')</th>
                    <th width="10%">@lang('site.region')</th>
                    <th width="10%">@lang('site.num_order')</th>
                    <th width="10%">@lang('site.sum_order')</th>
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
                ajax: "{{ route('visitors') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'region', name: 'region'},
                    {data: 'num_order', name: 'num_order'},
                    {data: 'sum_order', name: 'sum_order'},
                ]
            });


        });

    </script>
@endsection


