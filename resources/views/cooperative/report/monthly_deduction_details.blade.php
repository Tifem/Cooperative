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
                            <h4 class="mb-sm-0 font-size-18">Monthly Deduction Details</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="/home">{{Auth::user()->name}}</a></li>
                                    <li class="breadcrumb-item active">Monthly Deduction Details</li>
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
                                {{-- <form action="{{route('filter_pivot_table')}}" > --}}
                                    <div class="col-md-3">
                                        <label for="">Filter By Month</label>
                                        <select name="id" class="form-control form-select month" data-trigger id="choices-single-default bank_lodge" required>
                                            <option value="">Choose Month</option>
                                            @foreach($months as $key => $month)
                                                <option value="{{ $month }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <div class="col-md-2">
                                        <label for=""  style="" class=""></label>
                                        <button type="submit" class="btn btn-primary form-control mt-2" id="filter"><i class="bx bx-loader bx-spin font-size-16 align-middle me-2" style="display: none;" id="loader"></i>Search</button></button>
                                    </div>
                                {{-- </form> --}}
                            </div>
                            <hr>

                            <div class="card-body">
                                {{-- @include('includes.alert') --}}
                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Member</th>
                                            @foreach ($loans as $loan)
                                                <th>{{$loan->description}}</th>
                                            @endforeach
                                            <th>Amount</th>
                                            <th>Month</th>
                                        </tr>
                                    </thead>

                                    <tbody class="deduction_details">
                                        @foreach($deductions as $deduction)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{ $deduction->MemberRecord() }}</td>
                                            @foreach ($loans as $loan)
                                            <td style="text-align: right">{{ number_format($loan->deductionAmount($deduction->month, $deduction->member_id), 2) }}</td>
                                            @endforeach
                                            <td style="text-align: right">{{ number_format($deduction->totalAmount($deduction->month), 2) }}</td>
                                            <td>{{ $deduction->month }}</td>
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
         
    
            var loader = $("#loader")
            /* When click edit user */
            $('#filter').on('click', async function(e) {
                e.preventDefault();
                
                var id = $('.month option:selected').val();
                if (id == "" ) {
                    event.preventDefault();
                    swal("Kindly choose month !");
                }else{
                
                loader.show();
                
                window.location.href = "filter-monthly-deduction-by-month?id=" +  id 
            }
            });
            
      
           
        })
      
      </script>


@endsection
