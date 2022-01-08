@extends('dashboard.layouts.app')

@section('style')
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    {{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />--}}
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" ></script>


    <script>
        error=false

        function validate()
        {
            if(document.userForm.name.value !='' && document.userForm.code.value !='' && document.userForm.rate.value !='' )
                document.userForm.btnsave.disabled=false
            else
                document.userForm.btnsave.disabled=true
        }
    </script>

@endsection
@section('content')







    <div class="container">

        <div class="box-body">


            <div class="box-header with-border">
                {!! Form::model("", ['route' => ['catering_galaries.store',$id],
                "method"=>"post", 'enctype' => 'multipart/form-data'

                ])!!}
                {{ csrf_field() }}


                <div class="form-group" >
                    <label> @lang('site.add_imgs')</label>
                    <input type="file" name="img[]" multiple class="form-control"  required>
                </div>





                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> اضف</button>
                </div>

                {!! Form::close() !!}

            </div><!-- end of box body -->

        </div>

        <div class="box box-primary">







            <div class="box-body">


                <div class="table-responsive">
                <table class="table table-hover table table-bordered">

                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-center">@lang('site.img')</th>





                        <th class="text-center">@lang('site.action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($posts as $post)


                        <tr>
                            <td>{{$loop->iteration}}</td>

                            <td class="text-center"> <img style="width:150px;height:100px" src="{{asset($post->image)}}" alt=""></td>




                            <td class="text-center">

                                <form action="{{url(route("catering_galaries.destroy",$post->id)) }}" method="post" style="display: inline-block">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button type="submit" class="btn btn-danger delete  btn-sm"><i class="fa  fa-trash"></i> حذف</button>
                                </form><!-- end of form -->

                            </td>
                        </tr>
                    @endforeach

                    </tbody>

                </table><!-- end of table -->
                </div>




            </div><!-- end of box body -->

            @if(count($posts)==0)
                <div class="alert alert-danger"> @lang('site.no_data')
                </div>
            @endif



        </div>




    </div>



@endsection
