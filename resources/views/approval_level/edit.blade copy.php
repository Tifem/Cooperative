@extends('layouts.master')


@section('headlinks')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">


@endsection

@section('content')


    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">{{ $approval_leveldetail->module }} Approval Level</h4>

                        <div class="page-title-right">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal"
                                data-target="#myModal">Edit Approval Level</button>
                            <a href="/admin/approval_level" class="btn btn-secondary btn-sm">Go back</a>

                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            {{-- @include("includes.alert.alert") --}}

                            <table class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <tr>
                                    <th>Module:</th>
                                    <td>{{ $approval_leveldetail->module }}</td>
                                </tr>
                                @foreach ($rolenamelisttt as $role)
                                    <tr>
                                        <th>Approver {{ ++$i }}:</th>
                                   <td><a href="/admin/approval_level/list/{{ $role }}" tooltip="click to view users with this role"> {{ $role }} </a> </td>

                                    </tr>

                                @endforeach




                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Edit Approval Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frm_man" method="post" action="{{ route('update_approval_level',[$approval_leveldetail->id]) }}">
                @csrf
                <div class="modal-body">

                    <div class="form-group row mb-4">
                        <label for="" class="col-sm-3 col-form-label">Module</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="module">
                                <option value="Direct Assessment"
                                    {{ $approval_leveldetail->module == 'Direct Assessment' ? 'selected' : 'style=display:none' }}>
                                    Direct Assessment</option>
                                <option value="TAMA"
                                    {{ $approval_leveldetail->module == 'TAMA' ? 'selected' : 'style=display:none' }}>
                                    TAMA</option>
                                <option value="StampDuty"
                                    {{ $approval_leveldetail->module == 'StampDuty' ? 'selected' : 'style=display:none' }}>
                                    StampDuty</option>


                               <option value="TCC DA"
                                    {{ $approval_leveldetail->module == 'TCC DA' ? 'selected' : 'style=display:none' }}>
                                    Tax Clearance Certificate DA</option>
                               <option value="TCC PAYE"
                                    {{ $approval_leveldetail->module == 'TCC PAYE' ? 'selected' : 'style=display:none' }}>
                                    Tax Clearance Certificate (PAYE)</option>
                            </select>
                        </div>
                    </div>
                    <div id="othertins">
                        <div class="repeater">
                            <div data-repeater-list="joints">
                                <div data-repeater-item>
                                    <div class="form-group row">
                                        <label class="col-form-label  col-lg-3 col-sm-12">Role</label>
                                        <div class="col-lg-7 col-md-7 col-sm-12 ">
                                            <select class="form-control" name="role">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>

                                                @endforeach

                                            </select>
                                            <span class="form-text text-muted">Please select them in the way you want
                                                them to first see it
                                            </span>
                                        </div>
                                        <div class="col-md-2">

                                            <div class="form-group">


                                                <button type="button" class="btn btn-danger btn-md form-control"
                                                    data-repeater-delete="">Del</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">


                                    <input data-repeater-create type="button"
                                        class="btn btn-success btn-sm float-lg-right" value="Add More"
                                        id="addtothis" /><br>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                </div>
            </form>
        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



@endsection


@section('scripts')
    {{-- <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js') }}">
    </script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.js') }}">
    </script> --}}
    @include("includes.datatable")


    <script src="{{ asset('js\requestController.js') }}"></script>
    <script src="{{ asset('js\formController.js') }}"></script>

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
                    const postRequest = await request("/admin/approval_level/create", processFormInputs(
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
