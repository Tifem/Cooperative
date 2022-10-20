@extends('layouts.master')

@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <!--app-content open-->
    <div id="layout-wrapper">
        <div class="main-content">


            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Admin</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Manage Approval Levels</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Approval Level</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>



            <!-- Row -->
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex">
                            <h3 class="card-title">Modules</h3>
                            <a class="modal-effect btn btn-primary d-grid ms-auto" data-bs-effect="effect-super-scaled"
                                data-bs-toggle="modal" href="#modaldemo8">Set New Approval Level</a>
                        </div>

                        <div class="card-body">
                            @include('includes.alert')
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap nowrap key-buttons border-bottom  w-100"
                                    id="datatable-buttons">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">SN</th>
                                            <th class="wd-15p border-bottom-0">Module</th>
                                            <th class="wd-20p border-bottom-0">Created At</th>
                                            <th class="wd-25p border-bottom-0">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($modules as $module)
                                            <tr>
                                                <td>{{ $module->id }}</td>
                                                <td>{{ $module->module }}</td>
                                                <td>{{ $module->created_at }}</td>

                                                <td>
                                                    <a class="btn btn-info"
                                                        href="{{ route('edit_approval_level', $module->id) }}">Show</a>
                                                    <a class="btn btn-primary"
                                                        href="{{ route('edit_approval_level', $module->id) }}">Edit</a>
                                                    <button type="button" id="deleteRecord" data-id="{{ $module->id }}"
                                                        class="btn btn-danger waves-effect waves-light btn-sm">
                                                        <i class="mdi mdi-trash-can"></i> Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modaldemo8">
                <div class="modal-dialog vertical-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title">Set New Approval Level</h6><button type="button" aria-label="Close"
                                class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form id="frm_man" method="post" action="{{ route('create_approval_level') }}">
                            @csrf
                            <div class="modal-body">

                                <div class="form-group  mb-4">
                                    <label>Module</label>

                                    <select class="form-control" name="module">
                                        <option value="Payment Voucher">Payment Voucher</option>
                                        <option value="Stock Requisition">Stock Requisition</option>
                                    </select>
                                </div>

                                <div id="othertins">
                                    <div class="repeater">
                                        <div data-repeater-list="joints">
                                            <div data-repeater-item>
                                                <div class="row">
                                                    <div class="col-md-10">

                                                        <div class="form-group">
                                                            <label class="">Role</label>

                                                            <select class="form-control" name="role">
                                                                @foreach ($roles as $role)
                                                                    <option value="{{ $role->id }}">{{ $role->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="form-text text-muted">Please select them in the way
                                                                you
                                                                want
                                                                them to first see it
                                                            </span>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-2">

                                                        <div class="form-group">
                                                            <label for="">..</label>

                                                            <button type="button"
                                                                class="btn btn-danger btn-md form-control"
                                                                data-repeater-delete="">Del</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="form-group row">
                                        <div class="col-lg-12 d-flex flex-row-reverse">


                                            <input data-repeater-create type="button"
                                                class="btn btn-success btn-sm float-right" value="Add More"
                                                id="addtothis" /><br>
                                        </div>
                                    </div>

                                </div>
                                </div>
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary waves-effect"
                                    data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Row -->
            </div>
        </div>
    </div>

    <!-- CONTAINER CLOSED -->
@endsection

@section('scripts')
    <script src="{{ asset('js\requestController.js') }}"></script>
    <script src="{{ asset('js\formController.js') }}"></script>

    <script src="{{ asset('js\repeater.js') }}"></script>
    <script src="{{ asset('js\repeater.min.js') }}"></script>


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
                try {
                    const postRequest = await request("/admin/approval_level/createapproval",
                        processFormInputs(
                            serializedData), 'post');
                    console.log('postRequest.message', postRequest.message);
                    swal("Good Job", "Approval Level created successfully!.", "success");
                    $('#frm_main').trigger("reset");
                    $("#frm_main .close").click();
                    window.location.reload();
                } catch (e) {
                    if ('message' in e) {
                        console.log('e.message', e.message);
                        swal("Opss", e.message, "error");
                    }
                }
            })




            //Start Edit Record
            var table = $('#datatable-buttons').DataTable();

            table.on('click', '#edit', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);

                $('#descr').val(data[1]);


                var user_id = $(this).data('id');
                $('#id').val(user_id)
                $('#editModal').modal('show');
            });


            /* When click delete button */
            $('body').on('click', '#deleteRecord', function() {

                var user_id = $(this).data('id');

                var token = $("meta[name='csrf-token']").attr("content");
                var el = this;
                // alert(user_id);
                resetAccount(el, user_id);
            });


            async function resetAccount(el, user_id) {

                const willUpdate = await swal({
                    title: "Confirm Approval Level Delete",
                    text: `Are you sure you want to delete this Approval record?`,
                    icon: "warning",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes!",
                    showCancelButton: true,
                    buttons: ["Cancel", "Yes, Delete"]
                });

                console.log(willUpdate);
                if (willUpdate) {
                    //performReset()
                    // alert("h");
                    // performDelete(el, user_id);
                } else {
                    //  alert("hrr");
                    swal("Approval record will not be deleted  :)");
                }
            }


            function performDelete(el, user_id) {
                try {
                    $.get('{{ route('delete_approval_level') }}?id=' + user_id,
                        function(data, status) {
                            console.log(status);
                            console.table(data);
                            if (status === "success") {
                                let alert = swal("Approval successfully deleted!.");
                                $(el).closest("tr").remove();

                            }
                        }
                    );
                } catch (e) {
                    let alert = swal(e.message);
                }
            }


        })
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('.repeater').repeater({
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
            });




            $(function() {
                $("#hidee").click(function() {
                    if ($(this).is(":checked")) {
                        $("#othertins").hide();
                    }
                });
            });
            $(function() {
                $("#showww").click(function() {
                    if ($(this).is(":checked")) {
                        $("#othertins").show();
                    }
                });
            });
        });
    </script>
@endsection
