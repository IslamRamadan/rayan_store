@extends('dashboard.layouts.app')
@section('page_title') @lang('site.settings') @endsection

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

@endsection
@section('content')

    <div class="container">

        <br />
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-success mb-2" href="{{ route('settings.edit', $setting->id) }}">
                        @lang('site.edit_settings')
                    </a>
                </div>
            </div>
        </div>
        <div class="card-header pb-0">
            <h6>
                @lang('site.settings')
            </h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0 data-table  text-secondary text-xs ">
                    <tbody>
                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.logo')

                            </td>
                            <td width="90%">
                                <img src="{{ asset('/storage/' . $setting->logo) }}"
                                    style="margin: auto;background-color: #1a202c" class="col-md-4 col-12 img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.footer_logo')

                            </td>
                            <td width="90%">
                                <img src="{{ asset('/storage/' . $setting->footer_logo) }}"
                                    style="margin: auto;background-color: #1a202c" class="col-md-4 col-12 img-fluid">
                            </td>
                        </tr>
                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.ad_image')

                            </td>
                            <td width="90%">
                                <img src="{{ asset('/storage/' . $setting->ad_image) }}"
                                    style="margin: auto;background-color: #1a202c" class="col-md-4 col-12 img-fluid">
                            </td>
                        </tr>

                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.site_ar')
                            </td>
                            <td width="90%">
                                {{ $setting->site_name_ar }}
                            </td>
                        </tr>


                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.site_en')
                            </td>
                            <td width="90%">
                                {{ $setting->site_name_en }}
                            </td>
                        </tr>

                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.facebook')
                            </td>
                            <td width="90%">
                                {{ $setting->facebook }}
                            </td>
                        </tr>



                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.youtube')
                            </td>
                            <td width="90%">
                                {{ $setting->youtube }}
                            </td>
                        </tr>



                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.gmail')

                            </td>
                            <td width="90%">
                                {{ $setting->email }}
                            </td>
                        </tr>


                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.page_details_ar')
                            </td>
                            <td width="90%">
                                {{ $setting->site_des_ar }}
                            </td>
                        </tr>

                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.page_details_en')
                            </td>
                            <td width="90%">
                                {{ $setting->site_des_en }}
                            </td>
                        </tr>


                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.android')
                            </td>
                            <td width="90%">
                                {{ $setting->android_link }}
                            </td>
                        </tr>


                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.ios')
                            </td>
                            <td width="90%">
                                {{ $setting->ios_link }}
                            </td>
                        </tr>


                        <tr>
                            <td width="10%" style="font-weight: bold">

                                @lang('site.twitter')

                            </td>
                            <td width="90%">
                                {{ $setting->twitter }}
                            </td>
                        </tr>

                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.gplus')
                            </td>
                            <td width="90%">
                                {{ $setting->google_plus }}
                            </td>
                        </tr>
                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.phone')

                            </td>
                            <td width="90%">
                                {{ $setting->phone }}
                            </td>
                        </tr>
                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.whatsapp')

                            </td>
                            <td width="90%">
                                {{ $setting->whatsapp }}
                            </td>
                        </tr>

                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.instagrm')

                            </td>
                            <td width="90%">
                                {{ $setting->instagram }}
                            </td>
                        </tr>

                        <tr>
                            <td width="10%" style="font-weight: bold">
                                @lang('site.telegram')

                            </td>
                            <td width="90%">
                                {{ $setting->telegram }}
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

{{-- @section('script') --}}
{{-- <script type="text/javascript"> --}}

{{-- $(document).ready(function () { --}}

{{-- var table = $('.data-table').DataTable({ --}}
{{-- processing: true, --}}
{{-- serverSide: true, --}}
{{-- ajax: "{{ route('pages.index') }}", --}}
{{-- columns: [ --}}
{{-- {data: 'DT_RowIndex', name: 'DT_RowIndex'}, --}}
{{-- {data: 'id', name: 'id'}, --}}
{{-- {data: 'page_title_ar', name: 'page_title_ar'}, --}}
{{-- {data: 'page_title_en', name: 'page_title_en'}, --}}
{{-- {data: 'page_details_ar', name: 'page_details_ar'}, --}}
{{-- {data: 'page_details_en', name: 'page_details_en'}, --}}
{{-- {data: 'action', name: 'action', orderable: false, searchable: false}, --}}
{{-- ] --}}
{{-- }); --}}

{{-- /* When click New customer button */ --}}
{{-- $('#new-user').click(function () { --}}
{{-- $('#btn-save').val("create-user"); --}}
{{-- $('#user').trigger("reset"); --}}
{{-- $('#userCrudModal').html("Add New User"); --}}
{{-- $('#crud-modal').modal('show'); --}}
{{-- }); --}}

{{-- /* Edit customer */ --}}
{{-- //         $('body').on('click', '#edit-user', function () { --}}
{{-- //             var user_id = $(this).data('id'); --}}
{{-- //             $.get('users/'+user_id+'/edit', function (data) { --}}
{{-- //                 $('#userCrudModal').html("Edit User"); --}}
{{-- //                 $('#btn-update').val("Update"); --}}
{{-- //                 $('#btn-save').prop('disabled',false); --}}
{{-- //                 $('#crud-modal').modal('show'); --}}
{{-- //                 $('#user_id').val(data.id); --}}
{{-- //                 $('#name').val(data.name); --}}
{{-- //                 $('#email').val(data.email); --}}
{{-- // --}}
{{-- //             }) --}}
{{-- //         }); --}}
{{-- //         /* Show customer */ --}}
{{-- //         $('body').on('click', '#show-user', function () { --}}
{{-- //             var user_id = $(this).data('id'); --}}
{{-- //             $.get('users/'+user_id, function (data) { --}}
{{-- // --}}
{{-- //                 $('#sname').html(data.name); --}}
{{-- //                 $('#semail').html(data.email); --}}
{{-- // --}}
{{-- //             }) --}}
{{-- //             $('#userCrudModal-show').html("User Details"); --}}
{{-- //             $('#crud-modal-show').modal('show'); --}}
{{-- //         }); --}}
{{-- // --}}
{{-- //         /* Delete customer */ --}}
{{-- //         $('body').on('click', '#delete-user', function () { --}}
{{-- //             var user_id = $(this).data("id"); --}}
{{-- //             var token = $("meta[name='csrf-token']").attr("content"); --}}
{{-- //             confirm("Are You sure want to delete !"); --}}
{{-- // --}}
{{-- //             $.ajax({ --}}
{{-- //                 type: "DELETE", --}}
{{-- //                 url: "http://localhost/laravelpro/public/users/"+user_id, --}}
{{-- //                 data: { --}}
{{-- //                     "id": user_id, --}}
{{-- //                     "_token": token, --}}
{{-- //                 }, --}}
{{-- //                 success: function (data) { --}}
{{-- // --}}
{{-- // //$('#msg').html('Customer entry deleted successfully'); --}}
{{-- // //$("#customer_id_" + user_id).remove(); --}}
{{-- //                     table.ajax.reload(); --}}
{{-- //                 }, --}}
{{-- //                 error: function (data) { --}}
{{-- //                     console.log('Error:', data); --}}
{{-- //                 } --}}
{{-- //             }); --}}
{{-- //         }); --}}

{{-- }); --}}

{{-- </script> --}}
{{-- @endsection --}}
