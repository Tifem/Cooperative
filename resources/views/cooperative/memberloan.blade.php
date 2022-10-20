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
                        <h4 class="mb-sm-0 font-size-18">Member Loans</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/home">{{ Auth::user()->name }}</a></li>
                                <li class="breadcrumb-item active">Member Loans</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex">
                            <h4 class="card-title"> Loans</h4>
                            <button type="button" class="btn btn-primary waves-effect waves-light ms-auto"
                                id="edit-employee" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl"><i
                                    class="fa fa-plus"></i> Create Member Loan</button>
                        </div>

                        <div class="card-body">
                            @include('includes.alert')
                            <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Member Name</th>
                                        <th>Loan Name</th>
                                        <th>Principal Amount</th>
                                        <th>Interest Amount</th>
                                        <th>Total Loan</th>
                                        <th>Monthly Deduction</th>
                                        <th>Total Repayment</th>
                                        <th>Balance</th>
                                        <th>Duration</th>
                                        <th>Loan Interest</th>
                                        <th>Bank</th>
                                        <th>Reciept Number</th>
                                        {{--  <th>Status</th>  --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($loans as $loan)
                                        <tr>
                                            {{-- <td>{{ ++$i }}</td> --}}
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $loan->MemberRecord() }}</td>
                                            <td>{{ $loan->ln->description ?? $loan->loan_name }}</td>
                                            <td style="text-align: right">{{ number_format($loan->principal_amount, 2) }}
                                            </td>
                                            <td style="text-align: right">{{ number_format($loan->interest_amount, 2) }}
                                            </td>
                                            <td style="text-align: right">{{ number_format($loan->total_repayment, 2) }}
                                            </td>
                                            <td style="text-align: right">{{ number_format($loan->monthly_deduction, 2) }}
                                            </td>
                                            <td style="text-align: right">{{ number_format($loan->repayment(), 2) }}</td>
                                            <td style="text-align: right">{{ number_format($loan->balance, 2) }}</td>
                                            <td>{{ $loan->duration . 'months' }}</td>
                                            <td>{{ $loan->loan_interest . '%' }}</td>
                                            <td>{{ $loan->bankName->gl_name ?? $loan->bank }}</td>
                                            <td>{{ $loan->reciept_number }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <div class="edit">
                                                        <button class="btn btn-sm btn-primary edit-item-btn"
                                                            data-bs-toggle="modal" id="edit-loan"
                                                            data-id="{{ $loan->id }}" data-bs-target="#editModal"><i
                                                                class="fa fa-edit"></i></button>
                                                    </div>
                                                    <div class="remove">
                                                        <button data-id="{{ $loan->id }}" class="btn btn-sm btn-danger"
                                                            id="deleteRecord"> <i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            </td>
                                            {{--  <td>
                                                <div class="d-flex gap-2">
                                                    @if ($loan->status == 0)
                                                        <label class="badge badge-primary">Ongoing</button>
                                                            {{--  @if ($loan->staus == Auth::user()->role)  --}}
                                                            {{--  @if ($loan->status == 2)
                                                                <label class="badge badge-danger">Pending</button>
                                                                @else
                                                                    <label class="badge badge-info">Paid</button>
                                                            @endif
                                                    @endif
                                                </div>
                                            </td>  --}} 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
                aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myExtraLargeModalLabel">Create Member Loan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="frm_main" onsubmit='disableButton()'>
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="">Member</label>
                                            <select name="member_name" class="form-control " data-trigger
                                                id="choices-single-default">
                                                <option value="">Choose Member ...</option>
                                                @foreach ($members as $member)
                                                    <option value="{{ $member->id }}">{{ $member->MemberRecord() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Principal Amount</label>
                                            <input type="text" name="principal_amount"
                                                class="form-control principalAmount" style="text-align: right"
                                                placeholder="Please insert your Principal Amount" required />
                                        </div>


                                        <div class="mb-3">
                                            <label class="form-label">Total Repayment</label>
                                            <input type="text" name="total_repayment" class="form-control totalRepayment"
                                                placeholder="Total Repayment" style="text-align: right" required readonly />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Monthly Deduction</label>
                                            <input type="text" name="monthly_deduction"
                                                class="form-control monthlyDeduction" placeholder="Monthly Deduction"
                                                style="text-align: right" required readonly />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Cheque Number</label>
                                            <input type="text" name="reciept_number" class="form-control"
                                                placeholder="Reciept Number" required />
                                        </div>

                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mt-3 mt-lg-0">
                                            <div class="mb-3">
                                                <label for="choices-single-groups"
                                                    class="form-label font-size-13 text-muted">Loan Name</label>
                                                <select class="form-control loanType" data-trigger name="loan_name"
                                                    id="choices-single-groups">
                                                    <option value="" selected disabled>Choose Loan type...</option>
                                                    @foreach ($lnames as $lname)
                                                        <option value="{{ $lname->id }}">{{ $lname->description }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Loan Interest</label>
                                                <input type="text" name="loan_interest" class="form-control"
                                                    style="text-align: right" id="loanInterest"
                                                    placeholder="Loan Interest" required readonly />
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Interest</label>
                                                <input type="text" name="interest_amount" style="text-align: right"
                                                    class="form-control interestOnPrincipal" placeholder="Interest"
                                                    required readonly />
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Duration</label>
                                                <input type="number" name="duration" class="form-control period"
                                                    placeholder="Please insert your Monthly Duration" required />
                                            </div>

                                            <div class="mb-3">
                                                <label for="">Bank Account</label>
                                                <select name="bank" class="form-control form-select" data-trigger
                                                    id="choices-single-default">
                                                    <option value="" selected disabled>Choose Banks...</option>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}">{{ $account->gl_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary mr-2" name="save"
                                            id='btn'>Save<span
                                                class="spinner-border loader1 spinner-border-sm submit-btn" role="status"
                                                aria-hidden="true" style="display:none"></span></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <!-- End Page-content -->
        </div>

        <div class="modal fade bs-example-modal-xl" id="editModal" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myExtraLargeModalLabel">Edit Member Loan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('updatememberloans') }}" id="updateLoan">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="id" id="loanId">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="">Member</label>
                                        <select name="member_name" class="form-control form-select" id="LMember"
                                            data-trigger id="choices-single-default">
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}">{{ $member->MemberRecord() }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Principal Amount</label>
                                        <input type="text" name="principal_amount" id="Lprincipal"
                                            class="form-control principalAmount"
                                            placeholder="Please insert your Principal Amount" required />
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label">Total Repayment</label>
                                        <input type="text" name="total_repayment" id="Lrepayment"
                                            class="form-control totalRepayment" placeholder="Total Repayment" required
                                            readonly />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Monthly Deduction</label>
                                        <input type="text" name="monthly_deduction" id="Ldeduction"
                                            class="form-control monthlyDeduction" placeholder="Monthly Deduction" required
                                            readonly />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Reciept Number</label>
                                        <input type="text" name="reciept_number" id="LReciept" class="form-control"
                                            id="loanInterest" placeholder="" required />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mt-3 mt-lg-0">
                                        <div class="mb-3">
                                            <label for="choices-single-groups"
                                                class="form-label font-size-13 text-muted">Loan Name</label>
                                            <select class="form-control loanType" id="LName" name="loan_name"
                                                id="choices-single-groups">
                                                <option value="" selected disabled>Choose Loan type...</option>
                                                @foreach ($lnames as $lname)
                                                    <option value="{{ $lname->id }}">{{ $lname->description }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Interest</label>
                                            <input type="text" name="interest_amount" id="Linterest"
                                                class="form-control interestOnPrincipal" placeholder="Interest" required
                                                readonly />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Duration</label>
                                            <input type="number" name="duration" id="Lduration"
                                                class="form-control period"
                                                placeholder="Please insert your Monthly Duration" required />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Loan Interest</label>
                                            <input type="text" name="loan_interest" id="LLoan"
                                                class="form-control" id="loanInterest" required readonly />
                                        </div>

                                        <div class="mb-3">
                                            <label for="">Banks</label>
                                            <select name="bank" id="LBank" class="form-control form-select"
                                                id="choices-single-default">
                                                <option selected disabled>Choose Banks...</option>
                                                @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}">{{ $account->gl_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary mr-2 submit-btn" name="save"
                                        id="update-btn">Save Change
                                        <span class="spinner-border loader1 spinner-border-sm" role="status"
                                            aria-hidden="true" style="display:none"></span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div>
@endsection
<!-- JAVASCRIPT -->
@section('scripts')
    <script src="{{ asset('js\requestController.js') }}"></script>
    <script src="{{ asset('js\formController.js') }}"></script>
    <script src="{{ asset('js/sweetalert/dist/sweetalert.min.js') }}"></script>
    @include('layouts.datatable')
    {{--  @include('includes.js')  --}}

    <!-- choices js -->
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <!-- datepicker js -->
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>

    <!-- init js -->
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(".loanType").on("change", function(e) {
                // alert("here");
                var id = $(this).val(); // $(this).data('id');
                // alert(id);
                if (id == "") {
                    $("#loanInterest").val("")
                } else {
                    $.get("{{ route('get_loan_by_id') }}?id=" + id, function(data) {
                        $('#loanInterest').val(data.interest);
                        calculateInterest();
                        calculateMonthlyDeduction();
                        console.log(data)
                    })
                }

            });
            $(".principalAmount").on("keyup", function(e) {
                calculateInterest();
                calculateMonthlyDeduction()
            });

            function calculateInterest() {
                var contractAmount = Number($('.principalAmount').val());
                var loanInterest = Number($('#loanInterest').val());
                var interestOnPrincipal = parseFloat(contractAmount) * loanInterest / 100;
                var totalRepayment = contractAmount + interestOnPrincipal;
                $('.interestOnPrincipal').val(interestOnPrincipal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                $('.totalRepayment').val(totalRepayment.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }

            $(".period").on("keyup", function(e) {
                calculateMonthlyDeduction();
            });

            function calculateMonthlyDeduction() {
                var firstDuration = $('.period').val();
                if (firstDuration != "") {
                    var duration = Number($('.period').val());
                    var total = $('.totalRepayment').val().replace(/,/g, '');
                    var monthlydeduction = total / duration;
                    if (!isNaN(monthlydeduction)) {
                        $('.monthlyDeduction').val(monthlydeduction.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g,
                            ","));
                    }
                } else {
                    $('.monthlyDeduction').val("");
                }
                // alert(monthlydeduction)

            }

            $('body').on('click', '#edit-loan', function() {
                // alert("Nathaniel")
                var id = $(this).data('id');
                $.get("{{ route('getmemberloanInfos') }}?id=" + id, function(data) {
                    // alert('hhgf');

                    $('#LMember').val(data.member_name);
                    $('#LName').val(data.loan_name);
                    $('#Lprincipal').val(data.principal_amount);
                    $('#Linterest').val(data.interest_amount);
                    $('#Lrepayment').val(data.total_repayment);
                    $('#Lduration').val(data.duration);
                    $('#Ldeduction').val(data.monthly_deduction);
                    $('#LLoan').val(data.loan_interest);
                    $('#LBank').val(data.bank);
                    $('#LReciept').val(data.reciept_number);
                    $('#loanId').val(id);
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
                        const postRequest = await request("/admin/memberloan/memberloan_store",
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

            $("#update_loan").on('submit', async function(e) {
                e.preventDefault();
                const serializedData = $("#update_loan").serializeArray();

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
                        // if (willUpdate) {
                        //performReset()
                        const postRequest = await request("/admin/memberloan/update_memberloan",
                            processFormInputs(
                                serializedData), 'post');
                        console.log('postRequest.message', postRequest.message);
                        new swal("Good Job", postRequest.message, "success");
                        var loader = $(".loader1");
                        loader.hide();
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
                    //var loader = $(".loader1");
                    //loader.hide();
                    // console.log(willUpdate);

                    // if (willUpdate.isConfirmed == true) {
                    if (willUpdate) {
                        // if (willUpdate) {
                        //performReset()
                        $("#updateLoan").submit();
                    } else {
                        new swal("Loan will not be updated  :)");
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
                    text: `Are you sure you want to delete this Loan?`,
                    icon: "warning",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes!",
                    showCancelButton: true,
                    buttons: ["Cancel", "Yes, Delete"]
                });
                //var loader = $(".loader1");
                //loader.hide();
                // console.log(willUpdate);
                //if (willUpdate.isConfirmed == true) {
                if (willUpdate) {
                    // if (willUpdate) {
                    //performReset()
                    performDelete(el, user_id);
                } else {
                    new swal("Record will not be deleted  :)");
                }
            }

            function performDelete(el, user_id) {
                //alert(user_id);
                try {
                    $.get("{{ route('deletememberloans') }}?id=" + user_id,
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
        function disableButton() {
            var btn = document.getElementById('btn');
            btn.disabled = true;
            // btn.innerText = 'Submitting...'
        }
    </script>
@endsection
