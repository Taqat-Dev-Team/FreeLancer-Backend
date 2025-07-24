@extends('admin.layouts.master', ['title' => 'Notifications'])

@section('toolbarTitle', 'Admin Notifications')
@section('toolbarSubTitle', 'All Notifications')
@section('toolbarPage', 'Notifications List')

@section('content')
    <div id="kt_app_content_container" class="app-container container-fluid mt-5">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">



                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                        <input type="text"
                               id="NotificationSearchInput" class="form-control form-control-solid w-250px ps-13"
                               placeholder="Search...">
                    </div>

                    <div class=" d-flex align-items-end flex-wrap ms-3 ">
                        <button type="button" id="deleteReadNotificationsBtn" class="btn btn-light-danger "
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Read Notifications">
                            <i class="fas fa-trash-alt "></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body py-4">
                <div class="table-responsive">
                    <table id="notifications_table" class="table table-row-bordered gy-5">
                        <thead>
                        <tr class="fw-semibold fs-6 text-muted">
                            <th>#</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Read</th>
                            <th>Date</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <link href="{{url('admin/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet"
          type="text/css"/>
    <script src="{{url('admin/plugins/custom/datatables/datatables.bundle.js')}}"></script>

    <script>
        $(function () {
            let table = $('#notifications_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.notifications.data') }}',
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'title', name: 'data->title'},
                    {data: 'message', name: 'data->message'},
                    {data: 'read_at', name: 'read_at', searchable: false},
                    {data: 'created_at', name: 'created_at'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#NotificationSearchInput').keyup(function () {
                table.search($(this).val()).draw();
            });
        });
    </script>


    <script>
        $('#deleteReadNotificationsBtn').on('click', function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete all read notifications!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes ,Delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.notifications.deleteRead') }}',
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted Successfully!',
                                text: res.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $('#notifications_table').DataTable().ajax.reload();
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Error deleting notifications. Please try again.',
                            });
                        }
                    });
                }
            });
        });
    </script>

@endpush
