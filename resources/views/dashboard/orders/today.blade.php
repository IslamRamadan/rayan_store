@extends('dashboard.layouts.app')
@section('page_title')  Orders  @endsection


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
        <br>

        <div class="row text-center">
            <h2>طلبات اليوم</h2>
        </div>

        <div class="row mt-2">
            <div class="col-xl-3 col-sm-6  mb-4">
                <a href="{{route('orders.today')}}">

                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers dir-rtl ">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">@lang('site.num_paid_orders')</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{$number}}
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

            <div class="col-xl-3 col-sm-6  mb-4">
                <a href="{{route('orders.index')}}">

                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers dir-rtl">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">@lang('site.total_orders')</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{$total_price}} <span>@lang('site.kwd')</span>
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

            <div class="col-xl-3 col-sm-6  mb-4">
                <a href="{{route('orders.today')}}">

                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers dir-rtl">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">@lang('site.today_orders')</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{$today}}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <form action="{{route('orders.index')}}" method="GET">
                                        <input type="hidden" name="today" value="1">
                                    <button type="submit">
                                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                    </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-xl-3 col-sm-6  mb-4">
                <a href="{{route('orders.today')}}">

                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers dir-rtl">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">@lang('site.total_today')</p>
                                    <div class="" >
                                    <h5 class="font-weight-bolder mb-0" >
                                        {{$today_price}}  <span>@lang('site.kwd')</span>
                                    </h5>
                                </div>
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

        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0 data-table  text-secondary text-xs ">
                    <thead>
                    <tr>
            <th width="5%">No</th>
            <th width="5%">Id</th>
            <th width="10%">@lang('site.username')</th>
            <th width="10%">@lang('site.phone')</th>
            <th width="10%">@lang('site.email')</th>
            <th width="10%">@lang('site.user_id')</th>
            <th width="10%">@lang('site.order_status')</th>
            <th width="10%">@lang('site.ttl_price')</th>
            <th width="10%">@lang('site.ttl_qut')</th>
            <th width="20%">@lang('site.action')</th>
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
    console.log('ok');
    $(document).ready(function () {

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('orders.today') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'email', name: 'email'},
                {data: 'created_at', name: 'created_at'},
                {data: 'status', name: 'status'},
                {data: 'total_price', name: 'total_price'},
                {data: 'total_quantity', name: 'total_quantity'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        /* When click New customer button */
        $('#new-user').click(function () {
            $('#btn-save').val("create-user");
            $('#user').trigger("reset");
            $('#userCrudModal').html("Add New User");
            $('#crud-modal').modal('show');
        });

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


