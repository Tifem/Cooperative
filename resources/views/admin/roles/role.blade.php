@extends('layouts.master')

@section('headlinks')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
        <!-- Begin page -->
    <div id="layout-wrapper">
        <div class="main-content">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Role Management</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="/home">{{Auth::user()->name}}</a></li>
                                    <li class="breadcrumb-item active">Roles</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom d-flex">
                                <h4 class="card-title">Roles List</h4>
                                <a href="{{ route('create_role') }}" class="modal-effect btn btn-primary ms-auto"><i class="fa fa-plus"></i>Add New
                                    Role</a>
                            </div>
                            <div class="card-body">
                                @include('includes.alert')
                                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $role->name }}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info"
                                                            href="{{ route('show_role', $role->id) }}"><i class="fa fa-eye"></i></a>
                                                        @can('role-edit')
                                                            <a class="btn btn-sm btn-primary"
                                                                href="{{ route('edit_role', $role->id) }}"><i class="fa fa-edit"></i></a>
                                                        @endcan

                                                        @can('role-delete')

                                                        <button class="btn btn-sm btn-danger" id="deleteRecord" data-id="{{$role->id}}"><i class="fa fa-trash"></i></button>

                                                        @endcan
                                                    </td>
                                                </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- end col -->
                </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->
    </div>

    @endsection
        <!-- JAVASCRIPT -->
    @section('scripts')
    @include('layouts.datatable')

    <script>
        $(document).ready(function() {
                 $.ajaxSetup({
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     }
                 });







                 /* When click delete button */
                 $('body').on('click', '#deleteRecord', function() {
                     var user_id = $(this).data('id');
                     // alert(user_id)
                     var token = $("meta[name='csrf-token']").attr("content");
                     var el = this;
                     // alert(user_id);
                     resetAccount(el, user_id);
                 });


                 async function resetAccount(el, user_id) {
                     const willUpdate = await new swal({
                         title: "Confirm User Delete",
                         text: `Are you sure you want to delete this role?`,
                         icon: "warning",
                         confirmButtonColor: "#DD6B55",
                         confirmButtonText: "Yes!",
                         showCancelButton: true,
                         buttons: ["Cancel", "Yes, Delete"]
                     });
                     // console.log(willUpdate);
                     if (willUpdate.isConfirmed == true) {
                         //performReset()
                         performDelete(el, user_id);
                     } else {
                         swal("User record will not be deleted  :)");
                     }
                 }


                 function performDelete(el, user_id) {
                     //alert(user_id);
                     try {
                         $.get('{{ route('destroy_role') }}?id=' + user_id,
                             function(data, status) {
                                 console.log(status);
                                 console.table(data);
                                 if (status === "success") {
                                     let alert = new swal("User successfully deleted!.");
                                     $(el).closest("tr").remove();
                                     // alert.then(() => {
                                     // });
                                 }
                             }
                         );
                     } catch (e) {
                         let alert = new swal(e.message);
                     }
                 }


             })
 </script>
    @endsection
