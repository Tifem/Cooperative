@extends('layouts.master')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <!--app-content open-->
        <div class="side-app">
            <!-- CONTAINER -->
            <div class="main-container container-fluid">

                <!-- PAGE-HEADER -->
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Role</h1>
                    </div>
                    <div class="ms-auto pageheader-btn">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">User</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Management</li>
                        </ol>
                    </div>
                </div>
                <!-- PAGE-HEADER END -->

                <!-- Row -->
                <div class="row row-sm">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header border-bottom d-flex">
                                <h3 class="card-title">User List</h3>
                                <a class=" btn btn-primary d-grid ms-auto" href="javascript:history.back()">Go back</a>
                            </div>

                            <div class="card-body">
                                @include('includes.alert')
                                <div class="table-responsive">
                                    <table class="table table-bordered text-nowrap nowrap key-buttons border-bottom  w-100" id="file-datatable">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">SN</th>
                                                <th class="wd-15p border-bottom-0">Name</th>
                                                <th class="wd-20p border-bottom-0">Email</th>
                                                <th class="wd-15p border-bottom-0">Phone Number</th>
                                                <th class="wd-10p border-bottom-0">Role</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone_no }}</td>
                                                    <td>
                                                        @if (!empty($user->getRoleNames()))
                                                            @foreach ($user->getRoleNames() as $v)
                                                                <label class="">{{ $v }}</label>
                                                            @endforeach
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>



@endsection

@section('scripts')
@include('includes.datatable')
 <script src="{{ asset('js\requestController.js') }}"></script>
<script src="{{ asset('js\formController.js') }}"></script>

@endsection
