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
                        <h4 class="mb-sm-0 font-size-18">Manage Savings</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/home">{{ Auth::user()->name }}</a></li>
                                <li class="breadcrumb-item active">Savings</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex">
                            <h4 class="card-title">Savings List</h4>
                            <button class="btn btn-sm btn-primary ms-auto" data-bs-toggle="modal" id="edit-employee"
                                data-bs-target="#addModal">
                                <i class="fa fa-plus"></i> Add Savings</button>
                        </div>

                        <div class="card-body">
                            {{-- @include('includes.alert') --}}
                            <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        {{--  <th>Glcode</th>  --}}
                                        <th>Descriptions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($savings as $saving)
                                        <tr>
                                            {{-- <td>{{ ++$i }}</td> --}}
                                            <td>{{ $loop->iteration }}</td>
                                            {{--  <td>{{ $saving->glcode }}</td>  --}}
                                            <td>{{ $saving->description }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <button class="btn btn-sm btn-primary edit-item-btn"
                                                            data-bs-toggle="modal" id="edit-saving"
                                                            data-id="{{ $saving->id }}" data-bs-target="#editModal"><i
                                                                class="fa fa-edit"></i></button>
                                                    </div>
                                                    <div class="remove">
                                                        <button data-id="{{ $saving->id }}" class="btn btn-sm btn-danger"
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
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
                <div class="modal-dialog vertical-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><b>Add Savings</b></h5>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" id="frm_main" onsubmit='disableButton()'>
                                @csrf
                                <div class="row">
                                    <div>

                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <input type="text" name="description" class="form-control"
                                                placeholder="Please insert your Description" required />
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary mr-2 submit-btn" name="save"
                                            id="btn">Save<span class="spinner-border loader1 spinner-border-sm"
                                                role="status" aria-hidden="true" style="display:none"></span></button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page-content -->
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog vertical-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Edit Savings</b></h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('update_savings') }}" id="updateSaving">
                        @csrf
                        <div class="row">
                            <div>
                                <input type="hidden" id="SavingId" name="id">

                                <div class="mb-3">
                                    <label class="form-label">Glcode</label>
                                    <input type="text" name="glcode" class="form-control" id="SGlcode"
                                        placeholder="Please insert your Glcode" required />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" name="description" class="form-control" id="Ssaving"
                                        placeholder="Please insert your Description" required />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary mr-2 submit-btn"
                                    id="update-btn">Update<span class="spinner-border loader1 spinner-border-sm"
                                        role="status" aria-hidden="true" style="display:none"></span></button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- JAVASCRIPT -->
@section('scripts')
    <script src="{{ asset('js\requestController.js') }}"></script>
    <script src="{{ asset('js\formController.js') }}"></script>
    <script src="{{ asset('js/sweetalert/dist/sweetalert.min.js')}}"></script>
    @include('layouts.datatable')
    {{--  @include('includes.js')  --}}
    <script>
        $(document).ready(function() {
            $('body').on('click', '#edit-saving', function() {
                // alert("Nathaniel")
                var id = $(this).data('id');
                $.get("{{ route('get_saving_by_id') }}?id=" + id, function(data) {
                    // alert('hhgf');

                    $('#EStaff').val(data.staff_id);
                    $('#SGlcode').val(data.glcode);
                    $('#Ssaving').val(data.description);
                    $('#SavingId').val(id);
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
                        //  alert('here')
                        const postRequest = await request("/admin/savings/saving_store",
                            processFormInputs(
                                serializedData), 'post');
                        console.log('postRequest.message', postRequest.message);
                        new swal("Good Job", postRequest.message, "success");
                        var loader = $("#loader1");
                        loader.show();
                        $('#frm_main').trigger("reset");
                        $("#frm_main .close").click();
                        window.location.reload();
                    } else {
                        new swal("Process aborted  :)");
                        /**  var loader = $("#loader1");
                         loader.show();**/
                    }

                } catch (e) {
                    if ('message' in e) {
                        console.log('e.message', e.message);
                        new swal("Opss", e.message, "error");
                    }
                }
            })

            $("#update_saving").on('submit', async function(e) {
                e.preventDefault();
                const serializedData = $("#update_saving").serializeArray();

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
                    //if (willUpdate.isConfirmed == true) {
                    if (willUpdate) {
                        //performReset()
                        const postRequest = await request("/admin/savings/update_saving",
                            processFormInputs(
                                serializedData), 'post');
                        console.log('postRequest.message', postRequest.message);
                        new swal("Good Job", postRequest.message, "success");
                        $('#update_saving').trigger("reset");
                        $("#update_saving .close").click();
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
                        $("#updateSaving").submit();
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
                    text: `Are you sure you want to delete this Saving?`,
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
                    new swal("Saving record will not be deleted  :)");
                }
            }

            function performDelete(el, user_id) {
                //alert(user_id);
                try {
                    $.get('{{ route('delete_savings') }}?id=' + user_id,
                        function(data, status) {
                            console.log(status);
                            console.table(data);
                            if (status === "success") {
                                let alert = new swal("Saving Record successfully deleted!.");
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
        function disableButton() {
            var btn = document.getElementById('btn');
            btn.disabled = true;
            // btn.innerText = 'Submitting...'
        }
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
