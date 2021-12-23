@extends('admin.layouts.main')
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
                            <h4 style="font-size:150%;" class="card-title">Interest Table</h4>
                            <a href="{{route('admin.m_create')}}" class="btn btn-dark btn-lg float-right">Taking money at interest</a>
                            <section style="padding-top: 38px; padding-right:125px;">
                                <div class="container">
                                    <div class="row">
                                        <div class="form-group">
                                            <label><strong>Status :</strong></label>
                                            <select id='status' class="form-control status" style="width: 200px">
                                                <option value="">--Select Status--</option>
                                                <option value="1">Paid</option>
                                                <option value="0">Unpaid</option>
                                            </select>
                                        </div>
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
        $(document).on('click', '#deposite', function() {
        var id = $(this).data('id');
        swal({
            title: "Are you sure?",
            text: "you want to Deposite amount",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Save!',
            cancelButtonText: "No, cancel plx!",
            reverseButtons: true
        }).then((result) => {
            if (result) {
                $.ajax({
                    url: "{{route('admin.deposite')}}",
                    type: "get",
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            swal("Paid",
                                "Amount Deposite Succesfuly",
                                "success");
                            window.location.href =
                                "{{ route('admin.m_index')}}";
                        }
                    }
                });
            } else {
                swal("Cancelled", "Your Amount is safe :)", "error");
            }
        });
    });
    $('#moneyinterest-table').on('preXhr.dt', function(e, settings, data){
        data.type = $('.status').val();

    });
    $(document).on('change','.status',function(){
        window.LaravelDataTables['moneyinterest-table'].draw();
        e.prevenDefault();
    });
    </script>
@endpush
