@extends('layouts.app')

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
                <div class="card-header d-flex flex-wrap align-items-center mb-8">
                    <h4 class="card-title">My Accounts</h4>
                   
                </div>
                <div class="card-body">
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Category</th>
                                <th>Code</th>
                                <th>Gl Name</th>
                                <th>Direction</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($accounts as $account)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{empty($account->gl_code ?? 'Anonymous') ? '':$account->category->description }}</td>
                                    <td>
                                        {{-- @if(is_numeric($account->gl_code)) 
                                        {{empty($account->gl_code ?? 'Anonymous') ? '':$account->category->description }}
                                        @else --}}
                                        {{$account->code}}
                                        {{-- @endif --}}
                                    </td>
                                    <td>{{$account->gl_name}}</td>
                                    <td class="text-center">
                                        @if($account->direction == 1)
                                        <label class="badge bg-primary side-badge">Credit</label>
                                        @else
                                        <label class="badge bg-primary side-badge">Debit</label>
                                        @endif
                                    </td>
                                   
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

@endsection