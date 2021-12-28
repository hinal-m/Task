@extends('admin.layouts.main')
@section('title','User-index')
@section('main')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> </h3>
            </div>
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 style="font-size:150%;" class="card-title">User Table</h4>
                            <a href="{{ route('admin.create') }}" class="btn btn-dark btn-lg float-right">Add
                                User</a>
                            <section style="padding-top: 38px; padding-right:125px;">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-15">
                                            {!! $dataTable->table(['class' => 'table table-bordered dt-responsive nowrap']) !!}
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

    {!! $dataTable->scripts() !!}
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        $(document).on('click', '#delete', function() {
            var id = $(this).data('id');
            var el = this;
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "{{ route('admin.delete') }}",
                            type: 'POST',
                            dataType: "JSON",
                            data: {
                                'id': id,
                            },
                            cache: false,
                            success: function(data) {
                                if (data) {
                                    window.LaravelDataTables["user-table"].draw();
                                } else {
                                    swal("oops!", "Something went wrong", "error");
                                }
                            }
                        });
                        swal("User data has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        swal("Your data is safe!");
                    }
                });
        });
        //status
        $(document).on('click', '#status', function() {
            var id = $(this).data('id');
            var name = $(this).attr('id', 'asd');
            swal({
                title: "Are you sure?",
                text: "you want to Change Status",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Save!',
                cancelButtonText: "No, cancel plx!",
                reverseButtons: true
            }).then((result) => {
                if (result) {
                    $.ajax({
                        url: "{{ route('admin.status') }}",
                        type: "get",
                        data: {
                            id: id,
                        },
                        dataType: "json",
                        success: function(data) {
                            $("#asd").removeAttr("class");
                            console.log(data.data.status);
                            if (data.data.status == "1") {
                                $("#asd").addClass("btn-sm btn-success status");
                                $(".asd").html("Active");
                            } else {
                                $("#asd").addClass("btn btn-danger status");
                                $(".asd").html("Inactive");
                            }
                            $('#user-table').DataTable().ajax.reload();
                            $(".asd").html(data.status);
                            if (data) {
                                swal("Updated!",
                                    "Status Change Successfully.",
                                    "success");
                                window.location.href =
                                    "{{ route('admin.index') }}";
                            }
                        }
                    });
                } else {
                    swal("Cancelled", "Your Status is safe :)", "error");
                }
            });
        });
    </script>
@endpush
