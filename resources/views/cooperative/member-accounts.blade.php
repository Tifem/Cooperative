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
                            <h4 class="mb-sm-0 font-size-18">Member Account Deductions</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="/home">{{Auth::user()->name}}</a></li>
                                    <li class="breadcrumb-item active">Account Deductions</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                                <div class="row mt-4" style="margin-left: 75px;">
                                    {{-- <div class="col-md-1">
                                    </div>  --}}
                                    <div class="col-md-4">
                                        <label for="">Members</label>
                                        <select name="month" class="form-control form-select member" data-trigger id="choices-single-default " required>
                                            <option value="">Choose Member</option>
                                            @foreach($members as $key => $member)
                                                <option value="{{ $member->id }}">{{ $member->MemberRecord() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Account</label>
                                        <select name="account_id" class="form-control form-select account" id="accounts" required>
                                            <option value="">Choose Account</option>
                                           
                                        </select>
                                    </div>
                                
                                    <div class="col-md-2">
                                        <label for=""  style="" class=""></label>
                                        <button type="submit" class="btn btn-primary form-control mt-2" id="filter"><i class="bx bx-loader bx-spin font-size-16 align-middle me-2" style="display: none;" id="loader"></i>Search</button></button>
                                    </div>
                                </div>
                            <hr>

                            <div class="card-body">
                                {{-- @include('includes.alert') --}}
                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Description</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                        </tr>
                                    </thead>

                                    <tbody class="deduction_details">
                                       
                                    </tbody>
                                </table>
                            </div>

                            <hr>

                            <div class="row" id="totalDiv" style="padding-right: 10px;margin-bottom: 15px;display: none" >
                                {{-- <div class="col-md-1">
                                </div>  --}}
                                <div class="col-md-4">
                                    
                                </div>
                                <div class="col-md-5">
                                   
                                </div>
                            
                                <div class="col-md-3">
                                    <label for="">Total</label>
                                    <input type="text" style="text-align: right" class="form-control text-right" id="sumTotal" >
                                </div>
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
    <script src="{{asset('assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
    <!-- datepicker js -->
    <script src="{{asset('assets/libs/flatpickr/flatpickr.min.js')}}"></script>
    <!-- init js -->
    <script src="{{asset('assets/js/pages/form-advanced.init.js')}}"></script>
    
    <script src="{{ asset('js\requestController.js')}}"></script>
    <script src="{{ asset('js\formController.js')}}"></script>
    
    <script src="{{ asset('js/sweetalert/dist/sweetalert.min.js')}}"></script>
    @include('layouts.datatable')
    {{-- @include('includes.js') --}}

    <script>

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
         
    
            $(".member").on("change", function(e) {
                $("#accounts").empty()
                var id = $(this).val(); // $(this).data('id');
                // alert(id)
                $.ajax({
                    url: '{{ route('get_member_accounts') }}?id=' + id,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        var len = 0;
                        len = response['data'].length;

                        if (len > 0) {

                            for (var i = 0; i < len; i++) {
                                $("#accounts").append(                          
                                `<option value="${response['data'][i].id}">
                                    ${response['data'][i].description} 
                                </option>`
                            );
                            }
                        }
                    }
                });
            });

            var loader = $("#loader")
            $('#filter').on('click', async function(e) {
                e.preventDefault();
                
                var id = $('.member option:selected').val();
                var account = $('.account option:selected').val();
                if (account == "" ) {
                    swal("Kindly choose account !");
                }
                if (id == "" ) {
                    event.preventDefault();
                    swal("Kindly choose member !");
                }else{
                
                loader.show();
                $(".table").DataTable().clear().destroy();
                try {
                    const getApplications = await request("{{ route('member_account_deduction') }}?id=" +  id +"&account=" + account );
                    loader.hide();  
                    console.log(getApplications);  
                    var len = 0;
                    len = getApplications['data'][0].length;              
                    const tbodyEl = $('.deduction_details');
                    tbodyEl.empty()
                    if (len == 0) {  
                        $('.table').DataTable( {
                            // "order": [[ 6, "desc" ]],
                            pageLength: 50,
                            scrollY: 500,
                            scrollCollapse: true,
                            paginate: true
    
                        } );
                        $('#totalDiv').hide(); 
                    }
                    
                    getApplications.data[0].forEach((records , index) => {
                        tbodyEl.append(                          
                            `<tr>
                                <td > ${index+1}</td>  
                                <td > ${records.description}</td>
                                <td style="text-align: right"> ${records.debit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                                <td style="text-align: right"> ${records.credit.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>                         
                            </tr>`
                        );
                        // $(".table").DataTable().clear().destroy();
                       
                    });
                    $('#totalDiv').show();
                    $('#sumTotal').val(getApplications['data'][1].toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","));

                    if ( $.fn.dataTable.isDataTable( '.table' ) ) {
                        table = $('.table').DataTable();
                    }
                    else {
                        table = $('.table').DataTable( {
                            // paging: false
                        } );
                    }
                    swal("Transaction Succesful !");
                } catch (e) {
                    console.log(e.message)
                }
      
                console.log("fitler button pressed!!!!")
            }
            });
           
        })
      
      </script>


@endsection
