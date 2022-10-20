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
                        <h4 class="mb-sm-0 font-size-18">Monthly Saving Deductions</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/home">{{Auth::user()->name}}</a></li>
                                <li class="breadcrumb-item active">Monthly Saving Deductions</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex">
                            <h4 class="card-title">Monthly Saving Deduction</h4>
                            {{-- <button class="btn btn-sm btn-primary ms-auto"
                            data-bs-toggle="modal" id="edit-employee" data-bs-target="#addModal">
                            <i class="fa fa-plus"></i> Add Monthly Saving Deduction</button> --}}
                        </div>

                        <div class="card-body">
                            {{-- @include('includes.alert') --}}
                            <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Member_id</th>
                                        <th>glcode</th>
                                        <th>Amount</th>
                                        <th>Transaction Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($msdeductions as $msdeduction)
                                    <tr>
                                        {{-- <td>{{ ++$i }}</td> --}}
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $msdeduction->member_id }}</td>
                                        <td>{{ $msdeduction->glcode }}</td>
                                        <td>{{ $msdeduction->amount }}</td>
                                        <td>{{ $msdeduction->transaction_date }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <div class="edit">
                                                    <button class="btn btn-sm btn-primary edit-item-btn"
                                                    data-bs-toggle="modal" id="edit-msdeduction" data-id="{{$msdeduction->id}}" data-bs-target="#editModal"><i class="fa fa-edit"></i></button>
                                                </div>
                                                <div class="remove">
                                                    <button data-id="{{$msdeduction->id}}" class="btn btn-sm btn-danger" id="deleteRecord"> <i class="fa fa-trash"></i></button>
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
            {{-- <div class="modal fade"  id="addModal" tabindex="-1" role="dialog" >
                <div class="modal-dialog vertical-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" ><b>Add Monthly Saving Deduction</b></h5>
                            <button  class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                            <div class="card-body p-4">
                                <form method="POST" id="frm_main">
                                    @csrf
                                        <div class="row">
                                            <div>
                                                <div class="mb-3">
                                                    <label class="form-label">Glcode</label>
                                                    <input type="text"  name="glcode" class="form-control" placeholder="Please insert your Glcode" required />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Amount</label>
                                                    <input type="text"  name="amount" class="form-control" placeholder="Please insert your Amount" required />
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Transaction Date</label>
                                                    <input type="date" class="form-control" data-provider="flatpickr"
                                                        name="transaction_date" id="EndleaveDate" required>
                                                </div>
                                            </div>

                                            </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            <button  type="submit" class="btn btn-primary mr-2 submit-btn" name="save">Save<span  class="spinner-border loader1 spinner-border-sm" role="status"
                                                aria-hidden="true" style="display:none"></span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Page-content -->
            </div>

            <div class="modal fade"  id="editModal" tabindex="-1" role="dialog" >
                <div class="modal-dialog vertical-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" ><b>Edit Monthly Saving Deduction</b></h5>
                            <button  class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                            <div class="card-body p-4">
                                <form method="POST" action="{{route('updatesaving_deductions')}}" id="updateMSDeduction">
                                    @csrf
                                        <div class="row">
                                            <div>
                                                <input type="hidden" id="MSId" name="id">
                                                <div class="mb-3">
                                                    <label class="form-label">Member Id</label>
                                                    <input type="text"  name="member_id" class="form-control" id="Mmember" readonly />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Glcode</label>
                                                    <input type="text"  name="glcode" class="form-control" id="MGlcode" placeholder="Please insert your Glcode" required />
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Amount</label>
                                                    <input type="text"  name="amount" class="form-control" id="Mamount" placeholder="Please insert your Amount" required />
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Tansaction Date</label>
                                                    {{-- <input type="text" class="form-control" data-provider="flatpickr" id="Mtdate" name="transaction_date"  value="{{$msdeductions->transaction_date}}" required> --}}
                                                    {{-- <input type="date" class="form-control" data-provider="flatpickr" id="Mtdate" name="transaction_date" required>
                                                </div>

                                            </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            <button  type="submit" class="btn btn-primary mr-2 submit-btn" id="update-btn">Update<span  class="spinner-border loader1 spinner-border-sm" role="status"
                                                aria-hidden="true" style="display:none"></span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Page-content -->
            </div> --}}
        <!-- end main content-->
    </div>
@endsection
        <!-- JAVASCRIPT -->
@section('scripts')
    <script src="{{ asset('js\requestController.js')}}"></script>
    <script src="{{ asset('js\formController.js')}}"></script>
    {{-- <script src="{{ asset('js/sweetalert/dist/sweetalert.min.js')}}"></script> --}}
    @include('layouts.datatable')
    @include('includes.js')
  <script>
    $(document).ready(function () {
    $('body').on('click', '#edit-msdeduction', function () {
        // alert("Nathaniel")
        var id = $(this).data('id');
        $.get('{{ route('getsaving_deductionInfos') }}?id=' + id, function(data) {
            // alert('hhgf');
        $('#Mmember').val(data.member_id);
        $('#MGlcode').val(data.glcode);
        $('#Mamount').val(data.amount);
        $('#Mtdate').val(data.transaction_date);
        $('#MSId').val(id);
        })
        }
    );
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
            if (willUpdate.isConfirmed == true) {
                //performReset()
            //  alert('here')
                const postRequest = await request("/admin/saving_deduction/saving_deductionstore",
                    processFormInputs(
                        serializedData), 'post');
                console.log('postRequest.message', postRequest.message);
                new swal("Good Job",postRequest.message , "success");
                $('#frm_main').trigger("reset");
                $("#frm_main .close").click();
                window.location.reload();
            } else {
                var loader = $("#loader1");
            loader.hide();
            new swal("Process aborted  :)");

            }

            } catch (e) {
                if ('message' in e) {
                    console.log('e.message', e.message);
                    var loader = $("#loader1");
                    loader.hide();
                    new  swal("Opss", e.message, "error");
                }
            }
        })

        $("#update_Monthly_Saving_Deduction").on('submit', async function(e) {
            e.preventDefault();
            const serializedData = $("#update_Monthly Saving Deduction").serializeArray();

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
                const postRequest = await request("/admin/saving_deduction/updatesaving_deduction",
                    processFormInputs(
                        serializedData), 'post');
                console.log('postRequest.message', postRequest.message);
                new swal("Good Job",postRequest.message , "success");
                $('#update_Monthly Saving Deduction').trigger("reset");
                $("#update_Monthly Saving Deduction .close").click();
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
                    if (willUpdate.isConfirmed == true) {
                        //performReset()
                        $("#updateMSDeduction").submit();
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
                text: `Are you sure you want to delete this Monthly Saving Deduction?`,
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
                new swal("Monthly Saving Deduction record will not be deleted  :)");
            }
        }

        function performDelete(el, user_id) {
            //alert(user_id);
            try {
                $.get('{{ route('deletesaving_deductions') }}?id=' + user_id,
                    function(data, status) {
                        console.log(status);
                        console.table(data);
                        if (status === "success") {
                            let alert = new swal("Monthly Saving Deduction Record successfully deleted!.");
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
