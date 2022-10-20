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
                            <h4 class="mb-sm-0 font-size-18">Edit Roles</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="/home">{{Auth::user()->name}}</a></li>
                                    <li class="breadcrumb-item active">Roles</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom d-flex">
                                <h4 class="card-title">Edit Role</h4>
                            </div>
                            <div class="card-body">
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                {{-- {!! Form::model($role, ['method' => 'PATCH', 'route' => ['update_role', $role->id]]) !!} --}}

                                <form action="{{ route('update_role', [$role->id])}}" method="POST">
                                    @csrf
                                    
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Name:</strong>
                                            <input type="text" class="form-control" name="name" placeholder="Name" value="{{$role->name}}">
                                            {{-- {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!} --}}
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Permission:</strong>
                                            <br />

                                            <div class="row">

                                                @foreach ($permission as $value)
                                                <div class="col-md-3">
                                                    <label>
                                                        <input type="checkbox" name="permission[]" value="{{$value->id}}" {{in_array($value->id, $rolePermissions) ? "checked" : ''}} >

                                                        {{-- {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'name']) }} --}}
                                                        {{ $value->name }}</label>


                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                                </form>
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
    {{-- @include('layouts.datatable') --}}
    @endsection
