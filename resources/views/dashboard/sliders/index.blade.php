@extends('dashboard.layouts.app')

@section('page_title')  @lang('site.banners')  @endsection

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
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    {{--                <a class="btn btn-success mb-2" id="new-user" data-toggle="modal">New User</a>--}}
                    <a class="btn btn-success mb-2" href="{{route('sliders.create')}}">@lang('site.new_banner')</a>
                </div>
            </div>
        </div>
        <div class="card-header pb-0">
            <h6>@lang('site.banners')</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0 data-table  text-secondary text-xs ">
                    <thead>
                    <tr>
            <th width="5%">No</th>
            <th width="5%">Id</th>
            <th width="10%">@lang('site.name_arabic')</th>
            <th width="10%">@lang('site.name_english')</th>
            <th width="20%">@lang('site.description_ar')</th>
            <th width="20%">@lang('site.description_en')</th>
            <th width="10%">@lang('site.img')</th>
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

    $(document).ready(function () {

        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('sliders.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {data: 'name_ar', name: 'name_ar'},
                {data: 'name_en', name: 'name_en'},
                {data: 'description_ar', name: 'description_ar'},
                {data: 'description_en', name: 'description_en'},
                {data: 'image', name: 'image' , render: function( data, type, full, meta ) {
                    return "<img src=\"" + data + "\"   border=\"0\"  class=\"img-rounded\" align=\"center\"  height=\"70\"/>";
                }},                {data: 'action', name: 'action', orderable: false, searchable: false},
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


