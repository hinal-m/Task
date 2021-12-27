@extends('admin.layouts.main')
@section('main')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">User Form</h4>
                            <form class="forms-sample" id="submit_form" action="{{ route('admin.m_store') }}"
                                method="post">
                                @csrf
                                @if (Session::get('success'))
                                    <div class="alert alert-success">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif
                                @if (Session::get('fail'))
                                    <div class="alert alert-success">
                                        {{ Session::get('fail') }}
                                    </div>
                                @endif

                                <div class="form-group">
                                    <label class="form-control-label" style="font-size:13px">NAME</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        placeholder="Enter Name">
                                    @error('name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" style="font-size:13px">AMOUNT</label>
                                    <input type="text" class="form-control" name="amount" value="{{ old('amount') }}"
                                        placeholder="Enter amount">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>
                                            <h5 class="mt-2">Payment Start Date</h5>
                                        </label>
                                        <input type='tax' class="form-control datepicker" name="start_date" id="start_date"
                                            placeholder='Select Date' style='width: 180px;' autocomplete="off">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>
                                            <h5 class="mt-2">Payment End Date</h5>
                                        </label>
                                        <input type='tax' name="end_date" class="form-control datepicker" id='end_date'
                                            placeholder='Select Date' style='width: 180px;' autocomplete="off">
                                    </div>
                                </div>
                                <button type="submit" id="submit" class="btn btn-primary btn-icon-text">
                                    <i class="mdi mdi-file-check btn-icon-prepend" id="submit"></i> Submit </button>
                                <a href="{{ route('admin.m_index') }}" class="btn btn-dark">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                $("#start_date").datepicker({
                    minDate: 0,
                    dateFormat: "yy-mm-dd",

                    onSelect: function(selected) {
                        $("#end_date").datepicker("option", "minDate", selected)
                    }
                });

                $("#end_date").datepicker({
                    dateFormat: "yy-mm-dd",
                    onSelect: function(selected) {
                        $("#start_date").datepicker("option", "maxDate", selected)
                        maxDate + 1;
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $.validator.addMethod("lettersonly", function(value, element) {
                    return this.optional(element) || /^[a-z]+$/i.test(value);
                }, "Letters only please");

                $('#submit_form').validate({
                        rules: {
                            name: {
                                required: true,
                                lettersonly: true
                            },
                            amount: {
                                required: true,
                                digits:true
                            },
                            start_date: {
                                required: true,
                            },
                            end_date: {
                                required: true,
                            },
                        },
                    messages: {
                        'name': {
                            'required': 'Please Enter Your Name'
                        },
                        'amount': {
                            'required': 'Please Enter Your amount'
                        },
                        'start_date': {
                            'required': 'Please Select Start Date'
                        },
                        'end_date': {
                            'required': 'Please Select Start Date'
                        },
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass("is-invalid").removeClass("is-valid");
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).addClass("is-valid").removeClass("is-invalid");
                    },
                    submitHandler: function(form) {
                        register(form);
                    }

                });
            });


            function register(form) {
                $('.text-strong').html('');
                var form = $('#submit_form');
                var formData = new FormData(form[0]);
                swal({
                    title: "Are you sure?",
                    text: "you want to taking the money",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Save!',
                    cancelButtonText: "No, cancel plx!",
                    reverseButtons: true
                }).then((result) => {
                    if (result) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                    .attr('content')
                            },
                            type: 'POST',
                            url: "{{ route('admin.m_store') }}",
                            data: formData,
                            dataType: 'JSON',
                            contentType: false,
                            processData: false,
                            cache: false,
                            success: function(query) {
                                if (query) {
                                    swal("Inserted!",
                                        "Money taking Successfully.",
                                        "success");
                                    window.location.href =
                                        "{{ route('admin.m_index') }}";
                                }
                            },
                            error: function(data) {
                                $.each(data.responseJSON.errors, function(
                                    key, value) {
                                    $('[name=' + key + ']').after(
                                        '<span class="text-strong" style="color:red">' +
                                        value + '</span>')
                                });
                            }
                        });
                    } else {
                        swal("Cancelled", "Your record is safe :)", "error");
                    }
                });
            }
        </script>
    @endpush
@endsection
