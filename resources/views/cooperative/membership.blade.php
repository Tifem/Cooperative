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
                        <h4 class="mb-sm-0 font-size-18">Manage Membership</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/home">{{ Auth::user()->name }}</a></li>
                                <li class="breadcrumb-item active">Membership</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex">
                            <h4 class="card-title">Membership List</h4>
                            <button type="button" class="btn btn-primary waves-effect waves-light ms-auto"
                                id="edit-employee" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl"><i
                                    class="fa fa-plus"></i> Add Member</button> &nbsp;
                            <a href="{{ route('download_members_excel', 'xlsx') }}" class="btn btn-primary add-btn"><i
                                    class="fa fa-download"></i> Download Member Excel</a>&nbsp;&nbsp;
                            <a href="{{ route('upload_members_excel', 'xlsx') }}" class="btn btn-primary add-btn"
                                data-bs-toggle="modal" data-bs-target="#uploadModal"><i class="fa fa-upload"></i>Upload
                                Member</a>
                        </div>

                        <div class="card-body">
                            {{-- @include('includes.alert') --}}
                            <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Member ID</th>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>Othername</th>
                                        <th>Phone Number</th>
                                        <th>Email</th>
                                        <th>Sex</th>
                                        <th>Home Address</th>
                                        <th>Religion</th>
                                        <th>Account Number</th>
                                        <th>Account Name</th>
                                        <th>Bank Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($members as $member)
                                        <tr>
                                            {{-- <td>{{ ++$i }}</td> --}}
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $member->member_id }}</td>
                                            <td>{{ $member->firstname }}</td>
                                            <td>{{ $member->lastname }}</td>
                                            <td>{{ $member->othername }}</td>
                                            <td>{{ $member->phone_no }}</td>
                                            <td>{{ $member->email }}</td>
                                            <td>{{ $member->sex }}</td>
                                            <td>{{ $member->home_address }}</td>
                                            <td>{{ $member->religion }}</td>
                                            <td>{{ $member->account_number }}</td>
                                            <td>{{ $member->account_name }}</td>
                                            <td>{{ $member->bnk->gl_name ?? $member->bank_name }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <button class="btn btn-sm btn-primary edit-item-btn"
                                                            data-bs-toggle="modal" id="edit-member"
                                                            data-id="{{ $member->id }}" data-bs-target="#editModal"><i
                                                                class="fa fa-edit"></i></button>
                                                    </div>
                                                    <div class="remove">
                                                        <button data-id="{{ $member->id }}" class="btn btn-sm btn-danger"
                                                            id="deleteRecord"> <i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog">
        <div class="modal-dialog vertical-scrollable" role="document">
            <div class="modal-content">
                <div class="row">
                    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                        <div class="card">
                            <div class="modal-header">
                                <h5 class="modal-title"><b>Upload Member</b></h5>
                                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    {{--  <span aria-hidden="true">×</span>  --}}
                                </button>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('upload_members_excel') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="formFileSm" class="form-label">Upload Member Excel Records</label>
                                        <input class="form-control file-input form-control" id="formFileSm"
                                            name="member_file" type="file">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="save" id="edit-btn">Upload
                                            <span class="spinner-border loader1 spinner-border-sm" role="status"
                                                aria-hidden="true" style="display:none"></span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Add Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="frm_main" onsubmit='disableButton()'>
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div>
                                    <div class="mb-3">
                                        <label class="form-label">First Name</label>
                                        <input type="text" name="firstname" class="form-control"
                                            placeholder="Please insert your First Name" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Other Name</label>
                                        <input type="text" name="othername" class="form-control"
                                            placeholder="Please insert your Other Name" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Sex</label>
                                        <select class="form-select" name="sex" required>
                                            <option selected disabled value="">Select sex...</option>
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Religion</label>
                                        <select class="form-select" name="religion" required>
                                            <option selected disabled value="">Select Religion...</option>
                                            <option>Christian</option>
                                            <option>Muslim</option>
                                            <option>Others</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Account Number</label>
                                        <input type="number" class="form-control" name="account_number"
                                            placeholder="Please insert your Account Number" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Bank Name</label>
                                        <select class="form-control form-select bank_lodge" data-trigger
                                            id="choices-single-default" name="bank_name" required>
                                            <option selected disabled value="">Select Bank Name...</option>
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}">{{ $account->gl_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">

                                    <div class="mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="lastname" class="form-control"
                                            placeholder="Please insert your Last Name" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Please insert your Email" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="number" name="phone_no" class="form-control"
                                            placeholder="Please insert your Phone Number" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Home Address</label>
                                        <input type="text" name="home_address" class="form-control"
                                            placeholder="Please insert your Address" required />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Account Name</label>
                                    <input type="text" class="form-control" name="account_name"
                                        placeholder="Please enter your Account Name" required />
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary mr-2 submit-btn" name="save"
                                    id="btn">Save<span class="spinner-border loader1 spinner-border-sm"
                                        role="status" aria-hidden="true" style="display:none"></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-xl" id="editModal" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('update_memberships') }}" id="updateMember">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" id="MemberId" name="id">

                                <div class="mb-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" id="Efirstname" name="firstname" class="form-control"
                                        placeholder="Please insert your First Name" required />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Other Name</label>
                                    <input type="text" id="Eothername" name="othername" class="form-control"
                                        placeholder="Please insert your Other Name" required />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sex</label>
                                    <select class="form-select" id="Esex" name="sex" required>
                                        <option selected disabled value="">Select sex...</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Religion</label>
                                    <select class="form-select" id="EReligion" name="religion" required>
                                        <option selected disabled value="">Select Religion...</option>
                                        <option>Christian</option>
                                        <option>Muslim</option>
                                        <option>Others</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Account Number</label>
                                    <input type="number" id="Maccount_number" class="form-control"
                                        name="account_number" placeholder="Please insert your Account Number" required />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Bank Name</label>
                                    <select class="form-control form-select bank_lodge" id="Ebank_name" name="bank_name"
                                        required>
                                        <option selected disabled value="">Select Bank Name...</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->gl_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mt-3 mt-lg-0">

                                    <div class="mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" id="Elastname" name="lastname" class="form-control"
                                            placeholder="Please insert your Last Name" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" id="Eemail" name="email" class="form-control"
                                            placeholder="Please insert your Email" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="number" id="Ephone_no" name="phone_no" class="form-control"
                                            placeholder="Please insert your Phone Number" required />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Home Address</label>
                                        <input type="text" id="Ehome_address" name="home_address"
                                            class="form-control" placeholder="Please insert your Address" required />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Account Name</label>
                                    <input type="text" id="Eaccount_name" class="form-control" name="account_name"
                                        placeholder="Please enter your Account Name" required />
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary mr-2 submit-btn"
                                    id="update-btn">Update<span class="spinner-border loader1 spinner-border-sm"
                                        role="status" aria-hidden="true" style="display:none"></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- end main content-->
@endsection
<!-- JAVASCRIPT -->
@section('scripts')
    <script src="{{ asset('js\requestController.js') }}"></script>
    <script src="{{ asset('js\formController.js') }}"></script>
    <script src="{{ asset('js/sweetalert/dist/sweetalert.min.js') }}"></script>
    @include('layouts.datatable')
    {{-- @include('includes.js') --}}
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('body').on('click', '#edit-member', function() {
                // alert("Nathaniel")
                var id = $(this).data('id');
                $.get("{{ route('getmembershipInfos') }}?id=" + id, function(data) {
                    // alert('hhgf');

                    $('#EStaff').val(data.staff_id);
                    $('#Efirstname').val(data.firstname);
                    $('#Elastname').val(data.lastname);
                    $('#Eothername').val(data.othername);
                    $('#EReligion').val(data.religion);
                    $('#Eemail').val(data.email);
                    $('#Esex').val(data.sex);
                    $('#Ehome_address').val(data.home_address)
                    $('#Ephone_no').val(data.phone_no);
                    $('#Maccount_number').val(data.account_number);
                    $('#Eaccount_name').val(data.account_name);
                    $('#Ebank_name').val(data.bank_name);
                    // $('#MGlcode').val(data.glcode);
                    $('#MemberId').val(id);
                })
            });
        });
    </script>

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
                        const postRequest = await request("/admin/membership/membership_store",
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
                        var loader = $(".loader1");
                        loader.hide();
                    }
                }
            })

            $("#update_membership").on('submit', async function(e) {
                e.preventDefault();
                const serializedData = $("#update_membership").serializeArray();

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
                    // console.log(willUpdate);
                    //if (willUpdate.isConfirmed == true) {
                    if (willUpdate) {
                        //performReset()
                        const postRequest = await request("/admin/membership/update_membership",
                            processFormInputs(
                                serializedData), 'post');
                        console.log('postRequest.message', postRequest.message);
                        new swal("Good Job", postRequest.message, "success");
                        var loader = $(".loader1");
                        loader.hide();
                        $('#update_membership').trigger("reset");
                        $("#update_membership .close").click();
                        window.location.reload();
                    } else {
                        new swal("Process aborted  :)");
                        loader.hide();
                    }

                } catch (e) {
                    if ('message' in e) {
                        console.log('e.message', e.message);
                        new swal("Opss", e.message, "error");
                        loader.hide();
                    }
                }
            })

            $("#update-btn").on('click', async function(e) {
                e.preventDefault();
                var loader = $(".loader1");
                loader.show();
                try {

                    const willUpdate = await new swal({
                        title: "Confirm Form submit",
                        text: `Are you sure you want to submit this form?`,
                        icon: "warning",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes!",
                        showCancelButton: true,
                        buttons: ["Cancel", "Yes, Submit"]
                    });
                    // console.log(willUpdate);
                    //if (willUpdate.isConfirmed == true) {
                    if (willUpdate) {
                        //performReset()
                        $("#updateMember").submit();
                    } else {
                        new swal("Record will not be updated  :)");
                    }
                } catch (e) {
                    if ('message' in e) {
                        console.log('e.message', e.message);
                        new swal("Opss", e.message, "error");
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
                    text: `Are you sure you want to delete this Member Account?`,
                    icon: "warning",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes!",
                    showCancelButton: true,
                    buttons: ["Cancel", "Yes, Delete"]
                });
                // console.log(willUpdate);
                //if (willUpdate.isConfirmed == true) {
                if (willUpdate) {
                    //performReset()
                    performDelete(el, user_id);
                } else {
                    new swal("Member Account record will not be deleted  :)");
                    loader.hide();
                }
            }

            function performDelete(el, user_id) {
                //alert(user_id);
                try {
                    $.get('{{ route('delete_memberships') }}?id=' + user_id,
                        function(data, status) {
                            console.log(status);
                            console.table(data);
                            if (status === "success") {
                                let alert = new swal("Member Account successfully deleted!.");
                                $(el).closest("tr").remove();
                                //window.location.reload();
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

    {{--  <script>
        function disableButton() {
            var btn = document.getElementById('btn');
            btn.disabled = true;
            // btn.innerText = 'Submitting...'
        }
    </script>  --}}
    {{--  <script>
        $(document).ready(function() {

            $("form").on('submit', async function(e) {
                var loader = $(".loader1");
                //alert('here');
                loader.show();
            })

        });
    </script>  --}}
@endsection
