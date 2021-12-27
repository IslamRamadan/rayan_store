@extends('dashboard.layouts.app')
@section('page_title') @lang('site.basic_categories') @endsection

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
        <br>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    {{-- <a class="btn btn-success mb-2" id="new-user" data-toggle="modal">New User</a> --}}
                    <a class="btn btn-success mb-2" href="{{ route('basic_categories.create') }}">@lang('site.add_basic_category')</a>
                </div>
            </div>
        </div>
        <div class="card-header pb-0">
            <h6>@lang('site.basic_categories')</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0 data-table  text-secondary text-xs ">
                    <thead>
                        <tr>
                            <th width="5%" class="show_confirm">No</th>
                            <th width="5%">Id</th>
                            <th width="30%">@lang('site.name_arabic')</th>
                            <th width="30%">@lang('site.name_english')</th>
                            <th width="30%">@lang('site.cat_img')</th>
                            <th width="20%">@lang('site.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div id="hh" class="test-form">hhhh</div>

    <!-- Add and Edit customer modal -->
    {{-- <div class="modal fade" id="crud-modal" aria-hidden="true" > --}}
    {{-- <div class="modal-dialog"> --}}
    {{-- <div class="modal-content"> --}}
    {{-- <div class="modal-header"> --}}
    {{-- <h4 class="modal-title" id="userCrudModal"></h4> --}}
    {{-- </div> --}}
    {{-- <div class="modal-body"> --}}
    {{-- <form name="userForm" action="{{ route('adm.store') }}" method="POST"> --}}
    {{-- <input type="hidden" name="user_id" id="user_id" > --}}
    {{-- @csrf --}}
    {{-- <div class="row"> --}}
    {{-- <div class="col-xs-12 col-sm-12 col-md-12"> --}}
    {{-- <div class="form-group"> --}}
    {{-- <strong>Name:</strong> --}}
    {{-- <input type="text" name="name" id="name" class="form-control" placeholder="Name" onchange="validate()" > --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- <div class="col-xs-12 col-sm-12 col-md-12"> --}}
    {{-- <div class="form-group"> --}}
    {{-- <strong>Email:</strong> --}}
    {{-- <input type="text" name="email" id="email" class="form-control" placeholder="Email" onchange="validate()"> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- <div class="col-xs-12 col-sm-12 col-md-12"> --}}
    {{-- <div class="form-group"> --}}
    {{-- <strong>Password:</strong> --}}
    {{-- <input type="text" name="password" id="password" class="form-control" placeholder="Password" onchange="validate()"> --}}
    {{-- </div> --}}
    {{-- </div> --}}

    {{-- <div class="col-xs-12 col-sm-12 col-md-12 text-center"> --}}
    {{-- <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>Save</button> --}}
    {{-- <a href="{{ route('users.index') }}" class="btn btn-danger">Cancel</a> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </form> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}

    <!-- Show user modal -->
    {{-- <div class="modal fade" id="crud-modal-show" aria-hidden="true" > --}}
    {{-- <div class="modal-dialog"> --}}
    {{-- <div class="modal-content"> --}}
    {{-- <div class="modal-header"> --}}
    {{-- <h4 class="modal-title" id="userCrudModal-show"></h4> --}}
    {{-- </div> --}}
    {{-- <div class="modal-body"> --}}
    {{-- <div class="row"> --}}
    {{-- <div class="col-xs-2 col-sm-2 col-md-2"></div> --}}
    {{-- <div class="col-xs-10 col-sm-10 col-md-10 "> --}}

    {{-- <table class="table-responsive "> --}}
    {{-- <tr height="50px"><td><strong>Name:</strong></td><td id="sname"></td></tr> --}}
    {{-- <tr height="50px"><td><strong>Email:</strong></td><td id="semail"></td></tr> --}}

    {{-- <tr><td></td><td style="text-align: right "><a href="{{ route('users.index') }}" class="btn btn-danger">OK</a> </td></tr> --}}
    {{-- </table> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('basic_categories.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name_ar',
                        name: 'name_ar'
                    },
                    {
                        data: 'name_en',
                        name: 'name_en'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data, type, full, meta) {
                            return "<img src=\"" + data +
                                "\"   border=\"0\"  class=\"img-rounded\" align=\"center\"  height=\"50\"/>";
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            console.log("ok");

            $('.test-form').click(function(e) {
                e.preventDefault();

                if (confirm("Are you sure you want to delete?")) {
                    $(this).submit();
                }
            });

        });
    </script>
    <script type="text/javascript">
        console.log("ok");

        $('#hh').click(function(event) {
            console.log('hh');
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            confirm("Are You sure want to delete !");
            Swal({


                    icon: '?',
                    title: 'Login first!',
                    confirmButtonColor: '#ec7d23',
                    position: 'bottom-start',
                    showCloseButton: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>
@endsection
