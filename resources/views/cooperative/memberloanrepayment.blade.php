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
                        <h4 class="mb-sm-0 font-size-18">Loan Repayment</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/home">{{Auth::user()->name}}</a></li>
                                <li class="breadcrumb-item active">Loan Repayments</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex">
                            <h4 class="card-title">Loan Repayments</h4>
                            <button class="btn btn-sm btn-primary ms-auto"
                            data-bs-toggle="modal" id="edit-employee" data-bs-target="#addModal">
                            <i class="fa fa-plus"></i>LoanPayment</button>
                        </div>

                        <div class="card-body">
                            @include('includes.alert')
                            <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Transaction Date</th>
                                        <th>Member Name</th>
                                        <th>Loan Name</th>
                                        <th>Amount Paid</th>
                                        <th>Bank</th>
                                        <th>Teller Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($repays as $repay)
                                    <tr>
                                        {{-- <td>{{ ++$i }}</td> --}}
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $repay->transactiondate}}</td>
                                        <td>{{ $repay->member_name }}</td>
                                        <td>{{ $repay->loan_name }}</td>
                                        <td>{{ $repay->amount_paid }}</td>
                                        <td>{{ $repay->bnk->name . " (". $repay->bnk->shortcode .")" ?? $repay->repay}}</td>
                                        <td>{{ $repay->teller_number }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <div class="edit">
                                                    <button class="btn btn-sm btn-primary edit-item-btn"
                                                    data-bs-toggle="modal" id="edit-loan" data-id="{{$repay->id}}" data-bs-target="#editModal"><i class="fa fa-edit"></i></button>
                                                </div>
                                                <div class="remove">
                                                    <button data-id="{{$repay->id}}" class="btn btn-sm btn-danger" id="deleteRecord"> <i class="fa fa-trash"></i></button>
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
            <div class="modal fade"  id="addModal" tabindex="-1" role="dialog" >
                <div class="modal-dialog vertical-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" ><b>Loan Repayment</b></h5>
                            <button  class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                            <div class="card-body p-4">
                                <form method="POST" id="frm_main">
                                    @csrf
                                        <div class="row">
                                            <div class="mb-3">
                                                <label class="form-label">Transaction Date</label>
                                                <input type="date" name="transactiondate" class="form-control"  placeholder="Please insert your Transaction Date" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Member Name </label>
                                                <input type="text" name="member_name" class="form-control"  placeholder="Please insert your Member Name" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Loan Name</label>
                                                <input type="text" name="loan_name" class="form-control"  placeholder="Please insert your Loan Name" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Amount Paid</label>
                                                <input type="text" name="amount_paid" class="form-control"  placeholder="Please insert your Amount Paid" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Bank</label>
                                                {{-- <input type="text" name="bank" class="form-control"  placeholder="Please insert your Bank" required/> --}}
                                                <select class="form-select" name="bank" required>>
                                                    <option selected disabled >Select Bank...</option>
                                                    @foreach($banks as $bank)
                                                         <option value="{{$bank->id}}">{{$bank->name . "(". $bank->shortcode .")"}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Teller Number</label>
                                                <input type="text" name="teller_number" class="form-control"  placeholder="Please insert your Teller Number" required/>
                                            </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            <button  type="submit" onClick="this.disabled=true" class="btn btn-primary mr-2 submit-btn" name="save">Save<span  class="spinner-border loader1 spinner-border-sm" role="status"
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
                            <h5 class="modal-title" ><b>Edit Loan Repayment</b></h5>
                            <button  class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                            <div class="card-body p-4">
                                <form method="POST" action="{{route('updatememberloan_repayments')}}" id="updateLoan">
                                    @csrf
                                        <div class="row">
                                            <input type="hidden" id="loanId" name="id" >
                                            <div class="mb-3">
                                                <label class="form-label">Transaction Date</label>
                                                <input type="text" name="transactiondate" class="form-control" id="Ldate" placeholder="Please insert your Transaction Date" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Member Name </label>
                                                <input type="text" name="member_name" class="form-control"  id="Lmember" placeholder="Please insert your Member Name" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Loan Name</label>
                                                <input type="text" name="loan_name" class="form-control"  id="Lloan" placeholder="Please insert your Loan Name" required/>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Amount Paid</label>
                                                <input type="text" name="amount_paid" class="form-control"  id="Lamount" placeholder="Please insert your Amount Paid" required/>
                                            </div>
                                            <div class="mb-3">
                                                <select class="form-select" name="bank" id="Lbank" required>>
                                                    <option selected disabled >Select Bank...</option>
                                                    @foreach($banks as $bank)
                                                         <option value="{{$bank->id}}">{{$bank->name . "(". $bank->shortcode .")"}}</option>
                                                         @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Teller Number</label>
                                                <input type="text" name="teller_number" class="form-control"  id="Lteller" placeholder="Please insert your Teller Number" required/>
                                            </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            <button  type="submit" onClick="this.disabled=true" class="btn btn-primary mr-2 submit-btn" id="update-btn">Update<span  class="spinner-border loader1 spinner-border-sm" role="status"
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
        <!-- end main content-->
    </div>
@endsection
        <!-- JAVASCRIPT -->
@section('scripts')
    <script src="{{ asset('js\requestController.js')}}"></script>
    <script src="{{ asset('js\formController.js')}}"></script>
    <script src="{{ asset('js/sweetalert/dist/sweetalert.min.js')}}"></script>
    @include('layouts.datatable')
    @include('includes.js')
  <script>
    $(document).ready(function () {
    $('body').on('click', '#edit-loan', function () {
        // alert("Nathaniel")
        var id = $(this).data('id');
        $.get('{{ route('getmemberloan_repaymentInfos') }}?id=' + id, function(data) {
            // alert('hhgf');

        $('#Ldate').val(data.transactiondate);
        $('#Lmember').val(data.member_name);
        $('#Lloan').val(data.loan_name);
        $('#Lamount').val(data.amount_paid);
        $('#Lbank').val(data.bank);
        $('#Lteller').val(data.teller_number);
        $('#loanId').val(id);
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
            // if (willUpdate.isConfirmed == true) {
            if (willUpdate) {
                //performReset()
            //  alert('here')
                const postRequest = await request("/admin/memberloan_repayment/memberloanrepayment_store",
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

        $("#update_loan").on('submit', async function(e) {
            e.preventDefault();
            const serializedData = $("#update_loan").serializeArray();

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
            // if (willUpdate.isConfirmed == true) {
            if (willUpdate) {
                //performReset()
                const postRequest = await request("/admin/memberloan_repayment/update_memberloanrepayment",
                    processFormInputs(
                        serializedData), 'post');
                console.log('postRequest.message', postRequest.message);
                new swal("Good Job",postRequest.message , "success");
                $('#update_loan').trigger("reset");
                $("#update_loan .close").click();
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
                    // if (willUpdate.isConfirmed == true) {
                    if (willUpdate) {
                        //performReset()
                        $("#updateLoan").submit();
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
                text: `Are you sure you want to delete this Record?`,
                icon: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes!",
                showCancelButton: true,
                buttons: ["Cancel", "Yes, Delete"]
            });
            // console.log(willUpdate);
            // if (willUpdate.isConfirmed == true) {
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
                $.get('{{ route('deletememberloan_repayments') }}?id=' + user_id,
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
