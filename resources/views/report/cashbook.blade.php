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
                <div class="col-md-2">
                
                </div>
                <div class="col-md-6 mt-2">
                    <label for="" class="text-center">Cash Account</label>
                    <select name="bank_lodge" class="form-control form-select bank_lodge" data-trigger id="choices-single-default" required>
                        <option value="">--Choose Account--</option>
                        @foreach($accounts as $account)
                        <option value="{{$account->id}}">{{$account->gl_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                
                </div>
            </div>
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
                    <button type="submit" class="btn btn-primary form-control mb-3" id="filter"><i class="bx bx-loader bx-spin font-size-16 align-middle me-2" style="display: none;" id="loader"></i>Search</button></button>
                </div>
            </div>
            <hr>
            <div class="card-body">
                <table id="" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <td>Transaction Date</td>
                            <th>Particular</th>
                            <th>Details</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="cashbook_details" >
                        
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
        }
        // alert(id)
        loader.show();

        try {
            const getApplications = await request("{{ route('searchAndFilter_journal') }}?id=" +  id +"&end_date=" + end_date +"&start_date=" + start_date);
            loader.hide();  
            console.log(getApplications);  
            var len = 0;
            len = getApplications['data'].length; 
              
            const tbodyEl = $('.cashbook_details');
            tbodyEl.empty()
            if (len == 0) {   
                tbodyEl.append(                          
                    `   <tr>
                            <td colspan="5" style="text-align:center"> NO RECORDS FOUND</td>
                        </tr>`
                );  
            }      
            getApplications.data.forEach((records) => {
                tbodyEl.append(                          
                    `<tr>
                        <td > ${records.transaction_date}</td>
                        <td > ${records.description}</td>
                        <td > ${records.particulars}</td>
                        <td style="text-align: right"> ${records.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td> 
                        <td style="text-align: center"> <a href="/accounts/lodge/receipt/${records.uuid}" class="btn-sm btn-primary">Print </a></td>                 
                    </tr>`
                );
            });
        } catch (e) {
            console.log(e.message)
        }

        console.log("fitler button pressed!!!!")
    });
    

   
})

</script>

@endsection