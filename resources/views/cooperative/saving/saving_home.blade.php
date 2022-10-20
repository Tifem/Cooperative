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
                        <h4 class="mb-sm-0 font-size-18">Member Saving Payment</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/home">{{ Auth::user()->name }}</a></li>
                                <li class="breadcrumb-item active">Member Savings</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex">
                            <h4 class="card-title">Member Savings</h4>
                            <button type="button" class="btn btn-primary waves-effect waves-light ms-auto"
                                id="edit-employee" data-bs-toggle="modal" data-bs-target="#addModal">Add Payment</button>
                        </div>

                        <div class="card-body">
                            @include('includes.alert')
                            <table id="datatable-buttons" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Member Name</th>
                                        <th>Loan </th>
                                        <th>Bank</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $payment->memberRecord() }}</td>
                                            <td>{{ $payment->account() }}</td>
                                            <td>{{ $payment->bank() }}</td>
                                            <td style="text-align: right">{{ 'N' . number_format($payment->credit, 2) }}</td>
                                            <td>{{ $payment->date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- End Page-content -->
        </div>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
        <div class="modal-dialog vertical-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Set Payment</b></h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="card-body p-4">
                    <form method="POST" id="frm_main" onsubmit='disableButton()'>
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">Transaction Date</label>
                                <input type="date" name="date" class="form-control"
                                    placeholder="Please insert your Transaction Date" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Members</label>
                                <select class="form-control form-select member" name="member_id" required data-trigger
                                    id="choices-single-default ">
                                    <option selected disabled>Choose Member</option>
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}">{{ $member->MemberRecord() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Saving Account </label>
                                <select class="form-control form-select" name="account_id" required id="myLoans">
                                    <option selected disabled>Select Account</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Amount Paid</label>
                                <input type="text" name="amount" class="form-control" data-type="currency"
                                    placeholder="Please insert your Amount Paid" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bank</label>
                                {{-- <input type="text" name="bank" class="form-control"  placeholder="Please insert your Bank" required/> --}}
                                <select class="form-control form-select" name="bank" required data-trigger
                                    id="choices-single-default bank_lodge">
                                    <option selected disabled>Select Bank...</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->gl_name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <input type="hidden" name="is_repayment" value="1">
                            <div class="mb-3">
                                <label class="form-label">Teller Number</label>
                                <input type="text" name="teller_number" class="form-control"
                                    placeholder="Please insert your Teller Number" required />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary mr-2 submit-btn" name="save"
                                    id="btn">Save<span class="spinner-border loader1 spinner-border-sm" role="status"
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
@endsection
<!-- JAVASCRIPT -->
@section('scripts')
    <script src="{{ asset('js\requestController.js') }}"></script>
    <script src="{{ asset('js\formController.js') }}"></script>
    <script src="{{ asset('js/sweetalert/dist/sweetalert.min.js') }}"></script>
    @include('layouts.datatable')
    @include('includes.js')

    <!-- choices js -->
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <!-- datepicker js -->
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>

    <!-- init js -->
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(".member").on("change", function(e) {
                $("#myLoans").empty()
                var id = $(this).val(); // $(this).data('id');
                $.ajax({
                    url: '{{ route('get_member_savings') }}?id=' + id,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        var len = 0;
                        len = response['data'].length;

                        if (len > 0) {

                            for (var i = 0; i < len; i++) {
                                $("#myLoans").append(
                                    `<option value="${response['data'][i].id}">
                               ${!response['data'][i]?.glcode ? '' : response['data'][i]?.dscr?.description}  -   ${response['data'][i].amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}                  
                            </option>`
                                );
                            }
                        }
                    }
                });

            });

            $("input[data-type='currency']").on({
                keyup: function() {
                    formatCurrency($(this));
                },
                blur: function() {
                    formatCurrency($(this), "blur");
                }
            });


            function formatNumber(n) {
                // format number 1000000 to 1,234,567
                return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            }


            function formatCurrency(input, blur) {
                // appends $ to value, validates decimal side
                // and puts cursor back in right position.

                // get input value
                var input_val = input.val();

                // don't validate empty input
                if (input_val === "") {
                    return;
                }

                // original length
                var original_len = input_val.length;

                // initial caret position 
                var caret_pos = input.prop("selectionStart");

                // check for decimal
                if (input_val.indexOf(".") >= 0) {

                    // get position of first decimal
                    // this prevents multiple decimals from
                    // being entered
                    var decimal_pos = input_val.indexOf(".");

                    // split number by decimal point
                    var left_side = input_val.substring(0, decimal_pos);
                    var right_side = input_val.substring(decimal_pos);

                    // add commas to left side of number
                    left_side = formatNumber(left_side);

                    // validate right side
                    right_side = formatNumber(right_side);

                    // On blur make sure 2 numbers after decimal
                    if (blur === "blur") {
                        right_side += "00";
                    }

                    // Limit decimal to only 2 digits
                    right_side = right_side.substring(0, 2);

                    // join number by .
                    input_val = left_side + "." + right_side;

                } else {
                    // no decimal entered
                    // add commas to number
                    // remove all non-digits
                    input_val = formatNumber(input_val);
                    input_val = input_val;

                    // final formatting
                    if (blur === "blur") {
                        input_val += ".00";
                    }
                }

                // send updated string to input
                input.val(input_val);

                // put caret back in the right position
                var updated_len = input_val.length;
                caret_pos = updated_len - original_len + caret_pos;
                input[0].setSelectionRange(caret_pos, caret_pos);
            }


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
                    const postRequest = await request("/admin/member-saving-payment/transact",
                        processFormInputs(
                            serializedData), 'post');
                    console.log('postRequest.message', postRequest.message);
                    new swal("Good Job", postRequest.message, "success");
                    var loader = $(".loader1");
                    loader.hide();
                    $('#frm_main').trigger("reset");
                    $("#frm_main .close").click();
                    function disableButton() {
                        var btn = document.getElementById('btn');
                        btn.disabled = true;
                        // btn.innerText = 'Submitting...'
                    }
                    window.location.reload();


                } catch (e) {
                    if ('message' in e) {
                        console.log('e.message', e.message);
                        loader.hide();
                        new swal("Opss", e.message, "error");
                    }
                }
            })

        })
    </script>
@endsection
