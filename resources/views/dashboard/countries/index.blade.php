@extends('dashboard.layouts.app')
@section('page_title')  @lang('site.countries')  @endsection
@section('style')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />--}}
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" ></script>


    <script>
        error=false

        function validate()
        {
            if(document.userForm.name.value !='' && document.userForm.email.value !='' && document.userForm.password.value !='' )
                document.userForm.btnsave.disabled=false
            else
                document.userForm.btnsave.disabled=true
        }
    </script>

@endsection
@section('content')

    <div class="container">
        <br>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    {{--                <a class="btn btn-success mb-2" id="new-user" data-toggle="modal">New User</a>--}}
                    <a class="btn btn-success mb-2" href="{{route('countries.create')}}">@lang('site.new_country')</a>
                </div>
            </div>
        </div>
        <div class="card-header pb-0">
            <h6>@lang('site.countries')</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0 data-table  text-secondary text-xs ">
                    <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ID</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">@lang('site.name_arabic') </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">@lang('site.name_english')</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">@lang('site.country_code')</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">@lang('site.code')</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">@lang('site.currency')</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">@lang('site.currency_code')</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">@lang('site.flag_img')</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">@lang('site.action')</th>

                    </tr>
                    </thead>
                    <tbody>
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <div class="d-flex px-2">--}}
{{--                                <div>--}}
{{--                                    <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm rounded-circle me-2">--}}
{{--                                </div>--}}
{{--                                <div class="my-auto">--}}
{{--                                    <h6 class="mb-0 text-sm">Spotify</h6>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <p class="text-sm font-weight-bold mb-0">$2,500</p>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <span class="text-xs font-weight-bold">working</span>--}}
{{--                        </td>--}}
{{--                        <td class="align-middle text-center">--}}
{{--                            <div class="d-flex align-items-center justify-content-center">--}}
{{--                                <span class="me-2 text-xs font-weight-bold">60%</span>--}}
{{--                                <div>--}}
{{--                                    <div class="progress">--}}
{{--                                        <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td class="align-middle">--}}
{{--                            <button class="btn btn-link text-secondary mb-0">--}}
{{--                                <i class="fa fa-ellipsis-v text-xs"></i>--}}
{{--                            </button>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <div class="d-flex px-2">--}}
{{--                                <div>--}}
{{--                                    <img src="../assets/img/small-logos/logo-invision.svg" class="avatar avatar-sm rounded-circle me-2">--}}
{{--                                </div>--}}
{{--                                <div class="my-auto">--}}
{{--                                    <h6 class="mb-0 text-sm">Invision</h6>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <p class="text-sm font-weight-bold mb-0">$5,000</p>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <span class="text-xs font-weight-bold">done</span>--}}
{{--                        </td>--}}
{{--                        <td class="align-middle text-center">--}}
{{--                            <div class="d-flex align-items-center justify-content-center">--}}
{{--                                <span class="me-2 text-xs font-weight-bold">100%</span>--}}
{{--                                <div>--}}
{{--                                    <div class="progress">--}}
{{--                                        <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td class="align-middle">--}}
{{--                            <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">--}}
{{--                                <i class="fa fa-ellipsis-v text-xs"></i>--}}
{{--                            </button>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <div class="d-flex px-2">--}}
{{--                                <div>--}}
{{--                                    <img src="../assets/img/small-logos/logo-jira.svg" class="avatar avatar-sm rounded-circle me-2">--}}
{{--                                </div>--}}
{{--                                <div class="my-auto">--}}
{{--                                    <h6 class="mb-0 text-sm">Jira</h6>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <p class="text-sm font-weight-bold mb-0">$3,400</p>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <span class="text-xs font-weight-bold">canceled</span>--}}
{{--                        </td>--}}
{{--                        <td class="align-middle text-center">--}}
{{--                            <div class="d-flex align-items-center justify-content-center">--}}
{{--                                <span class="me-2 text-xs font-weight-bold">30%</span>--}}
{{--                                <div>--}}
{{--                                    <div class="progress">--}}
{{--                                        <div class="progress-bar bg-gradient-danger" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="30" style="width: 30%;"></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td class="align-middle">--}}
{{--                            <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">--}}
{{--                                <i class="fa fa-ellipsis-v text-xs"></i>--}}
{{--                            </button>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <div class="d-flex px-2">--}}
{{--                                <div>--}}
{{--                                    <img src="../assets/img/small-logos/logo-slack.svg" class="avatar avatar-sm rounded-circle me-2">--}}
{{--                                </div>--}}
{{--                                <div class="my-auto">--}}
{{--                                    <h6 class="mb-0 text-sm">Slack</h6>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <p class="text-sm font-weight-bold mb-0">$1,000</p>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <span class="text-xs font-weight-bold">canceled</span>--}}
{{--                        </td>--}}
{{--                        <td class="align-middle text-center">--}}
{{--                            <div class="d-flex align-items-center justify-content-center">--}}
{{--                                <span class="me-2 text-xs font-weight-bold">0%</span>--}}
{{--                                <div>--}}
{{--                                    <div class="progress">--}}
{{--                                        <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="0" style="width: 0%;"></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td class="align-middle">--}}
{{--                            <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">--}}
{{--                                <i class="fa fa-ellipsis-v text-xs"></i>--}}
{{--                            </button>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <div class="d-flex px-2">--}}
{{--                                <div>--}}
{{--                                    <img src="../assets/img/small-logos/logo-webdev.svg" class="avatar avatar-sm rounded-circle me-2">--}}
{{--                                </div>--}}
{{--                                <div class="my-auto">--}}
{{--                                    <h6 class="mb-0 text-sm">Webdev</h6>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <p class="text-sm font-weight-bold mb-0">$14,000</p>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <span class="text-xs font-weight-bold">working</span>--}}
{{--                        </td>--}}
{{--                        <td class="align-middle text-center">--}}
{{--                            <div class="d-flex align-items-center justify-content-center">--}}
{{--                                <span class="me-2 text-xs font-weight-bold">80%</span>--}}
{{--                                <div>--}}
{{--                                    <div class="progress">--}}
{{--                                        <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="80" style="width: 80%;"></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td class="align-middle">--}}
{{--                            <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">--}}
{{--                                <i class="fa fa-ellipsis-v text-xs"></i>--}}
{{--                            </button>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <div class="d-flex px-2">--}}
{{--                                <div>--}}
{{--                                    <img src="../assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm rounded-circle me-2">--}}
{{--                                </div>--}}
{{--                                <div class="my-auto">--}}
{{--                                    <h6 class="mb-0 text-sm">Adobe XD</h6>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <p class="text-sm font-weight-bold mb-0">$2,300</p>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <span class="text-xs font-weight-bold">done</span>--}}
{{--                        </td>--}}
{{--                        <td class="align-middle text-center">--}}
{{--                            <div class="d-flex align-items-center justify-content-center">--}}
{{--                                <span class="me-2 text-xs font-weight-bold">100%</span>--}}
{{--                                <div>--}}
{{--                                    <div class="progress">--}}
{{--                                        <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td class="align-middle">--}}
{{--                            <button class="btn btn-link text-secondary mb-0" aria-haspopup="true" aria-expanded="false">--}}
{{--                                <i class="fa fa-ellipsis-v text-xs"></i>--}}
{{--                            </button>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
                    </tbody>
                </table>
            </div>
        </div>
{{--        <div class="table-responsive">--}}
{{--            <table class="table table-bordered data-table " >--}}
{{--                <thead>--}}
{{--                <tr id="">--}}
{{--                    <th width="5%">No</th>--}}
{{--                    <th width="5%">Id</th>--}}
{{--                   --}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                </tbody>--}}
{{--            </table>--}}

{{--        </div>--}}
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        $(document).ready(function () {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('countries.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'id', name: 'id'},
                    {data: 'name_ar', name: 'name_ar'},
                    {data: 'name_en', name: 'name_en'},
                    {data: 'country_code', name: 'country_code'},
                    {data: 'code', name: 'code'},
                    {data: 'currency_name', name: 'currency_name'},
                    {data: 'currency_code', name: 'currency_code'},
                    {data: 'image', name: 'image' , render: function( data, type, full, meta ) {
                            return "<img src=\"" + data + "\"   border=\"0\"  class=\"img-rounded\" align=\"center\"  height=\"50\"/>";
                        }},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
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


