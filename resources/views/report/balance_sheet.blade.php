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
           
            {{-- <form  onsubmit="signUp(event)" method="post" id="frm_main">
                @csrf --}}
                <div class="row mt-3">
                    <div class="col-md-3">
                    
                    </div>
                    <div class="col-md-6">
                        <label for="">Cash Account</label>
                        <select name="bank_lodge" class="form-control form-select" data-trigger id="choices-single-default" required>
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
                    <div class="col-md-3">
                    
                    </div>
                    <div class="col-md-3">
                        <label for="">Start Date</label>
                        <input type="date" class="form-control mb-3">
                    </div>
                    <div class="col-md-3">
                        <label for="">End Date</label>
                        <input type="date" class="form-control mb-3">
                    </div>
                    <div class="col-md-3">
                    
                    </div>
                </div>
                <hr>
            {{-- </form> --}}
            <div class="card-body">
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <td></td>
                            <th>Transaction Date</th>
                            <th>Particulars</th>
                            <th>Description</th>
                            <th>Receipt Number</th>
                            <th>Amount</th>
                            <th>Teller Number</th>
                            <th>Received By</th>
                        </tr>
                    </thead>
                </table>
            </div>
            </form>
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
  
            var id = $('#search_inputvalue').val();
            //alert(id)
            loader.show();
  
      
            try {
                const getApplications = await request("{{ route('searchAndFilter_cashbook') }}?id=" +    id );
                loader.hide();
  
                console.log(getApplications);
                
                const tbodyEl = $('#cashbook_details');
                tbodyEl.empty()
                getApplications.data.forEach((records) => {
                    tbodyEl.append(                          
                        `<tr>
                            <td > ${records.Postdate}</td>
                            <td > ${records.Valdate}</td>
                            <td > ${records.Details}</td>
                            <td > ${records.CrDr === "1" ? records.Amount:0}</td>
                            <td > ${records.CrDr === "2" ? 0:records.Amount }</td>
                         
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