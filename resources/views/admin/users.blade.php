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
                        <h4 class="mb-sm-0 font-size-18">User Management</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/home">{{ Auth::user()->name }}</a></li>
                                <li class="breadcrumb-item active">User</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex">
                            <h4 class="card-title">Users List</h4>
                            <a class="modal-effect btn btn-primary ms-auto" data-bs-effect="effect-super-scaled"
                                data-bs-toggle="modal" href="#myModal"> <i class="fa fa-plus"></i> Add New User </a>
                        </div>
                        <div class="card-body">
                            @include('includes.alert')
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone_no }}</td>
                                            <td>{{ $user->roleName->name ?? $user->role_id }}</td>
                                            {{--  <td>
                                                @if (!empty($user->getRoleNames()))
                                                    @foreach ($user->getRoleNames() as $v)
                                                        <label class="">{{ $v }}</label>
                                                    @endforeach
                                                @endif
                                            </td>  --}}
                                            <td>
                                                <button class="btn btn-sm btn-primary edit-item-btn" data-bs-toggle="modal"
                                                    id="edit-user" data-id="{{ $user->id }}"
                                                    data-bs-target="#editModal"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-sm btn-danger" id="deleteRecord"
                                                    data-id="{{ $user->id }}"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                data-bs-scroll="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Add New User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" id="frm_main">
                            @csrf
                            <div class="modal-content modal-content-demo">
                                <div class="modal-body">
                                    <div class="mb-4">
                                        <label class="form-label">Enter name</label>
                                        <input class="form-control" placeholder="Enter Name" type="text" name="name">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Enter Email</label>
                                        <input class="form-control" placeholder="Enter Your Email" type="email"
                                            name="email">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Enter Phone number</label>
                                        <input class="form-control" placeholder="Enter Phone" type="text"
                                            name="phone_no">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Enter Password</label>
                                        <input class="form-control" id="passwordElement" placeholder="Enter Your Password"
                                            type="password" name="password">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Confirm Password</label>
                                        <input class="form-control" placeholder="Confirm Password" type="password"
                                            name="confirm-password">
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Select Role</label>
                                        <select class="form-control" name="role_id">
                                            <option>Select role</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary mr-2 submit-btn" name="save"
                                            id="">Save<span class="spinner-border loader1 spinner-border-sm"
                                                role="status" aria-hidden="true" style="display:none"></span></button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
                <div class="modal-dialog vertical-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><b>Edit User</b></h5>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('update_admin_users') }}">
                            @csrf
                            <div class="modal-body">
                                <input type="hidden" id="userId" name="id">
                                <div class="mb-3">
                                    <label class="form-label">Full name</label>
                                    <input type="text" class="form-control" id="Uname" name="name"
                                        placeholder="Name" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" id="Uemail" name="email"
                                        placeholder="Email" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone number</label>
                                    <input type="text" class="form-control" id="Uphone" name="phone_no"
                                        required />
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="form-label">Select Role</label>
                                        <select class="form-select form-control" id="Urole" name="role_id" required>
                                            <option selected disabled value="">Choose role...</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="hstack gap-2 justify-content-end">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" name="save"
                                        id="edit-btn">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->
    </div>
@endsection
<!-- JAVASCRIPT -->
@section('scripts')
    <script src="{{ asset('js\requestController.js') }}"></script>
    <script src="{{ asset('js\formController.js') }}"></script>
    <script src="{{ asset('js/sweetalert/dist/sweetalert.min.js') }}"></script>
    @include('layouts.datatable')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#frm_main").on('submit', async function(e) {
                e.preventDefault();

                const serializedData = $("#frm_main").serializeArray();

                var loader = $(".loader1");
                loader.show();

                try {

                    const willUpdate = await new swal({
                        title: "Confirm User Action",
                        text: `Are you sure you want to submit?`,
                        icon: "warning",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes!",
                        showCancelButton: true,
                        buttons: ["Cancel", "Yes, Submit"]
                    });
                    //var loader = $(".loader1");
                    //loader.hide();
                    // console.log(willUpdate);
                    // if (willUpdate.isConfirmed == true) {
                    if (willUpdate) {
                        //performReset()
                        //  alert('here')
                        const postRequest = await request("/admin/users/stores",
                            processFormInputs(
                                serializedData), 'post');
                        console.log('postRequest.message', postRequest.message);
                        new swal("Good Job", postRequest.message, "success");
                        var loader = $(".loader1");
                        loader.hide();
                        $('#frm_main').trigger("reset");
                        $("#frm_main .close").click();
                        window.location.reload();
                    } else {
                        var loader = $(".loader1");
                        loader.hide();
                        new swal("Process aborted  :)");

                    }

                } catch (e) {
                    if ('message' in e) {
                        console.log('e.message', e.message);
                        new swal("Opss", e.message, "error");
                    }
                }
            })

            $("#update_agent_password").on('submit', async function(e) {
                e.preventDefault();
                const serializedData = $("#update_agent_password").serializeArray();

                try {

                    var loader = $("#loader1");
                    loader.show();
                    const postRequest = await request("/admin/users/update_agent_password",
                        processFormInputs(
                            serializedData), 'post');
                    console.log('postRequest.message', postRequest.message);
                    swal("Good Job", "Password set to default successfully!.", "success");
                    $('#update_agent_password').trigger("reset");
                    $("#update_agent_password .close").click();
                    window.location.reload();
                } catch (e) {
                    if ('message' in e) {
                        console.log('e.message', e.message);
                        swal("Opss", e.message, "error");
                        loader.hide();
                    }
                }
            })






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
                    text: `Are you sure you want to delete this user?`,
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
                    $.get('{{ route('delete_user') }}?id=' + user_id,
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
    <script>
        $(document).ready(function() {
            $('body').on('click', '#edit-user', function() {
                // alert("Nathaniel")
                var id = $(this).data('id');
                $.get('{{ route('getUserInfos') }}?id=' + id, function(data) {
                    // alert('hhgf');
                    $('#Uname').val(data.user.name);
                    $('#Uemail').val(data.user.email);
                    $('#Uphone').val(data.user.phone_no);
                    $('#Upassword').val(data.user.password);
                    $('#Urole').val(data.role[0]);
                    $('#userId').val(id);
                })
            });
        });
    </script>
@endsection
