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
                        <h4 class="mb-sm-0 font-size-18">Manage Deduction Template </h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/home">{{ Auth::user()->name }}</a></li>
                                <li class="breadcrumb-item active">Deduction Template</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex">
                            <h4 class="card-title">Deduction Template </h4>
                            <button class="btn btn-sm btn-primary ms-auto" data-bs-toggle="modal" id="edit-employee"
                            data-bs-target="#addModal">
                            <i class="fa fa-plus"></i> Set Template Deduction</button>
                        </div>

                        <div class="card-body">
                            {{--  @include('includes.alert')  --}}
                            <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Account</th>
                                        <th>Position</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($settings as $setting)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $setting->account() }}</td>
                                            <td>{{ $setting->position }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <button class="btn btn-sm btn-primary edit-item-btn"
                                                            data-bs-toggle="modal" id="edit-template"
                                                            data-id="{{ $setting->id }}" data-bs-target="#editModal"><i
                                                                class="fa fa-edit"></i></button>
                                                    </div>
                                                    <div class="remove">
                                                        <button data-id="{{ $setting->id }}" class="btn btn-sm btn-danger"
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
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog vertical-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Set Position</b></h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="card-body p-4">
                    <form method="POST" id="frm_main">
                        @csrf
                        <div class="row">
                                <div class="mb-3">
                                    <label for="">Account</label>
                                    <select name="account_id" class="form-control form-select " data-trigger id="choices-single-default bank_lodge" required>
                                        <option value="">Choose Account</option>
                                        @foreach($accounts as $key => $account)
                                            <option value="{{ $account->id }}">{{ $account->description }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Position</label>
                                    <input type="number" name="position" class="form-control"
                                        placeholder="Please specify position" required />
                                </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" onClick="this.disabled=true" class="btn btn-primary mr-2 submit-btn"
                                    name="save">Save<span class="spinner-border loader1 spinner-border-sm"
                                        role="status" aria-hidden="true" style="display:none"></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog vertical-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Edit Position</b></h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('update_templates') }}" id="updateTemplate">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="TemplateId" name="id">
                            <div class="mb-3">
                                <label for="">Account</label>
                                <select name="account_id" id="templateAccount" class="form-control form-select " required>
                                    <option value="">Choose Account</option>
                                    @foreach($accounts as $key => $account)
                                        <option value="{{ $account->id }}">{{ $account->description }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Position</label>
                                <input type="number" name="position" id="templatePosition" class="form-control"
                                    placeholder="Please specify position" required />
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" onClick="this.disabled=true" class="btn btn-primary mr-2 submit-btn" name="save"
                                    id="update-btn">Save Change<span class="spinner-border loader1 spinner-border-sm"
                                        role="status" aria-hidden="true" style="display:none"></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end main content-->
    </div>
@endsection
<!-- JAVASCRIPT -->
@section('scripts')
   <!-- choices js -->
   <script src="{{asset('assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
   <!-- datepicker js -->
   <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
   <!-- init js -->
   <script src="{{asset('assets/js/pages/form-advanced.init.js')}}"></script>
    <script src="{{ asset('js\requestController.js') }}"></script>
    <script src="{{ asset('js\formController.js') }}"></script>
    <script src="{{ asset('js/sweetalert/dist/sweetalert.min.js') }}"></script>
    @include('layouts.datatable')
    @include('includes.js')
    <script>
        $(document).ready(function() {
            $('body').on('click', '#edit-template', function() {
                // alert("Nathaniel")
                var id = $(this).data('id');
                $.get('{{ route('get_templates') }}?id=' + id, function(data) {
                    // alert('hhgf');

                    $('#templateAccount').val(data.account_id);
                    $('#templatePosition').val(data.position);
                    $('#TemplateId').val(id);
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

                var loader = $("#loader1");
                loader.show();

                try {
                    const postRequest = await request("/admin/template-setting/save",
                        processFormInputs(
                            serializedData), 'post');
                    console.log('postRequest.message', postRequest.message);
                    new swal("Good Job", postRequest.message, "success");
                    $('#frm_main').trigger("reset");
                    $("#frm_main .close").click();
                    window.location.reload();

                } catch (e) {
                    if ('message' in e) {
                        console.log('e.message', e.message);
                        var loader = $("#loader1");
                        loader.hide();
                        new swal("Opss", e.message, "error");
                    }
                }
            })

            $("#update_temp").on('submit', async function(e) {
                e.preventDefault();
                const serializedData = $("#update_temp").serializeArray();

                var loader = $("#loader1");
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
                    if (willUpdate.isConfirmed == true) {
                        //performReset()
                        const postRequest = await request("/admin/template-setting/update_template",
                            processFormInputs(
                                serializedData), 'post');
                        console.log('postRequest.message', postRequest.message);
                        new swal("Good Job", postRequest.message, "success");
                        $('#update_temp').trigger("reset");
                        $("#update_temp .close").click();
                        window.location.reload();
                    } else {
                        new swal("Process aborted  :)");
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
                var loader = $("#loader1");
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
                        $("#updateTemplate").submit();
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
                    text: `Are you sure you want to delete this Record ?`,
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
                    new swal("Record will not be deleted  :)");
                }
            }

            function performDelete(el, user_id) {
                //alert(user_id);
                try {
                    $.get('{{ route('delete_templates') }}?id=' + user_id,
                        function(data, status) {
                            console.log(status);
                            console.table(data);
                            if (status === "success") {
                                let alert = new swal("Record successfully deleted!.");
                                $(el).closest("tr").remove();
                                window.location.reload();
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

            $("form").on('submit', async function(e) {
                var loader = $(".loader1");
                //alert('here');
                loader.show();
            })

        });
    </script>
@endsection
