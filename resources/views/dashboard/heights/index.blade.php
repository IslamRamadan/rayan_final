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
    <h1 align="center">@lang('site.heights')</h1>
    <br/>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                {{--                <a class="btn btn-success mb-2" id="new-user" data-toggle="modal">New User</a>--}}
                                <a class="btn btn-success mb-2" href="{{route('heights.create')}}">@lang('site.add_height')</a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
    <table class="table table-bordered data-table" >
        <thead>
        <tr id="">
            <th width="5%">No</th>
            <th width="5%">Id</th>
            <th width="60%">@lang('site.name')</th>
            <th width="30%">@lang('site.action')</th>


        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    </div>
</div>

<!-- Add and Edit customer modal -->
<div class="modal fade" id="crud-modal" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="userCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form name="userForm" action="{{ route('currencies.store') }}" method="POST">
                    <input type="hidden" name="currency_id" id="currency_id" >
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>@lang('site.name'):</strong>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" onchange="validate()" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>@lang('site.rate'):</strong>
                                <input type="number" name="rate" id="rate" class="form-control" placeholder="Rate" onchange="validate()" >
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>@lang('site.code'):</strong>
                                <input type="text" name="code" id="code" class="form-control" placeholder="Code" onchange="validate()" >
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" id="btn-save" name="btnsave" class="btn btn-primary" disabled>@lang('site.save')</button>
                            <a href="{{ route('currencies.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Show user modal -->
<div class="modal fade" id="crud-modal-show" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="userCrudModal-show"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-2 col-sm-2 col-md-2"></div>
                    <div class="col-xs-10 col-sm-10 col-md-10 ">

                        <table class="table-responsive ">
                            <tr height="50px"><td><strong>Name:</strong></td><td id="sname"></td></tr>
                            <tr height="50px"><td><strong>Email:</strong></td><td id="semail"></td></tr>

                            <tr><td></td><td style="text-align: right "><a href="{{ route('currencies.index') }}" class="btn btn-danger">OK</a> </td></tr>
                        </table>
                    </div>
                </div>
            </div>
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
            ajax: "{{ route('heights.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
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

