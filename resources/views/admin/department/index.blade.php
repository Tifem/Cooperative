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
                    <h1 class="page-title">Departments</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Management Department</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE-HEADER END -->

            <!-- Row -->
            <div class="row row-sm">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex">
                            <h3 class="card-title">Departments</h3>
                            <a class="modal-effect btn btn-primary d-grid ms-auto" data-bs-effect="effect-super-scaled"
                                data-bs-toggle="modal" href="#modaldemo8">Add New Department</a>
                        </div>

                        <div class="card-body">
                            @include('includes.alert')
                            <div class="table-responsive">
                                <table class="table table-bordered text-nowrap nowrap key-buttons border-bottom  w-100"
                                    id="file-datatable">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">SN</th>
                                            <th class="wd-15p border-bottom-0">Name</th>

                                            <th class="wd-25p border-bottom-0">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($departments as $department)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $department->name }}</td>

                                                <td>
                                                    <button class="btn btn-sm btn-primary edit-item-btn"
                                                        data-bs-toggle="modal" id="edit-user"
                                                        data-id="{{ $department->id }}" data-bs-target="#editModal"><i
                                                            class="fe fe-edit"></i>edit</button>
                                                    <button class="btn btn-danger" id="deleteRecord"
                                                        data-id="{{ $department->id }}"><i class="fe fe-trash"></i> <span
                                                            class="spinner-border deleteloader spinner-border-sm"
                                                            role="status" aria-hidden="true"
                                                            style="display:none"></span>delete</button>
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
            <div class="modal fade" id="modaldemo8">
                <div class="modal-dialog vertical-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title">Add New Department</h6><button type="button" aria-label="Close"
                                class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form action="{{ route('store_department') }}" method="POST">
                            @csrf
                            <div class="modal-content modal-content-demo">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Enter Name" type="text" name="name">
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit">

                                            <span class="me-2">Submit</span>

                                            <span class="spinner-border loader2 spinner-border-sm" role="status"
                                                aria-hidden="true" style="display:none"></span>
                                        </button>
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Row -->
            </div>
        </div>
    </div>

    <!-- CONTAINER CLOSED -->


    <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
        <div class="modal-dialog vertical-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Edit User</b></h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('update_admin_users') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" id="departmentname" name="name"
                                required />
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="save" id="edit-btn">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('includes.datatable')
    <script src="{{ asset('js\requestController.js') }}"></script>
    <script src="{{ asset('js\formController.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });





            $("#updateusr").on('submit', async function(e) {
                var loader = $("#loader2");
                loader.show();
            })







            /* When click delete button */
            $('body').on('click', '#deleteRecord', function() {
                var user_id = $(this).data('id');
                // alert(user_id)
                var token = $("meta[name='csrf-token']").attr("content");
                var el = this;
                // alert(user_id);
                $(this).closest(".deleteloader").show();
                // alert('here')
                resetAccount(el, user_id);
            });


            async function resetAccount(el, user_id) {
                const willUpdate = await new swal({
                    title: "Confirm Department Delete",
                    text: `Are you sure you want to delete this record?`,
                    icon: "warning",
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes!",
                    showCancelButton: true,
                    buttons: ["Cancel", "Yes, Delete"]
                });

                // console.log(willUpdate.isConfirmed)
                if (willUpdate.isConfirmed == true) {
                    // console.log(willUpdate);
                    //performReset()
                    performDelete(el, user_id);
                } else {
                    // alert("hwre")
                    new swal("Record will not be deleted  :)");
                }
            }


            function performDelete(el, user_id) {
                //alert(user_id);
                // $(el).closest(".deleteloader").show();

                try {
                    $.get('{{ route('delete_department') }}?id=' + user_id,
                        function(data, status) {
                            console.log(status);
                            console.table(data);
                            if (status === "success") {
                                let alert = new swal("Department successfully deleted!.");

                                $(el).closest("tr").remove();
                                // alert.then(() => {
                                // });
                            }
                        }
                    );
                } catch (e) {
                    let alert = new swal(e.message);

                }
            }


        })
    </script>
    <script>
        $(document).ready(function() {
            $('body').on('click', '#edit-user', function() {
                // alert("Nathaniel")
                var id = $(this).data('id');
                $.get('{{ route('edit_department') }}?id=' + id, function(data) {
                    // alert('hhgf');

                    // console.log(data)
                    $('#departmentname').val(data.name);
                    $('#id').val(data.id);

                });
            });
        });
    </script>
@endsection
