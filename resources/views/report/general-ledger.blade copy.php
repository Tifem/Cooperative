@extends('layouts.master')

@section('headlinks')
<!-- DataTables -->
<link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row">
                <div class="col-md-4 mb-4">

                </div>
                <div class="col-md-6">
                    <label for="">Cash Account</label>
                    <select name="bank_lodge" class="form-control form-select bank_lodge" data-trigger id="choices-single-default bank_lodge" required>
                        <option value="">--Choose Account--</option>
                        @foreach($accounts as $account)
                        <option value="{{$account->id}}">{{$account->gl_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">

                </div>
                <br/>
                <div class="row">
                    <div class="col-md-2">

                    </div>

                <div class="col-md-3">
                    <label for="">Start Date</label>
                    <input type="date" class="form-control mb-3" id="start_date" >
                </div>
                <div class="col-md-3">
                    <label for="">End Date</label>
                    <input type="date" class="form-control mb-3" id="end_date">
                </div>
                <div class="col-md-2">
                    <label for=""  style="" class=""></label>
                    <button type="submit" class="btn btn-primary form-control mt-2" id="filter"><i class="bx bx-loader bx-spin font-size-16 align-middle me-2" style="display: none;" id="loader"></i>Search</button></button>
                </div>
            </div>
            <hr>
            <div class="card-body">
                <table id="" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Transaction Date</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Code</th>
                        </tr>
                    </thead>
                    <tbody class="journal" >
                        @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$transaction->created_at}}</td>
                            <td>{{ $transaction->debit}}</td>
                            <td>{{ $transaction->credit}}</td>
                            <td>{{ $transaction->gl_code}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <!-- end cardaa -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

@endsection

@section('scripts')
<!-- choices js -->
<script src="{{asset('assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
<!-- color picker js -->
{{-- <script src="{{asset('assets/libs/%40simonwep/pickr/pickr.min.js')}}"></script>
<script src="{{asset('assets/libs/%40simonwep/pickr/pickr.es5.min.js')}}"></script> --}}

<!-- datepicker js -->
<script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>

<!-- init js -->
<script src="{{asset('assets/js/pages/form-advanced.init.js')}}"></script>

<!-- Required datatable js -->
<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/libs/jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>

<!-- Responsive examples -->
<script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

<!-- Datatable init js -->
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
<script src="{{ asset('js\requestController.js') }}"></script>
<script src="{{ asset('js\formController.js') }}"></script>

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

            var id = $('.bank_lodge option:selected').val();
            var end_date = $('#end_date').val();
            var start_date = $('#start_date').val();
            if (id == "" ) {
                event.preventDefault();
                swal("Kindly choose account !");
            }else{
                $(".table").DataTable().clear().destroy();
                // alert(id)
                loader.show();
            // alert(id)
            loader.show();

            try {
                const getApplications = await request("{{ route('searchAndFilter_cashbook') }}?id=" +    id +"&end_date=" + end_date +"&start_date=" + start_date);
                loader.hide();
                console.log(getApplications);
                var len = 0;
                len = getApplications['data'].length;
                const tbodyEl = $('.cashbook_details');
                tbodyEl.empty()
                if (len == 0) {
                    $('.table').DataTable( {
                        // "order": [[ 6, "desc" ]],
                        pageLength: 50,
                        scrollY: 500,
                        scrollCollapse: true,
                        paginate: true

                    } );
                }
                getApplications.data.forEach((records) => {
                    const val = records.id
                        const index = getApplications.data.findIndex((item) => {
                            return item.id === val
                        });
                    tbodyEl.append(
                        `<tr>
                            <td > ${records.created_at}</td>
                            <td > ${records.particulars}</td>
                            <td style="text-align: right"> ${records.debit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                            <td style="text-align: right"> ${records.credit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                            <td > ${records.gl_code }</td>

                        </tr>`
                    );
                    $('.table').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                'copy', 'csv', 'excel', 'pdf', 'print'
                            ]
                            // pageLength: 50,
                            // scrollY: 500,
                            // scrollCollapse: true,
                            // paginate: true

                        } );
                });
            } catch (e) {
                console.log(e.message)
            }
            console.log("fitler button pressed!!!!")
            }
        });


    })

  </script>

@endsection
