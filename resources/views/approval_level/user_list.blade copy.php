@extends('layouts.master')


@section('headlinks')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">


@endsection

@section('content')


    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Users</h4>

                        <div class="page-title-right">
                            <a type="button" class="btn btn-info btn-sm" href="javascript:history.back()">Go
                                Back</a>


                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <!--end card-header-->
                        <div class="card-body">
                            <div class='col-md-4'>
                                <form action="/admin/users/search" method="POST" role="search">
                                    {{ csrf_field() }}
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="q"
                                            placeholder="Search across the database" required>
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default btn-primary mr-1">
                                                search
                                            </button>
                                        </span>
                                        <a href="/admin/users" class="btn btn-info">Show all</a>
                                    </div>
                                </form>
                            </div><br>

                            <div class="card-body">
                                {{-- @include("includes.alert.alert") --}}

                                <table id="datatable-buttons"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 70px;">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Role</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ ++$i }}</td>
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
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


    @endsection

    @section('scripts')

    @include("includes.datatable")
    @endsection
