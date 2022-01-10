@extends('dashboard.layouts.app')
@section('page_title') Orders / View @endsection

@section('style')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" /> --}}
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
            if (document.userForm.name.value != '' && document.userForm.email.value != '' && document.userForm.password
                .value != '')
                document.userForm.btnsave.disabled = false
            else
                document.userForm.btnsave.disabled = true
        }
    </script>

@endsection
@section('content')

    <div class="container">

        <div class="row">

            <button onclick="window.print();return false;" class="btn btn-primary "> @lang('site.print_page')            </button>
            @if ($order->status == 0)

                <a class="btn btn-danger" style="margin:5px;float: right;font-weight: bolder">

                    @lang('site.not_paid')

                </a>

            @elseif($order->status == 1)

                <a class="btn btn-success" style="margin:5px;float: right;font-weight: bolder"
                    href="{{ route('orders.received', $order->id) }}" id="edit-user">

                    تم الدفع

                </a>

            @elseif($order->status == 2)
                <a class="btn btn-success" style="margin:5px;float: right;font-weight: bolder">
                    @lang('site.received')

                </a>

            @endif

        </div>

        <br />
        <div class="row m-auto text-dir dir-rtl">
            {{-- <div class="col-lg-12 margin-tb" style="text-align: center"> --}}
            <div class="col-4">
                <h6 style="font-weight: bold">
                    @lang('site.username')

                </h6>

                <p class="text text-primary">
                    {{ $order->name }}
                </p>
            </div>

            <div class="col-4">
                <h6 style="font-weight: bold">
                    @lang('site.email')

                </h6>

                <p class="text text-primary">
                    {{ $order->email }}
                </p>
            </div>

            <div class="col-4">
                <h6 style="font-weight: bold">
                    @lang('site.phone')

                </h6>

                <p class="text text-primary">
                    {{ $order->phone }}
                </p>
            </div>

            <div class="col-4">
                <h6 style="font-weight: bold">
                    @lang('site.country')

                </h6>

                <p class="text text-primary">
                    {{ $order->country->name_en }} - {{ $order->country->name_ar }}
                </p>
            </div>

            <div class="col-4">
                <h6 style="font-weight: bold">
                    @lang('site.region')
                </h6>

                <p class="text text-primary">
                    {{ $order->city->name_en }} - {{ $order->city->name_ar }}
                </p>
            </div>

            <div class="col-4">
                <h6 style="font-weight: bold">
                    @lang('site.user_type')
                </h6>

                <p class="text text-primary">
                    {{ $order->user_id == 0 ? 'Visitor' : 'Existed User' }}
                </p>
            </div>



            {{-- <div class="col-12"> --}}
            {{-- <h6 style="font-weight: bold"> --}}
            {{-- @lang('site.address2') --}}

            {{-- </h6> --}}

            {{-- <p class="text text-primary"> --}}
            {{-- {{$order->address2}} --}}
            {{-- </p> --}}
            {{-- </div> --}}


            {{-- <div class="col-12"> --}}
            {{-- <h6 style="font-weight: bold"> --}}
            {{-- @lang('site.note'): --}}

            {{-- </h6> --}}

            {{-- <p class="text text-primary"> --}}
            {{-- {{$order->note}} --}}
            {{-- </p> --}}
            {{-- </div> --}}

            <div class="col-4">
                <h6 style="font-weight: bold">
                    @lang('site.total_price')

                </h6>

                <p class="text text-primary">
                    {{ $order->total_price }}
                </p>
            </div>
            <div class="col-4">
                <h6 style="font-weight: bold">
                    @lang('site.persons_no')

                </h6>

                <p class="text text-primary">
                    {{ $order->persons_no }}
                </p>
            </div>
            <div class="col-4">
                <h6 style="font-weight: bold">
                    @lang('site.add_hours')

                </h6>

                <p class="text text-primary">
                    {{ $order->ad_hours }}
                </p>
            </div>
            <div class="col-4">
                <h6 style="font-weight: bold">
                    @lang('site.ad_hour_price')

                </h6>

                <p class="text text-primary">
                    {{ $order->ad_hours_price }}
                </p>
            </div>
            <div class="col-4">
                <h6 style="font-weight: bold">
                    @lang('site.ad_service')

                </h6>

                <p class="text text-primary">
                    {{ $order->ad_service }}
                </p>
            </div>
            <div class="col-4">
                <h6 style="font-weight: bold">
                    @lang('site.ad_service_price')

                </h6>

                <p class="text text-primary">
                    {{ $order->ad_service_price }}
                </p>
            </div>
            <div class="col-4">
                <h6 style="font-weight: bold">
                    @lang('site.request_female')

                </h6>
                            <p class="text text-primary">
                                @if ($order->request_female == 0)
                                @lang('site.no')
                                @else
                                @lang('site.yes')
                                @endif

                </p>
            </div>


            <div class="col-4">
                <h6 style="font-weight: bold">
                    @lang('site.date_of_order')

                </h6>

                <p class="text text-primary">
                    {{ $order->created_at }}
                </p>
            </div>
            <div class="col-12">
                <h6 style="font-weight: bold">


                    @lang('site.address')
                </h6>

                <p class="text text-primary">

                بنايه رقم {{$order->floor}} قطعه رقم {{$order->block}} شارع {{$order->street}}
                </p>
            </div>
            <div class="col-12">
                <h6 style="font-weight: bold">


                    @lang('site.note')
                </h6>

                <p class="text text-primary">
                    {{$order->note}}
                </p>
            </div>
            <hr>
        </div>
    </div>
    <div class="card-header pb-0">
        <h6>
            Order Items
        </h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center justify-content-center mb-0 data-table  text-secondary text-xs ">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="5%">Id</th>
                        <th width="10%">@lang('site.title_en')</th>
                        <th width="10%">@lang('site.title_ar')</th>
                        <th width="10%">@lang('site.price')</th>
                        <th width="10%">@lang('site.persons_no')</th>
                        <th width="10%">@lang('site.persons_max')</th>
                        <th width="40%">@lang('site.img')</th>
                        {{-- <th width="20%">Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    </div>


@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('catering_order.items.view', $order->id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title_en',
                        name: 'title_en'
                    },
                    {
                        data: 'title_ar',
                        name: 'title_ar'
                    },



                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'persons_no',
                        name: 'persons_no'
                    },
                    {
                        data: 'persons_max',
                        name: 'persons_max'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data, type, full, meta) {
                            return "<img src=\"" + data +
                                "\"   border=\"0\"  class=\"img-rounded\" align=\"center\"  height=\"50\"/>";
                        }
                    }, // {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });

            /* When click New customer button */
            // $('#new-user').click(function () {
            //     $('#btn-save').val("create-user");
            //     $('#user').trigger("reset");
            //     $('#userCrudModal').html("Add New User");
            //     $('#crud-modal').modal('show');
            // });

            /* Edit customer */
            //         $('body').on('click', '#edit-user', function () {
            //             var user_id = $(this).data('id');
            //             $.get('users/'+user_id+'/edit', function (data) {
            //                 $('#userCrudModal').html("Edit User");
            //                 $('#btn-update').val("Update");
            //                 $('#btn-save').prop('disabled',false);
            //                 $('#crud-modal').modal('show');
            //                 $('#user_id').val(data.id);
            //                 $('#name').val(data.name);
            //                 $('#email').val(data.email);
            //
            //             })
            //         });
            //         /* Show customer */
            //         $('body').on('click', '#show-user', function () {
            //             var user_id = $(this).data('id');
            //             $.get('users/'+user_id, function (data) {
            //
            //                 $('#sname').html(data.name);
            //                 $('#semail').html(data.email);
            //
            //             })
            //             $('#userCrudModal-show').html("User Details");
            //             $('#crud-modal-show').modal('show');
            //         });
            //
            //         /* Delete customer */
            //         $('body').on('click', '#delete-user', function () {
            //             var user_id = $(this).data("id");
            //             var token = $("meta[name='csrf-token']").attr("content");
            //             confirm("Are You sure want to delete !");
            //
            //             $.ajax({
            //                 type: "DELETE",
            //                 url: "http://localhost/laravelpro/public/users/"+user_id,
            //                 data: {
            //                     "id": user_id,
            //                     "_token": token,
            //                 },
            //                 success: function (data) {
            //
            // //$('#msg').html('Customer entry deleted successfully');
            // //$("#customer_id_" + user_id).remove();
            //                     table.ajax.reload();
            //                 },
            //                 error: function (data) {
            //                     console.log('Error:', data);
            //                 }
            //             });
            //         });

        });
    </script>
@endsection
