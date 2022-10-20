@extends('layouts.master')

@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <!--app-content open-->
    <div class="side-app">
        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <!-- PAGE-HEADER -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">{{ $approval_leveldetail->module }} Approval Level</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Manage Approval Levels</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Approval Level</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE-HEADER END -->

            <!-- Row -->
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex">
                            <h3 class="card-title">Edit Approval Level</h3>
                            <a class="modal-effect btn btn-primary d-grid ms-auto" data-bs-effect="effect-super-scaled"
                                data-bs-toggle="modal" href="#modaldemo8">Edit Approval Level</a>
                        </div>

                        <div class="card-body">
                            @include('includes.alert')
                            <div class="table-responsive">

                                <table class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <tr>
                                        <th>Module:</th>
                                        <td>{{ $approval_leveldetail->module }}</td>
                                    </tr>
                                    @foreach ($rolenamelisttt as $role)
                                        <tr>
                                            <th>Approver {{ ++$i }}:</th>
                                            <td><a href="/admin/approval_level/list/{{ $role }}"
                                                    tooltip="click to view users with this role"> {{ $role }} </a>
                                            </td>

                                        </tr>
                                    @endforeach




                                </table>
                            </div>
                        </div>
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
                <form id="frm_man" method="post" action="{{ route('update_approval_level',[$approval_leveldetail->id]) }}">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group  mb-4">
                            <label>Module</label>

                            <select class="form-control" name="module">
                                <option value="Payment Voucher">Payment Voucher</option>
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
                        <button class="btn btn-primary" type="submit">

                            <span class="me-2">Submit</span>

                            <span  class="spinner-border loader2 spinner-border-sm" role="status"
                            aria-hidden="true" style="display:none"></span>
                        </button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Row -->
    </div>

    <!-- CONTAINER CLOSED -->
@endsection

@section('scripts')
    <script src="{{ asset('js\requestController.js') }}"></script>
    <script src="{{ asset('js\formController.js') }}"></script>

    <script src="{{ asset('js\repeater.js') }}"></script>
    <script src="{{ asset('js\repeater.min.js') }}"></script>


    @include('includes.datatable')



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
                if (willUpdate) {
                    //performReset()
                    // alert("h");
                    performDelete(el, user_id);
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
