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
                        <h4 class="mb-sm-0 font-size-18">Monthly Deductions</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="/home">{{ Auth::user()->name }}</a></li>
                                <li class="breadcrumb-item active">Monthly Deductions</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="row mt-4">
                            <div class="col-md-2">

                            </div>
                            <div class="col-md-3">
                                <label for="">Month</label>
                                {{--  <select name="id" class="form-control form-select month" id="selectNow" required>  --}}
                                <select name="id" class="form-control form-select month" data-trigger id="selectNow"
                                    required>
                                    <option value="">Choose Month</option>
                                    @foreach ($months as $key => $month)
                                        <option value="{{ $month }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="" style="" class=""></label>
                                <button type="submit" class="btn btn-primary form-control mt-2" id="filter"
                                    onclick="remove()">
                                    <i class="bx bx-loader bx-spin font-size-16 align-middle me-2" style="display: none;"
                                        id="loader"></i>Deduct</button>
                            </div>
                            {{--  onClick="this.disabled=true"   --}}
                        </div>
                        <hr>

                        <div class="card-body">
                            {{-- @include('includes.alert') --}}
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Member ID</th>
                                        <th>Member Name</th>
                                        <th>GL Name</th>
                                        <th>Amount</th>
                                        <th>Month</th>
                                    </tr>
                                </thead>

                                <tbody class="deduction_details">
                                    @foreach ($loans as $loan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $loan->member_id }}</td>
                                            <td>{{ $loan->MemberRecord() }}</td>
                                            <td>{{ $loan->glCode() }}</td>
                                            <td style="text-align: right">{{ number_format($loan->amount, 2) }}</td>
                                            <td>{{ $loan->month }}</td>
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
        <!-- end main content-->
    </div>
@endsection
<!-- JAVASCRIPT -->
@section('scripts')
    <!-- choices js -->
    <script src="{{ asset('assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <!-- datepicker js -->
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <!-- init js -->
    <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>

    <script src="{{ asset('js\requestController.js') }}"></script>
    <script src="{{ asset('js\formController.js') }}"></script>
    <script src="{{ asset('js/sweetalert/dist/sweetalert.min.js') }}"></script>
    @include('layouts.datatable')
    {{-- @include('includes.js') --}}

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var loader = $("#loader")
            /* When click edit user */
            $('#filter').on('click', async function(e) {
                e.preventDefault();

                var id = $('.month option:selected').val();
                if (id == "") {
                    event.preventDefault();
                    swal("Kindly choose month !");
                } else {

                    loader.show();
                    $(".table").DataTable().clear().destroy();
                    try {
                        const getApplications = await request(
                            "{{ route('monthly_deduction_transaction') }}?id=" + id);
                        loader.hide();
                        console.log(getApplications);
                        var len = 0;
                        len = getApplications['data'].length;
                        const tbodyEl = $('.deduction_details');
                        tbodyEl.empty()
                        if (len == 0) {
                            $('.table').DataTable({
                                // "order": [[ 6, "desc" ]],
                                pageLength: 50,
                                scrollY: 500,
                                scrollCollapse: true,
                                paginate: true

                            });
                            // $('#fileValidate').hide();
                        }

                        getApplications.data.forEach((records, index) => {
                            tbodyEl.append(
                                `<tr>
                                <td > ${index+1}</td>
                                <td > ${records.member_id}</td>
                                <td>${!records?.member_id ? '' : records?.member?.lastname} ${!records?.member_id ? '' :  records?.member?.firstname}</td>
                                <td>${!records?.glcode ? '' : records?.code?.description}</td>
                                <td style="text-align: right"> ${records.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                                <td > ${records.month}</td>
                            </tr>`
                            );
                            // $(".table").DataTable().clear().destroy();

                        });
                        if ($.fn.dataTable.isDataTable('.table')) {
                            table = $('.table').DataTable();
                        } else {
                            table = $('.table').DataTable({
                                // paging: false
                            });
                        }
                        swal("Deduction Transaction Succesful !");
                        var x = document.getElementById("selectNow");
                        x.remove(x.selectedIndex);
                        window.location.reload();
                    } catch (e) {
                        loader.hide();
                        swal("Opss", e.message, "error");
                    }
                    window.location.reload();
                    console.log("fitler button pressed!!!!")
                }
            });

        })
    </script>


    {{--  <script>
        $(document).ready(function() {

            $("form").on('submit', async function(e) {
                var loader = $(".loader2");
                //alert('here');
                loader.show();
            })

        });
    </script>  --}}
@endsection
